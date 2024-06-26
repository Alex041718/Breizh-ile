#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <unistd.h>
#include <sys/types.h>
#include <sys/socket.h>
#include <netinet/in.h>
#include <stdbool.h>
#include <getopt.h>
#include "databaseService.h"
#include "utils.h"

#define MAX_CLIENTS 1 // Maximum number of clients that can connect to the server
#define MAX_AUTH_ATTEMPTS 3 // Maximum number of authentication attempts before closing the connection

#define DEFAULT_SERVER_PORT 8080

#define HEADER_SIZE 64 // 64 bytes header size
#define PATH_BUFFER_SIZE 64 // 64 bytes buffer size
#define BODY_BUFFER_SIZE 4096 // 4KB buffer size
#define RESPONSE_BUFFER_SIZE 1024 * 2048 // 2MB response buffer size, it is a very large buffer size but it is necessary for the housings list for example

// Types definition
typedef struct {
    char attribute[HEADER_SIZE];
    char value[BODY_BUFFER_SIZE];
} BodyAttribute;

typedef struct BodyAttributeList {
    BodyAttribute* attribute;
    struct BodyAttributeList* next;
} BodyAttributeList;

typedef struct {
    char header[HEADER_SIZE];
    char path[PATH_BUFFER_SIZE];
    char body[BODY_BUFFER_SIZE];
} Packet;

typedef struct {
    Packet* requested_packet;
    void (*requested_fonction)(Packet*, char*);
} RequestedOperation;

static struct option long_options[] = {
    {"help", no_argument, NULL, 'h'},
    {"verbose", no_argument, NULL, 'v'},
    {"port", required_argument, NULL, 'p'},
    {NULL, 0, NULL, 0}
};

// Global variables
bool connection_initialized_with_ok = false;
bool authentification_ok = false;
bool connection_closed = false;

bool verbose = false;

int number_authentification_attempts = 0;

int user_id_authentificated = -1;
RequestedOperation* requested_operation = NULL;

// Function prototypes
void handle_header(Packet* packet, char* response);
void handle_request(int socket_client);
void create_user_api_key(Packet* packet, char* response);
void get_list_housings(Packet* packet, char* response);
void get_list_disponibilities(Packet* packet, char* response);

void print_usage() {
    printf("Usage: ./server [options]\n"
           "Options:\n"
           "  -p, --port=PORT      Port d'écoute\n"
           "  -v, --verbose        Mode verbeux\n"
           "  -h, --help           Affiche l'aide\n");
}

void print_log_server(const char *message, enum log_level level) {
    if (verbose) {
        print_log(message, level);
    }
}

Packet* parse_packet(char* buffer) {
    Packet* packet = malloc(sizeof(Packet));
    sscanf(buffer, "%s %s %s", packet->header, packet->path, packet->body);

    return packet;
}

BodyAttributeList* parse_body(char* attribute_string) {
    BodyAttributeList* head = NULL;
    BodyAttributeList* current = NULL;

    // Duplicate the string to avoid modifying the original
    char* copy_attribute_string = strdup(attribute_string);
    if (copy_attribute_string == NULL) return NULL;

    char* token = strtok(copy_attribute_string, ";");
    while (token != NULL) {
        char* equal_sign_index = strchr(token, '=');
        if (equal_sign_index == NULL) {
            free(copy_attribute_string);
            break;
        }

        BodyAttributeList* newNode = malloc(sizeof(BodyAttributeList));
        if (newNode == NULL) {
            free(copy_attribute_string);
            break;
        }

        newNode->attribute = malloc(sizeof(BodyAttribute));
        if (newNode->attribute == NULL) {
            free(newNode);
            free(copy_attribute_string);
            break;
        }

        *equal_sign_index = '\0'; // Replace the equal sign with a null character
        strncpy(newNode->attribute->attribute, token, HEADER_SIZE - 1);
        newNode->attribute->attribute[HEADER_SIZE - 1] = '\0';
        strncpy(newNode->attribute->value, equal_sign_index + 1, BODY_BUFFER_SIZE - 1);
        newNode->attribute->value[BODY_BUFFER_SIZE - 1] = '\0';

        newNode->next = NULL;

        if (head == NULL) {
            head = current = newNode;
        } else {
            current->next = newNode;
            current = newNode;
        }

        token = strtok(NULL, ";");
    }

    free(copy_attribute_string);
    return head;
}

