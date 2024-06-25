#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <unistd.h>
#include <sys/types.h>
#include <sys/socket.h>
#include <netinet/in.h>
#include <getopt.h>
#include <time.h>
#include <math.h>
#include "sqlService.h"

#define MAX_CLIENTS 1
#define BUFFER_SIZE 8192
#define MAX_AUTH_ATTEMPTS 3

// TODO: Faire en sorte qu'une demande AUTH obtienne une réponse AUTH Aussi

bool request_ok = false;
bool auth_ok = false;
bool close_connexion = false;

int attempts_auth = 0;

typedef struct {
    char attribute[64];
    char value[8192];
} BodyAttribute;

typedef struct {
    char header[32];
    char path[64];
    char body[BUFFER_SIZE];
} Packet;

static struct option long_options[] = {
    {"help", no_argument, NULL, 'h'},
    {"verbose", no_argument, NULL, 'v'},
    {"port", required_argument, NULL, 'p'},
    {NULL, 0, NULL, 0}
};

char* requested_body;
void (*requested_fonction)(char*, char*, size_t);

void print_usage() {
    printf("Usage: ./server [options]\n"
           "Options:\n"
           "  -p, --port=PORT      Port d'écoute\n"
           "  -v, --verbose        Mode verbeux\n"
           "  -h, --help           Affiche l'aide\n");
}

void print_log(const char *message) {
    time_t now = time(NULL);
    struct tm *tm = localtime(&now);
    char timestamp[20];
    strftime(timestamp, sizeof(timestamp), "%Y-%m-%d %H:%M:%S", tm);
    printf("[%s] %s\n", timestamp, message);
}

bool is_number(char* str) {
    for (int i = 0; i < strlen(str); i++) {
        if (str[i] < '0' || str[i] > '9') {
            return false;
        }
    }
    return true;
}

void parse_request(char* request, Packet* packet) {
    char* token = strtok(request, "\n");

    if (token == NULL) return; // Requête vide

    snprintf(packet->header, sizeof(packet->header), "%s", token);

    token = strtok(NULL, "\n");

    if (token == NULL) return; // Commande sans chemin : OK, etc.

    snprintf(packet->path, sizeof(packet->path), "%s", token);

    token = token + strlen(token) + 1;

    if (*token == '\0') return; // Pas de corps

    snprintf(packet->body, sizeof(packet->body), "%s", token);
}

BodyAttribute* parse_token(const char* body) {
    BodyAttribute* attribute = malloc(sizeof(BodyAttribute));
    if (attribute == NULL) return NULL;

    const char* equals = strchr(body, '=');
    if (equals == NULL) {
        free(attribute);
        return NULL;
    }

    size_t attr_len = equals - body;
    if (attr_len >= sizeof(attribute->attribute)) {
        free(attribute);
        return NULL;
    }

    strncpy(attribute->attribute, body, attr_len);
    attribute->attribute[attr_len] = '\0';

    const char* value = equals + 1;
    strncpy(attribute->value, value, sizeof(attribute->value) - 1);
    attribute->value[sizeof(attribute->value) - 1] = '\0';

    return attribute;
}

