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
#include "cJSON.h" // https://github.com/DaveGamble/cJSON
#include "sqlService.h"

#define MAX_CLIENTS 1
#define BUFFER_SIZE 2048

static struct option long_options[] = {
    {"help", no_argument, NULL, 'h'},
    {"verbose", no_argument, NULL, 'v'},
    {"port", required_argument, NULL, 'p'},
    {NULL, 0, NULL, 0}
};

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

void parse_request(char* request, char* method, char* path, char* headers, char* body) {
    char* pos = strstr(request, "\r\n\r\n");
    if (pos != NULL) {
        *pos = '\0'; // Terminer la chaîne de l'en-tête
        strcpy(headers, request); // Copier l'en-tête
        pos += 4; // Sauter les deux sauts de ligne après l'en-tête
        strcpy(body, pos); // Copier le corps
    }

    // Extraire la méthode et le chemin de la première ligne de l'en-tête
    char* first_line = strtok(headers, "\r\n");
    if (first_line != NULL) {
        char* method_token = strtok(first_line, " ");
        if (method_token != NULL) {
            strcpy(method, method_token);
        }
        char* path_token = strtok(NULL, " ");
        if (path_token != NULL) {
            strcpy(path, path_token);
        }
    }
}

void create_apiKey(const cJSON* body, char* response, size_t response_size) {
    if (!cJSON_HasObjectItem(body, "userID") || !cJSON_HasObjectItem(body, "superAdmin")) {
        snprintf(response, response_size, "Paramètres manquants");
        return;
    }
    
    const cJSON* userID_item = cJSON_GetObjectItemCaseSensitive(body, "userID");
    const cJSON* superAdmin_item = cJSON_GetObjectItemCaseSensitive(body, "superAdmin");

    if (!cJSON_IsNumber(userID_item) || !cJSON_IsBool(superAdmin_item)) {
        snprintf(response, response_size, "Paramètres invalides");
        return;
    }

    int userID = cJSON_GetNumberValue(userID_item);
    bool createSuperAdmin = cJSON_IsTrue(superAdmin_item);

    if (create_api_key(userID, createSuperAdmin)) {
        snprintf(response, response_size, "Clé API créée");
    } else {
        snprintf(response, response_size, "Erreur lors de la création de la clé API");
    }
}

void handle_route(const char* path, const cJSON* body, char* response, size_t response_size) {
    if (strcmp(path, "/api/create-key") == 0) {
        create_apiKey(body, response, response_size);
    } else {
        snprintf(response, response_size, "Route inconnue");
    }
}

void handle_request(int client_fd) {
    char buffer[BUFFER_SIZE];
    int read_bytes = recv(client_fd, buffer, BUFFER_SIZE - 1, 0);
    if (read_bytes < 0) {
        perror("recv");
    } else if (read_bytes == 0) {
        printf("Connexion fermée par le client\n");
    } else {
        buffer[read_bytes] = '\0';
        printf("Reçu : %s\n", buffer);

        char method[10], path[50], headers[BUFFER_SIZE], body[BUFFER_SIZE];
        parse_request(buffer, method, path, headers, body);
        printf("Méthode : %s\n", method);
        printf("Chemin : %s\n", path);
        printf("Corps : %s\n", body);

        cJSON* json = cJSON_Parse(body);
        char response_body[BUFFER_SIZE/2];
        char response[BUFFER_SIZE];

        if (json != NULL) {
            handle_route(path, json, response_body, sizeof(response_body));

            snprintf(response, BUFFER_SIZE, "HTTP/1.1 200 OK\nContent-Type: application/json\nContent-Length: %ld\r\n\r\n%s", 
                     strlen(response_body), response_body);
            printf("Réponse envoyée : %s\n", response);
            send(client_fd, response, strlen(response), 0);

            cJSON_Delete(json);
        } else {
            const char* error_response = "HTTP/1.1 400 Bad Request\nContent-Type: text/plain\r\n\r\nRequête invalide";
            printf("Réponse envoyée : %s\n", error_response);
            send(client_fd, error_response, strlen(error_response), 0);
        }
    }
}

int main(int argc, char *argv[]) {
    int server_fd, client_fd;
    struct sockaddr_in server_addr, client_addr;
    socklen_t addr_len;
    int port = 8080;
    int verbose = 0;

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

        printf("Nouvelle connexion\n");
        handle_request(client_fd);
        close(client_fd);
    }

    close(server_fd);

    return 0;
}