BodyAttribute* get_body_attribute(BodyAttributeList* head, const char* attribute) {
    BodyAttributeList* current = head;
    BodyAttribute* body_attribute = NULL;
    while (current != NULL) {
        if (strcmp(current->attribute->attribute, attribute) == 0) {
            body_attribute = current->attribute;
            break;
        }
        current = current->next;
    }

    return body_attribute;
}

bool check_authentification(Packet* packet, char* response) {
    BodyAttributeList* body_attributes = parse_body(packet->body);
    if (body_attributes == NULL) {
        snprintf(response, RESPONSE_BUFFER_SIZE, "BAD_REQUEST\ncode=400;message=Requête invalide\nLes attributs du corps de la requête sont invalides;\n");
        return false;
    }
    
    if (requested_operation == NULL) {
        snprintf(response, RESPONSE_BUFFER_SIZE, "BAD_REQUEST\ncode=400;message=Requête invalide\nUne requete d'authentification ne peut pas être effectuée sans opération;\n");
        return false;
    }

    BodyAttribute* api_attribute = get_body_attribute(body_attributes, "api-key");
    BodyAttribute* email_attribute = get_body_attribute(body_attributes, "email");
    BodyAttribute* password_attribute = get_body_attribute(body_attributes, "password");

    if (api_attribute != NULL) {
        if (!check_user_api_key(api_attribute->value)) {
            snprintf(response, RESPONSE_BUFFER_SIZE, "AUTH_FAIL\n");
            return false;
        }

        user_id_authentificated = get_user_id_from_api_key(api_attribute->value);
    } else {
        if (email_attribute == NULL || password_attribute == NULL) {
            snprintf(response, RESPONSE_BUFFER_SIZE, "BAD_REQUEST\ncode=400;message=Requête invalide\nLes attributs du corps de la requête sont invalides;\n");
            return false;
        }

        if (!check_user_credentials(email_attribute->value, password_attribute->value)) {
            snprintf(response, RESPONSE_BUFFER_SIZE, "AUTH_FAIL\n");
            return false;
        }

        user_id_authentificated = get_user_id_from_email(email_attribute->value);
    }

    if (user_id_authentificated == -1) {
        snprintf(response, RESPONSE_BUFFER_SIZE, "AUTH_FAIL\n");
        return false;
    }

    snprintf(response, RESPONSE_BUFFER_SIZE, "AUTH_OK\n");

    if (requested_operation->requested_fonction != NULL) {
        requested_operation->requested_fonction(requested_operation->requested_packet, response);

        // Free the memory and reset the requested operation
        free(requested_operation->requested_packet);
        free(requested_operation);
        requested_operation = NULL;
        connection_closed = true;
    }

    return true;
}

void handle_route(Packet* packet, char* response) {
    if (strcmp(packet->path, "/api/create-key") == 0) {
        // This route requires authentication
        snprintf(response, RESPONSE_BUFFER_SIZE, "AUTH?\n");

        // Save the requested operation and packet for later
        requested_operation = malloc(sizeof(RequestedOperation));
        requested_operation->requested_packet = packet;
        requested_operation->requested_fonction = create_user_api_key;
    } else if (strcmp(packet->path, "/api/get-housings") == 0) {
        // This route requires authentication
        snprintf(response, RESPONSE_BUFFER_SIZE, "AUTH?\n");

        // Save the requested operation and packet for later
        requested_operation = malloc(sizeof(RequestedOperation));
        requested_operation->requested_packet = packet;
        requested_operation->requested_fonction = get_list_housings;
    } else if (strcmp(packet->path, "/api/get-disponibilities") == 0) {
        // This route requires authentication
        snprintf(response, RESPONSE_BUFFER_SIZE, "AUTH?\n");

        // Save the requested operation and packet for later
        requested_operation = malloc(sizeof(RequestedOperation));
        requested_operation->requested_packet = packet;
        requested_operation->requested_fonction = get_list_disponibilities;
    } else {
        snprintf(response, RESPONSE_BUFFER_SIZE, "BAD_REQUEST\ncode=400;message=Requête invalide\nLa route demandée n'existe pas;\n");
    }
}