bool check_auth(int client_fd, Packet* packet, char* response, size_t response_size) {
    char* token = strtok(packet->body, ";");
    bool check_credentials = false;

    if (token == NULL) {
        snprintf(response, response_size, "Paramètres manquants");
        return false;
    }

    BodyAttribute* connection_method = parse_token(token); // email or api_key
    if (connection_method == NULL) {
        snprintf(response, response_size, "Méthode de connexion manquante\nEmail ou clé API requise");
        return false;
    }

    if (strcmp(connection_method->attribute, "email") == 0) {
        token = strtok(NULL, ";");
        if (token == NULL) {
            snprintf(response, response_size, "Paramètres manquants");
            return false;
        }

        BodyAttribute* password = parse_token(token);
        if (password == NULL) {
            snprintf(response, response_size, "Mot de passe manquant");
            return false;
        }

        char* copy_requested_body = malloc(strlen(requested_body) + 1);
        strcpy(copy_requested_body, requested_body);
        token = strtok(copy_requested_body, ";");
        if (token == NULL) {
            snprintf(response, response_size, "Paramètres manquants");
            return false;
        }

        int user_id = get_user_id_from_email(connection_method->value);
        BodyAttribute* userID = parse_token(token);                 

        if (user_id != atoi(userID->value)) {
            snprintf(response, response_size, "Vous tentez de vous authentifier avec un ID utilisateur qui ne vous appartient pas");
            return false;
        }

        check_credentials = check_user_credentials(connection_method->value, password->value);
    } else if (strcmp(connection_method->attribute, "api_key") == 0) {
        char* copy_requested_body = malloc(strlen(requested_body) + 1);
        strcpy(copy_requested_body, requested_body);
        token = strtok(copy_requested_body, ";");
        if (token == NULL) {
            snprintf(response, response_size, "Paramètres manquants");
            return false;
        }

        int user_id = get_user_id_from_api_key(connection_method->value);
        BodyAttribute* userID = parse_token(token);                 

        if (user_id != atoi(userID->value)) {
            snprintf(response, response_size, "Vous tentez de vous authentifier avec un ID utilisateur qui ne vous appartient pas");
            return false;
        }

        check_credentials = check_user_api_key(connection_method->value);
    } else {
        snprintf(response, response_size, "Méthode de connexion invalide\nEmail ou clé API requise");
        return false;
    }

    if (check_credentials) {
        attempts_auth = 0;

        auth_ok = true;
        snprintf(response, response_size, "AUTH OK\n");

        if (requested_fonction != NULL) {
            requested_fonction(requested_body, response, response_size);
            free(requested_body);
            requested_body = NULL;
            requested_fonction = NULL;
        }
    } else {
        snprintf(response, response_size, "AUTH FAIL\n");
    }

    return auth_ok;
}

void create_apiKey(char* body, char* response, size_t response_size) {
    char* token = strtok(body, ";");
    if (token == NULL) {
        snprintf(response, response_size, "Paramètres manquants");
        return;
    }   

    BodyAttribute* userID = parse_token(token);
    if (userID == NULL) {
        snprintf(response, response_size, "UserID manquant");
        return;
    }

    if (strcmp(userID->attribute, "userID") != 0 || !is_number(userID->value)) {
        snprintf(response, response_size, "UserID invalide\nExemple de corps de requête : userID=1;superAdmin=0;");
        return;
    }

    token = strtok(NULL, ";");
    if (token == NULL) {
        snprintf(response, response_size, "Paramètres manquants");
        return;
    }

    BodyAttribute* superAdmin = parse_token(token);
    if (superAdmin == NULL) {
        snprintf(response, response_size, "SuperAdmin manquant");
        return;
    }

    if (strcmp(superAdmin->attribute, "superAdmin") != 0 || (strcmp(superAdmin->value, "0") != 0 && strcmp(superAdmin->value, "1") != 0)) {
        snprintf(response, response_size, "SuperAdmin invalide\nExemple de corps de requête : userID=1;superAdmin=0;");
        return;
    }

    if (create_api_key(atoi(userID->value), atoi(superAdmin->value))) {
        snprintf(response, response_size, "Clé API créée");
    } else {
        snprintf(response, response_size, "Erreur lors de la création de la clé API");
    }
}

void handle_route(int client_fd, Packet* packet, char* response, size_t response_size) {
    if (strcmp(packet->path, "/api/create-key") == 0) {
        snprintf(response, response_size, "AUTH ?\n");

        requested_body = malloc(strlen(packet->body) + 1);
        strcpy(requested_body, packet->body);
        requested_fonction = create_apiKey;
    } else {
        snprintf(response, response_size, "Route inconnue");
    }
}

