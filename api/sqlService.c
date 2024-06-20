#include <stdio.h>
#include <stdlib.h>
#include <mysql/mysql.h>
#include <stdbool.h>
#include <time.h>
#include <sys/time.h>
#include "dotenv.h"

MYSQL* init_database() {
    env_load("..", false);

    char* db = getenv("MYSQL_DATABASE");
    char* user = getenv("MYSQL_USER");
    char* pass = getenv("MYSQL_PASSWORD");
    char* root = getenv("MYSQL_ROOT_PASSWORD");

    MYSQL *conn;
    if (!(conn = mysql_init(0)))
    {
        fprintf(stderr, "unable to initialize connection struct\n");
        exit(1);
    }

    bool connected = mysql_real_connect(
                        conn,           // Connection
                        "127.0.0.1",    // Host
                        user,           // User account
                        pass,           // User password
                        db,             // Default database
                        3306,           // Port number
                        NULL,           // Path to socket file
                        0               // Additional options
                    );

    if (!connected)
    {
        fprintf(stderr, "Error connecting to Server: %s\n", mysql_error(conn));
        mysql_close(conn);
        exit(1);
    }

    printf("Connected to the database\n");

    return conn;
}

bool query_database(char* query) {
    MYSQL* conn = init_database();
    bool success = true;

    if (mysql_query(conn, query)) {
        fprintf(stderr, "Error querying database: %s\n", mysql_error(conn));
        success = false;
    }

    mysql_close(conn);
    return success;
}

char* generate_api_key() {
    struct timeval tv;
    gettimeofday(&tv, NULL);
    unsigned long long milliseconds = (unsigned long long)(tv.tv_sec) * 1000 + (unsigned long long)(tv.tv_usec) / 1000;
    srand(milliseconds);

    char* api_key = malloc(65);
    for (int i = 0; i < 64; i++) {
        int random = rand() % 16;
        if (random < 10) {
            api_key[i] = '0' + random;
        } else {
            api_key[i] = 'a' + random - 10;
        }
    }
    api_key[64] = '\0';
    return api_key;
}

bool create_api_key(int user_id, bool is_superadmin) {
    bool success = true;

    char* api_key = generate_api_key();
    char query[1024];

    snprintf(query, sizeof(query), "INSERT INTO _User_APIKey (userID, apiKey, active, superAdmin) VALUES (%d, '%s', 1, %d)", user_id, api_key, is_superadmin);
    printf("Query: %s\n", query);

    if (!query_database(query)) {
        printf("Error creating API key\n");
        success = false;
    }

    return success;
}