void handle_header(Packet* packet, char* response) {
    if (strcmp(packet->header, "OK?") == 0) {
        snprintf(response, RESPONSE_BUFFER_SIZE, "OK\n");
        connection_initialized_with_ok = true;
    } else if (!connection_initialized_with_ok) {
        snprintf(response, RESPONSE_BUFFER_SIZE, "BAD_REQUEST\ncode=400;message=Requête invalide\nLa connexion n'a pas été initialisée correctement;\n");
        return;
    } else if (strcmp(packet->header, "AUTH") == 0) {
        if (number_authentification_attempts < MAX_AUTH_ATTEMPTS - 1) {
            number_authentification_attempts++;
            authentification_ok = check_authentification(packet, response);
        } else {
            snprintf(response, RESPONSE_BUFFER_SIZE, "AUTH_KO\n");
            connection_closed = true;

            // Free the memory and reset the requested operation
            free(requested_operation->requested_packet);
            free(requested_operation);
            requested_operation = NULL;
        }
    } else if (strcmp(packet->header, "ENTRYPOINT") == 0) {
        handle_route(packet, response);
    } else {
        snprintf(response, RESPONSE_BUFFER_SIZE, "BAD_REQUEST\ncode=400;message=Requête invalide\nLe header ne correspond pas à une commande connue;\n");
    }
}

void handle_request(int socket_client) {
    char buffer[BODY_BUFFER_SIZE];
    char response[RESPONSE_BUFFER_SIZE];
    char log_message[RESPONSE_BUFFER_SIZE*2];

    // Receive the message
    memset(buffer, 0, sizeof(buffer));
    int bytes_received = recv(socket_client, buffer, sizeof(buffer), 0);

    if (bytes_received < 0) {
        perror("Erreur lors de la réception du message");
        connection_closed = true;
        return;
    } else if (bytes_received == 0) {
        print_log_server("Connexion fermée par le client", INFO);
        connection_closed = true;
        return;
    }

    snprintf(log_message, sizeof(log_message), "Message brute reçu: %s", buffer);
    print_log_server(log_message, INFO);
    memset(response, 0, sizeof(response));
    
    // Parse the packet
    Packet* packet = parse_packet(buffer);
    if (packet == NULL) {
        print_log_server("Erreur lors du parsing du paquet, les données reçues sont invalides.", ERROR);
        connection_closed = true;
        return;
    }

    snprintf(log_message, sizeof(log_message), "Header: %s, Path: %s, Body: %s", packet->header, packet->path, packet->body);
    print_log_server(log_message, INFO);
    memset(log_message, 0, sizeof(log_message));

    handle_header(packet, response);

    // Send the response
    snprintf(log_message, sizeof(log_message), "Réponse envoyée: %s", response);
    print_log_server(log_message, INFO);
    memset(log_message, 0, sizeof(log_message));

    send(socket_client, response, strlen(response), 0);
}

void create_user_api_key(Packet* packet, char* response) {
    BodyAttributeList* body_attributes = parse_body(packet->body);
    if (body_attributes == NULL) {
        snprintf(response, RESPONSE_BUFFER_SIZE, "BAD_REQUEST\ncode=400;message=Requête invalide\nLes attributs du corps de la requête sont invalides;\n");
        return;
    }

    // Get the user ID attribute
    BodyAttribute* user_id_attribute = get_body_attribute(body_attributes, "userID");
    if (user_id_attribute == NULL) {
        snprintf(response, RESPONSE_BUFFER_SIZE, "BAD_REQUEST\ncode=400;message=Requête invalide\nL'attribut 'userID' est manquant;\n");
        return;
    }

    if (!is_number(user_id_attribute->value)) {
        snprintf(response, RESPONSE_BUFFER_SIZE, "BAD_REQUEST\ncode=400;message=Requête invalide\nLa valeur de l'attribut 'userID' n'est pas un nombre;\n");
        return;
    }

    if (user_id_authentificated != atoi(user_id_attribute->value)) {
        snprintf(response, RESPONSE_BUFFER_SIZE, "BAD_REQUEST\ncode=403;message=Accès interdit\nVous n'avez pas les droits pour effectuer cette action;\n");
        return;
    }

    // Get the superAdmin attribute
    BodyAttribute* super_admin_attribute = get_body_attribute(body_attributes, "superAdmin");
    if (super_admin_attribute == NULL) {
        snprintf(response, RESPONSE_BUFFER_SIZE, "BAD_REQUEST\ncode=400;message=Requête invalide\nL'attribut 'superAdmin' est manquant;\n");
        return;
    }

    if (strcmp(super_admin_attribute->value, "0") != 0 && strcmp(super_admin_attribute->value, "1") != 0) {
        snprintf(response, RESPONSE_BUFFER_SIZE, "BAD_REQUEST\ncode=400;message=Requête invalide\nLa valeur de l'attribut 'superAdmin' n'est pas valide, elle doit être '0' ou '1';\n");
        return;
    }

    if (atoi(super_admin_attribute->value) && !is_user_admin(user_id_authentificated)) {
        snprintf(response, RESPONSE_BUFFER_SIZE, "BAD_REQUEST\ncode=403;message=Accès interdit\nVous n'avez pas les droits pour effectuer cette action;\n");
        return;
    }

    // We try to create the API key
    if (!create_api_key(atoi(user_id_attribute->value), atoi(super_admin_attribute->value))) {
        snprintf(response, RESPONSE_BUFFER_SIZE, "INTERNAL_SERVER_ERROR\ncode=500;message=Erreur interne du serveur\nLa clé API n'a pas pu être créée;\n");
        return;
    }

    snprintf(response, RESPONSE_BUFFER_SIZE, "OK\ncode=200;message=Clé API créée avec succès\nLa clé API a été créée avec succès;\n");
}

