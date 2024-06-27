#include <stdio.h>
#include <stdlib.h>
#include <time.h>
#include <stdbool.h>
#include <string.h>

#define RESET "\033[0m"
#define RED "\033[31m"
#define YELLOW "\033[33m"
#define GREEN "\033[32m"
#define CYAN "\033[36m"

// Define the log levels
enum log_level {
    INFO,
    WARNING,
    ERROR
};

void replace_newlines_with_spaces(char* str) {
    if (str == NULL) return;

    for (int i = 0; str[i] != '\0'; i++) {
        if (str[i] == '\n') {
            str[i] = ' ';
        }
    }
}

void print_log(const char *message, enum log_level level) {
    time_t now = time(NULL);
    struct tm *tm = localtime(&now);
    char timestamp[20];
    strftime(timestamp, sizeof(timestamp), "%Y-%m-%d %H:%M:%S", tm); // Format the timestamp

    char* message_copy = strdup(message);
    replace_newlines_with_spaces(message_copy);

    char log_message[sizeof(timestamp) + sizeof(message_copy) + 128];
    switch (level) {
        case INFO:
            printf("[%s%s%s] [%sINFO%s] %s\n", CYAN, timestamp, RESET, GREEN, RESET, message_copy);
            snprintf(log_message, sizeof(log_message), "[%s] [INFO] %s", timestamp, message_copy);
            break;
        case WARNING:
            printf("[%s%s%s] [%sWARNING%s] %s\n", CYAN, timestamp, RESET, YELLOW, RESET, message_copy);
            snprintf(log_message, sizeof(log_message), "[%s] [WARNING] %s", timestamp, message_copy);
            break;
        case ERROR:
            printf("[%s%s%s] [%sERROR%s] %s\n", CYAN, timestamp, RESET, RED, RESET, message_copy);
            snprintf(log_message, sizeof(log_message), "[%s] [ERROR] %s", timestamp, message_copy);
            break;
        default:
            printf("[%s%s%s] [%sINFO%s] %s\n", CYAN, timestamp, RESET, GREEN, RESET, message_copy);
            snprintf(log_message, sizeof(log_message), "[%s] [INFO] %s", timestamp, message_copy);
            break;
    }

    // write to log file
    FILE* log_file = fopen("log.txt", "a");
    if (log_file == NULL) {
        printf("Impossible d'ouvrir le fichier de log\n");
        return;
    }

    fprintf(log_file, "%s\n", log_message);
    fclose(log_file);

    free(message_copy);
}

bool is_number(char* str) {
    for (int i = 0; i < strlen(str); i++) {
        if (str[i] < '0' || str[i] > '9') {
            return false;
        }
    }
    return true;
}