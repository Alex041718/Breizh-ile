#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <stdbool.h>
#include <unistd.h>
#include <arpa/inet.h>
#include <sys/socket.h>
#include "dotenv.h"
#include "utils.h"

#define SERVER_IP "127.0.0.1"
#define SERVER_PORT 8081
#define BUFFER_SIZE 4096

#define RESET "\033[0m"
#define RED "\033[31m"
#define YELLOW "\033[33m"
#define GREEN "\033[32m"
#define CYAN "\033[36m"

typedef struct {
    char header[32];
    char path[64];
    char body[BUFFER_SIZE];
} Packet;

// Prototypes de fonctions
void print_title();
void handle_menu();
bool is_server_ok();
void send_custom_request();
void send_request(Packet* packet, char* response);
void authenticate();
void create_api_key();
void get_housings();
void disconnect();

int main() {
    print_title();
    return 0;
}

void print_title() {
    system("clear");
    printf("███████╗██╗   ██╗███╗   ██╗██╗  ██╗██████╗  ██████╗ ███╗   ██╗██╗███████╗ █████╗ ████████╗ ██████╗ ██████╗ \n");
    printf("██╔════╝╚██╗ ██╔╝████╗  ██║██║ ██╔╝██╔══██╗██╔═══██╗████╗  ██║██║╚══███╔╝██╔══██╗╚══██╔══╝██╔═══██╗██╔══██╗\n");
    printf("███████╗ ╚████╔╝ ██╔██╗ ██║█████╔╝ ██████╔╝██║   ██║██╔██╗ ██║██║  ███╔╝ ███████║   ██║   ██║   ██║██████╔╝\n");
    printf("╚════██║  ╚██╔╝  ██║╚██╗██║██╔═██╗ ██╔══██╗██║   ██║██║╚██╗██║██║ ███╔╝  ██╔══██║   ██║   ██║   ██║██╔══██╗\n");
    printf("███████║   ██║   ██║ ╚████║██║  ██╗██║  ██║╚██████╔╝██║ ╚████║██║███████╗██║  ██║   ██║   ╚██████╔╝██║  ██║\n");
    printf("╚══════╝   ╚═╝   ╚═╝  ╚═══╝╚═╝  ╚═╝╚═╝  ╚═╝ ╚═════╝ ╚═╝  ╚═══╝╚═╝╚══════╝╚═╝  ╚═╝   ╚═╝    ╚═════╝ ╚═╝  ╚═╝\n");
    printf("by CrêpeTech\n\n");

    handle_menu();
}

void print_help() {
    printf("Commandes disponibles:\n");
    printf("  ping            - Vérifier l'état du serveur\n");
    printf("  custom          - Envoyer une requête personnalisée\n");
    printf("  auth            - S'authentifier (email/mot de passe ou clé API)\n");
    printf("  create-api-key  - Créer une nouvelle clé API\n");
    printf("  get-housings    - Obtenir la liste des logements\n");
    printf("  disconnect      - Se déconnecter\n");
    printf("  help            - Afficher cette aide\n");
    printf("  clear           - Effacer l'écran\n");
    printf("  exit            - Quitter le programme\n");
}

void handle_menu() {
    char choice[40];
    
    while (1) {
        printf("> ");
        fgets(choice, sizeof(choice), stdin);
        choice[strcspn(choice, "\n")] = 0;

        if (strcmp(choice, "ping") == 0) {
            is_server_ok();
        } else if (strcmp(choice, "custom") == 0) {
            send_custom_request();
        } else if (strcmp(choice, "auth") == 0) {
            authenticate();
        } else if (strcmp(choice, "create-api-key") == 0) {
            create_api_key();
        } else if (strcmp(choice, "get-housings") == 0) {
            get_housings();
        } else if (strcmp(choice, "disconnect") == 0) {
            disconnect();
        } else if (strcmp(choice, "help") == 0) {
            print_help();
        } else if (strcmp(choice, "clear") == 0) {
            print_title();
        } else if (strcmp(choice, "exit") == 0) {
            printf("Au revoir!\n");
            exit(0);
        } else {
            printf(RED "Commande inconnue\n" RESET);
            print_help();
        }
        
        printf("\n");
    }
}

bool is_server_ok() {
    char response[BUFFER_SIZE] = {0};
    Packet* packet = malloc(sizeof(Packet));
    strcpy(packet->header, "OK?");

    printf("Vérification du serveur\n");
    send_request(packet, response);

    printf("Réponse reçue: %s\n", response);

    if (strcmp(response, "OK\n") == 0) {
        printf(GREEN "Serveur en ligne\n" RESET);
        return true;
    } else {
        printf(RED "Serveur hors ligne\n" RESET);
        return false;
    }
}

void send_custom_request() {
    Packet* packet = malloc(sizeof(Packet));
    char response[BUFFER_SIZE];

    printf("Entrez l'en-tête: ");
    fgets(packet->header, sizeof(packet->header), stdin);
    packet->header[strcspn(packet->header, "\n")] = 0;

    printf("Entrez le chemin: ");
    fgets(packet->path, sizeof(packet->path), stdin);
    packet->path[strcspn(packet->path, "\n")] = 0;

    printf("Entrez le corps:  ");
    fgets(packet->body, sizeof(packet->body), stdin);
    packet->body[strcspn(packet->body, "\n")] = 0;

    send_request(packet, response);
    printf("Réponse reçue: %s\n", response);
}