void get_list_housings(Packet* packet, char* response) {
    BodyAttributeList* body_attributes = parse_body(packet->body);
    if (body_attributes == NULL) {
        snprintf(response, RESPONSE_BUFFER_SIZE, "BAD_REQUEST\ncode=400;message=Requête invalide\nLes attributs du corps de la requête sont invalides;\n");
        return;
    }

    // Get the user ID attribute
    BodyAttribute* user_id_attribute = get_body_attribute(body_attributes, "userID");
    if (user_id_attribute == NULL) {
        snprintf(response, RESPONSE_BUFFER_SIZE, "BAD_REQUEST\ncode=400;message=Requête invalide\nL'attribut 'userID' est manquant;\n");
        return;
    }

    if (!is_number(user_id_attribute->value)) {
        snprintf(response, RESPONSE_BUFFER_SIZE, "BAD_REQUEST\ncode=400;message=Requête invalide\nLa valeur de l'attribut 'userID' n'est pas un nombre;\n");
        return;
    }

    if (user_id_authentificated != atoi(user_id_attribute->value)) {
        snprintf(response, RESPONSE_BUFFER_SIZE, "BAD_REQUEST\ncode=403;message=Accès interdit\nVous n'avez pas les droits pour effectuer cette action;\n");
        return;
    }

    // Get the superAdmin attribute
    BodyAttribute* super_admin_attribute = get_body_attribute(body_attributes, "superAdmin");
    if (super_admin_attribute == NULL) {
        snprintf(response, RESPONSE_BUFFER_SIZE, "BAD_REQUEST\ncode=400;message=Requête invalide\nL'attribut 'superAdmin' est manquant;\n");
        return;
    }

    if (strcmp(super_admin_attribute->value, "0") != 0 && strcmp(super_admin_attribute->value, "1") != 0) {
        snprintf(response, RESPONSE_BUFFER_SIZE, "BAD_REQUEST\ncode=400;message=Requête invalide\nLa valeur de l'attribut 'superAdmin' n'est pas valide, elle doit être '0' ou '1';\n");
        return;
    }

    if (atoi(super_admin_attribute->value) && !is_user_admin(user_id_authentificated)) {
        snprintf(response, RESPONSE_BUFFER_SIZE, "BAD_REQUEST\ncode=403;message=Accès interdit\nVous n'avez pas les droits pour effectuer cette action;\n");
        return;
    }

    // We try to get the housings
    char* housings = get_housings(atoi(user_id_attribute->value), atoi(super_admin_attribute->value));
    if (housings == NULL) {
        snprintf(response, RESPONSE_BUFFER_SIZE, "INTERNAL_SERVER_ERROR\ncode=500;message=Erreur interne du serveur\nLes logements n'ont pas pu être récupérés;\n");
        return;
    }

    snprintf(response, RESPONSE_BUFFER_SIZE, "OK\ncode=200;message=Logements récupérés avec succès\n%s\n", housings);
}

