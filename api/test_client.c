#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <stdbool.h>
#include <unistd.h>
#include <arpa/inet.h>
#include <sys/socket.h>
#include "dotenv.h"

#define SERVER_IP "127.0.0.1"
#define SERVER_PORT 8081
#define BUFFER_SIZE 4096

#define RESET "\033[0m"
#define RED "\033[31m"
#define GREEN "\033[32m"
#define CYAN "\033[36m"

typedef struct {
    char header[32];
    char path[64];
    char body[BUFFER_SIZE];
} Packet;

void print_title();
bool is_server_ok();
void send_custom_request();
void send_request(Packet* packet, char* response);
void create_api_key();

void print_help() {
    printf("Commandes disponibles:\n");
    printf("  ping\n");
    printf("  custom\n");
    printf("  create-api-key\n");
    printf("  help\n");
    printf("  clear\n");
    printf("  exit\n");
}

void handle_menu() {
    printf("> ");

    char choice[40];
    fgets(choice, 40, stdin);

    printf("\n");
    
    if (strcmp(choice, "ping\n") == 0) {
        is_server_ok();
    } else if (strcmp(choice, "custom\n") == 0) {
        send_custom_request();
    } else if (strcmp(choice, "create-api-key\n") == 0) {
        printf("Création d'une clé API\n");
        create_api_key();
    } else if (strcmp(choice, "help\n") == 0) {
        print_help();
    } else if (strcmp(choice, "clear\n") == 0) {
        print_title();
    } else if (strcmp(choice, "exit\n") == 0) {
        printf("Bye!\n");
        exit(0);
    } else {
        printf(RED "Commande inconnue\n" RESET);
        print_help();
    }

    printf("\n");
    handle_menu();
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

void send_custom_request() {
    char header[32];
    char path[64];
    char body[BUFFER_SIZE];
    char response[BUFFER_SIZE];

    printf("Entrez l'en-tête: ");
    fgets(header, 32, stdin);
    header[strlen(header)-1] = '\0';

    printf("Entrez le chemin: ");
    fgets(path, 64, stdin);
    path[strlen(path)-1] = '\0';

    printf("Entrez le corps:  ");
    fgets(body, BUFFER_SIZE, stdin);
    body[strlen(body)-1] = '\0';

    Packet* packet = malloc(sizeof(Packet));
    snprintf(packet->header, sizeof(packet->header), "%s", header);
    snprintf(packet->path, sizeof(packet->path), "%s", path);
    snprintf(packet->body, sizeof(packet->body), "%s", body);

    send_request(packet, response);
    printf("Réponse reçue: %s\n", response);
}

bool is_server_ok() {
    bool server_ok = false;
    char response[BUFFER_SIZE] = {0};

    Packet* packet = malloc(sizeof(Packet));
    strncpy(packet->header, "OK?", sizeof(packet->header));

    printf("Vérification du serveur\n");
    send_request(packet, response);

    if (strcmp(response, "OK\n") == 0) {
        printf(GREEN "Serveur en ligne\n" RESET);
        server_ok = true;
    } else {
        printf(RED "Serveur hors ligne\n" RESET);
    }

    return server_ok;
}

void ask_auth(char* response) {
    char email[64];
    char password[64];

    Packet* packet = malloc(sizeof(Packet));
    strncpy(packet->header, "AUTH", sizeof(packet->header));
    strncpy(packet->path, "/api/auth", sizeof(packet->path));

    if (getenv("EMAIL") == NULL || getenv("PASSWORD") == NULL) {
        printf("Entrez votre email: ");
        fgets(email, 64, stdin);
        email[strlen(email)-1] = '\0';

        printf("Entrez votre mot de passe: ");
        fgets(password, 64, stdin);
        password[strlen(password)-1] = '\0';

        setenv("EMAIL", email, 1);
        setenv("PASSWORD", password, 1);
    } else {
        snprintf(email, 64, "%s", getenv("EMAIL"));
        snprintf(password, 64, "%s", getenv("PASSWORD"));
    }

    snprintf(packet->body, BUFFER_SIZE, "email=%s;password=%s;", email, password);

    send_request(packet, response);
}

void send_request(Packet* packet, char* response) {
    int sock = 0;
    struct sockaddr_in serv_addr;
    char buffer[BUFFER_SIZE] = {0};
    char message[BUFFER_SIZE*2] = {0};
    
    // Créer le socket
    if ((sock = socket(AF_INET, SOCK_STREAM, 0)) < 0) {
        printf("\n Erreur de création du socket \n");
        return;
    }
   
    serv_addr.sin_family = AF_INET;
    serv_addr.sin_port = htons(SERVER_PORT);
       
    // Convertir l'adresse IP de texte à binaire
    if(inet_pton(AF_INET, SERVER_IP, &serv_addr.sin_addr) <= 0) {
        printf("\nAdresse invalide / Adresse non supportée \n");
        return;
    }
   
    // Connecter au serveur
    if (connect(sock, (struct sockaddr *)&serv_addr, sizeof(serv_addr)) < 0) {
        printf("\nLa connexion a échoué \n");
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
        ask_auth(response);
    } else if (strcmp(response, "AUTH FAIL\n") == 0) {
        printf(RED "Authentification échouée\n" RESET);
        ask_auth(response);
    } else if (strcmp(response, "AUTH OK\n") == 0) {
        printf(GREEN "Authentification réussie\n" RESET);
    }

    close(sock);
}

bool is_number(char* str) {
    for (int i = 0; i < strlen(str); i++) {
        if (str[i] < '0' || str[i] > '9') {
            return false;
        }
    }
    return true;
}

void create_api_key() {
    char user_id[10];
    char is_superadmin[3];
    char body[BUFFER_SIZE];

    if (!is_server_ok()) return;

    printf("Entrez l'ID de l'utilisateur: ");
    fgets(user_id, 10, stdin);
    user_id[strlen(user_id)-1] = '\0';

    // check if user_id is a number, if not ask again
    while (strcmp(user_id, "0") == 0 || !is_number(user_id)) {
        memset(user_id, 0, sizeof(user_id));
        printf(RED "L'ID de l'utilisateur doit être un nombre supérieure à 0\n" RESET);
        printf("Entrez l'ID de l'utilisateur: ");
        fgets(user_id, 10, stdin);
        user_id[strlen(user_id)-1] = '\0';
    }

    printf("Entrez le rôle de l'utilisateur (1 pour superadmin, 0 pour proprietaire): ");
    fgets(is_superadmin, 3, stdin);
    is_superadmin[strlen(is_superadmin)-1] = '\0';

    while (strcmp(is_superadmin, "1") != 0 && strcmp(is_superadmin, "0") != 0) {
        memset(is_superadmin, 0, sizeof(is_superadmin));
        printf(RED "Le rôle de l'utilisateur doit être 1 ou 0\n" RESET);
        printf("Entrez le rôle de l'utilisateur (1 pour superadmin, 0 pour proprietaire): ");
        fgets(is_superadmin, 3, stdin);
        is_superadmin[strlen(is_superadmin)-1] = '\0';
    }

    printf("ID: %s\n", user_id);
    printf("Superadmin: %s\n", is_superadmin);

    snprintf(body, BUFFER_SIZE, "userID=%d;superAdmin=%d;", atoi(user_id), atoi(is_superadmin));

    Packet* packet = malloc(sizeof(Packet));
    snprintf(packet->header, sizeof(packet->header), "ENTRYPOINT");
    snprintf(packet->path, sizeof(packet->path), "/api/create-key");
    snprintf(packet->body, sizeof(packet->body), "%s", body);

    char response[BUFFER_SIZE];
    send_request(packet, response);
    
    printf("Réponse reçue: %s\n", response);
}

int main() {
    print_title();
    return 0;
}