void send_request(Packet* packet, char* response) {
    int sock = 0;
    struct sockaddr_in serv_addr;
    char buffer[BUFFER_SIZE] = {0};
    char message[BUFFER_SIZE*2] = {0};
    
    if ((sock = socket(AF_INET, SOCK_STREAM, 0)) < 0) {
        printf(RED "Erreur de création du socket\n" RESET);
        return;
    }
   
    serv_addr.sin_family = AF_INET;
    serv_addr.sin_port = htons(SERVER_PORT);
       
    if(inet_pton(AF_INET, SERVER_IP, &serv_addr.sin_addr) <= 0) {
        printf(RED "Adresse invalide / Adresse non supportée\n" RESET);
        close(sock);
        return;
    }
   
    if (connect(sock, (struct sockaddr *)&serv_addr, sizeof(serv_addr)) < 0) {
        printf(RED "La connexion a échoué\n" RESET);
        close(sock);
        return;
    }
   
    // Envoyer le message
    if (strlen(packet->path) > 0 || strlen(packet->body) > 0) {
        snprintf(message, BUFFER_SIZE*2, "%s\n%s\n%s\n", packet->header, packet->path, packet->body);
    } else if (strlen(packet->header) > 0) {
        snprintf(message, BUFFER_SIZE*2, "%s\n", packet->header);
    }

    send(sock, message, strlen(message), 0);
    printf("Message envoyé: \n%s\n", message);
    
    // Recevoir la réponse
    memset(buffer, 0, BUFFER_SIZE);
    int valread = read(sock, buffer, BUFFER_SIZE);
    snprintf(response, BUFFER_SIZE, "%s", buffer);

    if (strcmp(response, "AUTH?\n") == 0) {
        printf("Authentification requise\n");
        authenticate(response);
    }

    close(sock);
}

void authenticate(char* response) {
    char auth_type[10];
    char credentials[256];
    
    Packet* packet = malloc(sizeof(Packet));
    strcpy(packet->header, "AUTH");
    strcpy(packet->path, "/api/auth");

    printf("Choisissez le type d'authentification (email/api): ");
    fgets(auth_type, sizeof(auth_type), stdin);
    auth_type[strcspn(auth_type, "\n")] = 0;

    if (strcmp(auth_type, "email") == 0) {
        char email[64], password[64];
        printf("Entrez votre email: ");
        fgets(email, sizeof(email), stdin);
        email[strcspn(email, "\n")] = 0;

        printf("Entrez votre mot de passe: ");
        fgets(password, sizeof(password), stdin);
        password[strcspn(password, "\n")] = 0;

        snprintf(credentials, sizeof(credentials), "email=%s;password=%s;", email, password);
    } else if (strcmp(auth_type, "api") == 0) {
        char api_key[66];
        printf("Entrez votre clé API: ");
        fgets(api_key, sizeof(api_key), stdin);
        api_key[strcspn(api_key, "\n")] = 0;

        snprintf(credentials, sizeof(credentials), "api-key=%s;", api_key);
    } else {
        printf(RED "Type d'authentification invalide\n" RESET);
        return;
    }

    snprintf(packet->body, sizeof(packet->body), "%s", credentials);
    send_request(packet, response);

    if (strcmp(response, "AUTH_OK\n") == 0) {
        printf(GREEN "Authentification réussie\n" RESET);
        setenv("AUTH_CREDENTIALS", credentials, 1);
    } else if (strcmp(response, "AUTH_FAIL\n") == 0) {
        printf(RED "Authentification échouée\n" RESET);
    } else if (strcmp(response, "AUTH_KO\n") == 0) {
        printf(RED "Trop de tentatives d'authentification\nLa connexion est fermée\n" RESET);
    }
}

void create_api_key() {
    char user_id[10], is_superadmin[3];
    Packet* packet = malloc(sizeof(Packet));
    strcpy(packet->header, "ENTRYPOINT");
    strcpy(packet->path, "/api/create-key");
    char response[BUFFER_SIZE];

    if (!is_server_ok()) return;

    do {
        printf("Entrez l'ID de l'utilisateur: ");
        fgets(user_id, sizeof(user_id), stdin);
        user_id[strcspn(user_id, "\n")] = 0;
    } while (strcmp(user_id, "0") == 0 || !is_number(user_id));

    do {
        printf("Entrez le rôle de l'utilisateur (1 pour superadmin, 0 pour propriétaire): ");
        fgets(is_superadmin, sizeof(is_superadmin), stdin);
        is_superadmin[strcspn(is_superadmin, "\n")] = 0;
    } while (strcmp(is_superadmin, "1") != 0 && strcmp(is_superadmin, "0") != 0);

    snprintf(packet->body, sizeof(packet->body), "userID=%s;superAdmin=%s;", user_id, is_superadmin);
    send_request(packet, response);
    
    printf("Réponse reçue: %s\n", response);
}

void get_housings() {
    Packet* packet = malloc(sizeof(Packet));
    strcpy(packet->header, "ENTRYPOINT");
    strcpy(packet->path, "/api/get-housings");
    char response[BUFFER_SIZE];

    if (!is_server_ok()) return;

    send_request(packet, response);
    printf("Liste des logements:\n%s\n", response);
}

void disconnect() {
    if (getenv("AUTH_CREDENTIALS") != NULL) {
        unsetenv("AUTH_CREDENTIALS");
        printf(GREEN "Déconnexion réussie\n" RESET);
    } else {
        printf(YELLOW "Vous n'êtes pas connecté\n" RESET);
    }
}