void get_list_disponibilities(Packet* packet, char* response) {
    BodyAttributeList* body_attributes = parse_body(packet->body);
    if (body_attributes == NULL) {
        snprintf(response, RESPONSE_BUFFER_SIZE, "BAD_REQUEST\ncode=400;message=Requête invalide\nLes attributs du corps de la requête sont invalides;\n");
        return;
    }

    // Get the housing ID attribute
    BodyAttribute* housing_id_attribute = get_body_attribute(body_attributes, "housingID");
    if (housing_id_attribute == NULL) {
        snprintf(response, RESPONSE_BUFFER_SIZE, "BAD_REQUEST\ncode=400;message=Requête invalide\nL'attribut 'housingID' est manquant;\n");
        return;
    }

    if (!is_number(housing_id_attribute->value)) {
        snprintf(response, RESPONSE_BUFFER_SIZE, "BAD_REQUEST\ncode=400;message=Requête invalide\nLa valeur de l'attribut 'housingID' n'est pas un nombre;\n");
        return;
    }

    if (user_id_authentificated != get_user_id_from_housing_id(atoi(housing_id_attribute->value))) {
        snprintf(response, RESPONSE_BUFFER_SIZE, "BAD_REQUEST\ncode=403;message=Accès interdit\nVous n'avez pas les droits pour effectuer cette action;\n");
        return;
    }

    // Get starting_date and ending_date attributes
    BodyAttribute* starting_date_attribute = get_body_attribute(body_attributes, "starting-date");
    BodyAttribute* ending_date_attribute = get_body_attribute(body_attributes, "ending-date");

    if (starting_date_attribute == NULL || ending_date_attribute == NULL) {
        snprintf(response, RESPONSE_BUFFER_SIZE, "BAD_REQUEST\ncode=400;message=Requête invalide\nLes attributs 'starting_date' et 'ending_date' sont manquants;\n");
        return;
    }

    // We try to get the disponibilities
    char* disponibilities = get_disponibility_housing(atoi(housing_id_attribute->value), starting_date_attribute->value, ending_date_attribute->value);
    if (disponibilities == NULL) {
        snprintf(response, RESPONSE_BUFFER_SIZE, "INTERNAL_SERVER_ERROR\ncode=500;message=Erreur interne du serveur\nLes disponibilités n'ont pas pu être récupérées;\n");
        return;
    }

    snprintf(response, RESPONSE_BUFFER_SIZE, "OK\ncode=200;message=Disponibilités récupérées avec succès\n%s\n", disponibilities);
}

int main(int argc, char* argv[]) {
    int socket_server, socket_client;
    struct sockaddr_in server_address_configuration, client_address_configuration;
    socklen_t client_address_size;

    int server_port = DEFAULT_SERVER_PORT;

    bool first_request = true;

    int option_index = 0;
    while ((option_index = getopt_long(argc, argv, "p:vh", long_options, NULL)) != -1) {
        switch (option_index) {
            case 'p':
                server_port = atoi(optarg);
                break;
            case 'v':
                verbose = true;
                break;
            case 'h':
                print_usage();
                return 0;
            default:
                print_usage();
                return 1;
        }
    }

    // Create the socket
    socket_server = socket(AF_INET, SOCK_STREAM, 0);
    if (socket_server < 0) {
        perror("Erreur lors de la création du socket serveur");
        return 1;
    }

    // Configure the server address
    memset(&server_address_configuration, 0, sizeof(server_address_configuration)); // Initialize the server address configuration
    server_address_configuration.sin_family = AF_INET; // Set the address family to AF_INET (IPv4)
    server_address_configuration.sin_addr.s_addr = INADDR_ANY; // Set the IP address to INADDR_ANY (any available IP address)
    server_address_configuration.sin_port = htons(server_port); // Set the port number

    // Bind the socket to the server address
    if (bind(socket_server, (struct sockaddr*)&server_address_configuration, sizeof(server_address_configuration)) < 0) {
        perror("Erreur lors de la liaison du socket au serveur");
        return 1;
    }

    // Listen for incoming connections
    if (listen(socket_server, MAX_CLIENTS) < 0) {
        perror("Erreur lors de l'écoute des connexions entrantes");
        return 1;
    }

    char log_message[256];
    snprintf(log_message, sizeof(log_message), "Serveur démarré sur le port %d", server_port);
    print_log_server(log_message, INFO);

    while (true) {
        print_log_server("En attente d'une connexion...", INFO);

        // Accept the incoming connection
        client_address_size = sizeof(client_address_configuration);
        socket_client = accept(socket_server, (struct sockaddr*)&client_address_configuration, &client_address_size);
        if (socket_client < 0) {
            perror("Erreur lors de l'acceptation de la connexion entrante");
            continue;
        }

        if (first_request) {
            first_request = false;
            print_log_server("Nouvelle connexion", INFO);
        }

        // Receive the message
        handle_request(socket_client);

        // Close the connection
        if (connection_closed) {
            print_log_server("Fermeture de la connexion", INFO);
            close(socket_client);
            connection_closed = false;
            first_request = true;
            authentification_ok = false;
            connection_initialized_with_ok = false;
            number_authentification_attempts = 0;
        }
    }

    close(socket_server);

    return 0;
}