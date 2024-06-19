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

#define MAX_CLIENTS 1
#define BUFFER_SIZE 1024

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

cJSON* parse_request(char* request) {
    cJSON* json = NULL;
    char* body = NULL;

    char* pos = strstr(request, "\r\n\r\n");
    if (pos != NULL) {
        body = pos + 4;
    }

    if (body != NULL) {
        json = cJSON_Parse(body);
    }

    return json;
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

        cJSON* json = parse_request(buffer);
        if (json != NULL) {
            char* response_body = cJSON_Print(json);
            cJSON_Delete(json);

            char response[BUFFER_SIZE];
            sprintf(response, "HTTP/1.1 200 OK\nContent-Type: application/json\nContent-Length: %ld\r\n\r\n%s", strlen(response_body), response_body);
            printf("Réponse envoyée : %s\n", response);
            send(client_fd, response, strlen(response), 0);

            free(response_body);
        } else {
            char response[] = "HTTP/1.1 400 Bad Request\nContent-Type: text/plain\r\n\r\nRequête invalide";
            printf("Réponse envoyée : %s\n", response);
            send(client_fd, response, strlen(response), 0);
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