void handle_header(int client_fd, Packet* packet, char* response, size_t response_size) {
    if (strcmp(packet->header, "OK ?") == 0) {
        snprintf(response, response_size, "OK\n");
        request_ok = true;
    } else if (!request_ok) {
        snprintf(response, response_size, "BAD REQUEST\ncode=400;message=Requête invalide\nLa connexion n'a pas été initialisée correctement;\n");
        return;
    } else if (strcmp(packet->header, "AUTH") == 0) {
        if (attempts_auth < MAX_AUTH_ATTEMPTS - 1) {
            attempts_auth++;
            check_auth(client_fd, packet, response, response_size);
        } else {
            snprintf(response, response_size, "AUTH KO\n");
            close_connexion = true;
            attempts_auth = 0;

            requested_fonction = NULL;
            free(requested_body);
            requested_body = NULL;
        }
    } else if (strcmp(packet->header, "ENTRYPOINT") == 0) {
        handle_route(client_fd, packet, response, response_size);
    } else {
        snprintf(response, response_size, "BAD REQUEST\ncode=400;message=Requête invalide\nLe header ne correspond pas à une commande connue;\n");

    }
}

void handle_request(int client_fd) {
    char buffer[BUFFER_SIZE];
    int read_bytes = recv(client_fd, buffer, BUFFER_SIZE - 1, 0);

    if (read_bytes < 0) {
        perror("recv");
        close_connexion = true;
    } else if (read_bytes == 0) {
        printf("Connexion fermée par le client\n");
        close_connexion = true;
    } else {
        buffer[read_bytes] = '\0';
        printf("Reçu :\n%s\n", buffer);

        Packet* packet = malloc(sizeof(Packet));
        packet = memset(packet, 0, sizeof(Packet));
        parse_request(buffer, packet);
        
        if (strlen(packet->header) > 0) printf("Header : %s\n", packet->header);
        if (strlen(packet->path) > 0) printf("Path : %s\n", packet->path);
        if (strlen(packet->body) > 0) printf("Body : %s\n", packet->body);
        
        char response_body[BUFFER_SIZE/2];
        char response[BUFFER_SIZE];

        handle_header(client_fd, packet, response_body, sizeof(response_body));

        snprintf(response, BUFFER_SIZE, "%s", response_body);
        printf("Réponse envoyée :\n%s\n", response);
        send(client_fd, response, strlen(response), 0);
    }
}

int main(int argc, char *argv[]) {
    int server_fd, client_fd;
    struct sockaddr_in server_addr, client_addr;
    socklen_t addr_len;
    int port = 8080;
    int verbose = 0;
    bool first_request = true;

    int opt;
    while ((opt = getopt_long(argc, argv, "hvp:", long_options, NULL)) != -1) {
        switch (opt) {
            case 'h':
                print_usage();
                return 0;
            case 'v':
                verbose = 1;
                break;
            case 'p':
                port = atoi(optarg);
                break;
            default:
                print_usage();
                return 1;
        }
    }

    server_fd = socket(AF_INET, SOCK_STREAM, 0);
    if (server_fd < 0) {
        perror("socket");
        return 1;
    }

    memset(&server_addr, 0, sizeof(server_addr));
    server_addr.sin_family = AF_INET;
    server_addr.sin_addr.s_addr = INADDR_ANY;
    server_addr.sin_port = htons(port);

    if (bind(server_fd, (struct sockaddr *)&server_addr, sizeof(server_addr)) < 0) {
        perror("bind");
        return 1;
    }

    if (listen(server_fd, MAX_CLIENTS) < 0) {
        perror("listen");
        return 1;
    }

    printf("Serveur en écoute sur le port %d\n", port);
    print_log("Serveur démarré");

    while (1) {
        printf("En attente d'une connexion...\n");

        addr_len = sizeof(client_addr);
        client_fd = accept(server_fd, (struct sockaddr *)&client_addr, &addr_len);
        if (client_fd < 0) {
            perror("accept");
            continue;
        }
        
        if (first_request) {
            first_request = false;
            printf("Nouvelle connexion\n");
        }
        
        handle_request(client_fd);

        if (close_connexion) { 
            close(client_fd);
            close_connexion = false;
            first_request = true;
            auth_ok = false;
        }
    }

    close(server_fd);

    return 0;
}