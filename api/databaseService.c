#include <stdio.h>
#include <stdlib.h>
#include <mysql/mysql.h>
#include <stdbool.h>
#include <string.h>
#include <time.h>
#include <sys/time.h>
#include "dotenv.h"
#include "bcrypt.h"
#include "utils.h"

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

int get_user_id_from_email(char* email) {
    char query[1024];
    snprintf(query, sizeof(query), "SELECT userID FROM _User WHERE mail='%s'", email);

    MYSQL* conn = init_database();
    MYSQL_RES* res;
    MYSQL_ROW row;

    if (mysql_query(conn, query)) {
        fprintf(stderr, "Error querying database: %s\n", mysql_error(conn));
        mysql_close(conn);
        return -1;
    }

    res = mysql_store_result(conn);
    if (res == NULL) {
        fprintf(stderr, "Error storing result: %s\n", mysql_error(conn));
        mysql_close(conn);
        return -1;
    }

    row = mysql_fetch_row(res);
    if (row == NULL) {
        fprintf(stderr, "No user found with email %s\n", email);
        mysql_close(conn);
        return -1;
    }

    int user_id = atoi(row[0]);
    mysql_close(conn);
    return user_id;
}

int get_user_id_from_api_key(char* api_key) {
    char query[1024];
    snprintf(query, sizeof(query), "SELECT userID FROM _User_APIKey WHERE apiKey='%s'", api_key);

    MYSQL* conn = init_database();
    MYSQL_RES* res;
    MYSQL_ROW row;

    if (mysql_query(conn, query)) {
        fprintf(stderr, "Error querying database: %s\n", mysql_error(conn));
        mysql_close(conn);
        return -1;
    }

    res = mysql_store_result(conn);
    if (res == NULL) {
        fprintf(stderr, "Error storing result: %s\n", mysql_error(conn));
        mysql_close(conn);
        return -1;
    }

    row = mysql_fetch_row(res);
    if (row == NULL) {
        fprintf(stderr, "No user found with API key %s\n", api_key);
        mysql_close(conn);
        return -1;
    }

    int user_id = atoi(row[0]);
    mysql_close(conn);
    return user_id;
}  

bool check_user_credentials(char* email, char* password) {
    char query[1024];
    snprintf(query, sizeof(query), "SELECT password FROM _User WHERE mail='%s'", email);

    MYSQL* conn = init_database();
    MYSQL_RES* res;
    MYSQL_ROW row;

    if (mysql_query(conn, query)) {
        fprintf(stderr, "Error querying database: %s\n", mysql_error(conn));
        mysql_close(conn);
        return false;
    }

    res = mysql_store_result(conn);
    if (res == NULL) {
        fprintf(stderr, "Error storing result: %s\n", mysql_error(conn));
        mysql_close(conn);
        return false;
    }

    row = mysql_fetch_row(res);
    if (row == NULL) {
        fprintf(stderr, "No user found with email %s\n", email);
        mysql_close(conn);
        return false;
    }

    char* hash = row[0];
    bool success = bcrypt_checkpw(password, hash) == 0;

    mysql_close(conn);
    return success;
}

bool check_user_api_key(char* api_key) {
    char query[1024];
    snprintf(query, sizeof(query), "SELECT active FROM _User_APIKey WHERE apiKey='%s'", api_key);

    MYSQL* conn = init_database();
    MYSQL_RES* res;
    MYSQL_ROW row;

    if (mysql_query(conn, query)) {
        fprintf(stderr, "Error querying database: %s\n", mysql_error(conn));
        mysql_close(conn);
        return false;
    }

    res = mysql_store_result(conn);
    if (res == NULL) {
        fprintf(stderr, "Error storing result: %s\n", mysql_error(conn));
        mysql_close(conn);
        return false;
    }

    row = mysql_fetch_row(res);
    if (row == NULL) {
        fprintf(stderr, "No user found with API key %s\n", api_key);
        mysql_close(conn);
        return false;
    }

    bool active = atoi(row[0]);
    mysql_close(conn);
    return active;
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

bool is_superadmin_api_key(char* api_key) {
    char query[1024];
    snprintf(query, sizeof(query), "SELECT superAdmin FROM _User_APIKey WHERE apiKey='%s'", api_key);

    MYSQL* conn = init_database();
    MYSQL_RES* res;
    MYSQL_ROW row;

    if (mysql_query(conn, query)) {
        fprintf(stderr, "Error querying database: %s\n", mysql_error(conn));
        mysql_close(conn);
        return false;
    }

    res = mysql_store_result(conn);
    if (res == NULL) {
        fprintf(stderr, "Error storing result: %s\n", mysql_error(conn));
        mysql_close(conn);
        return false;
    }

    row = mysql_fetch_row(res);
    if (row == NULL) {
        fprintf(stderr, "No user found with API key %s\n", api_key);
        mysql_close(conn);
        return false;
    }

    bool superadmin = atoi(row[0]);
    mysql_close(conn);
    return superadmin;
}

bool is_user_admin(int user_id) {
    char query[1024];
    snprintf(query, sizeof(query), "SELECT * FROM _Admin WHERE adminID=%d", user_id);

    MYSQL* conn = init_database();
    MYSQL_RES* res;
    MYSQL_ROW row;

    if (mysql_query(conn, query)) {
        fprintf(stderr, "Error querying database: %s\n", mysql_error(conn));
        mysql_close(conn);
        return false;
    }

    res = mysql_store_result(conn);
    if (res == NULL) {
        fprintf(stderr, "Error storing result: %s\n", mysql_error(conn));
        mysql_close(conn);
        return false;
    }

    row = mysql_fetch_row(res);
    if (row == NULL) {
        fprintf(stderr, "No admin found with ID %d\n", user_id);
        mysql_close(conn);
        return false;
    }

    mysql_close(conn);
    return true;
}

char* get_housings(int user_id) {
    char query[1024];
    if (user_id == 0) {
        snprintf(query, sizeof(query), "SELECT * FROM _Housing");
    } else {
        snprintf(query, sizeof(query), "SELECT * FROM _Housing WHERE ownerID=%d", user_id);
    }

    MYSQL* conn = init_database();
    MYSQL_RES* res;
    MYSQL_ROW row;

    if (mysql_query(conn, query)) {
        fprintf(stderr, "Error querying database: %s\n", mysql_error(conn));
        mysql_close(conn);
        return NULL;
    }

    res = mysql_store_result(conn);
    if (res == NULL) {
        fprintf(stderr, "Error storing result: %s\n", mysql_error(conn));
        mysql_close(conn);
        return NULL;
    }

    char* housings = malloc(8192 * 512);
    housings[0] = '\0';
    while ((row = mysql_fetch_row(res))) {
        char housing[8192] = "\0";
        
        int num_fields = mysql_num_fields(res);
        MYSQL_FIELD *fields = mysql_fetch_fields(res);

        for (int i = 0; i < num_fields; i++) {
            char value[8192] = "\0";
            replace_newlines_with_spaces(row[i]);
            snprintf(value, 8192, "%s=%s;", fields[i].name, row[i]);
            strcat(housing, value);
        }

        strcat(housing, "\n");
        strcat(housings, housing);
    }

    mysql_close(conn);
    return housings;
}

char* get_disponibility_housing(int housing_id, char* starting_date, char* end_date) {
    char query[8192];
    snprintf(query, sizeof(query), "WITH RECURSIVE DateRange AS (SELECT '%s' AS start_date, '%s' AS end_date), Reservations AS (SELECT beginDate, endDate FROM _Reservation WHERE housingID = %d AND endDate >= (SELECT start_date FROM DateRange) AND beginDate <= (SELECT end_date FROM DateRange) ORDER BY beginDate), AvailableDates AS (SELECT GREATEST(CASE WHEN @prev_end IS NULL THEN (SELECT start_date FROM DateRange) ELSE DATE_ADD(@prev_end, INTERVAL 1 DAY) END, (SELECT start_date FROM DateRange)) AS available_from, LEAST(DATE_SUB(beginDate, INTERVAL 1 DAY), (SELECT end_date FROM DateRange)) AS available_to, @prev_end := endDate FROM Reservations, (SELECT @prev_end := NULL) AS vars UNION ALL SELECT GREATEST(CASE WHEN (SELECT MAX(endDate) FROM Reservations) IS NULL THEN (SELECT start_date FROM DateRange) ELSE DATE_ADD((SELECT MAX(endDate) FROM Reservations), INTERVAL 1 DAY) END, (SELECT start_date FROM DateRange)), (SELECT end_date FROM DateRange), NULL) SELECT available_from, available_to FROM AvailableDates WHERE available_from <= available_to AND available_from <= (SELECT end_date FROM DateRange) AND available_to >= (SELECT start_date FROM DateRange) ORDER BY available_from;", starting_date, end_date, housing_id);

    MYSQL* conn = init_database();
    MYSQL_RES* res;
    MYSQL_ROW row;

    if (mysql_query(conn, query)) {
        fprintf(stderr, "Error querying database: %s\n", mysql_error(conn));
        mysql_close(conn);
        return NULL;
    }

    res = mysql_store_result(conn);
    if (res == NULL) {
        fprintf(stderr, "Error storing result: %s\n", mysql_error(conn));
        mysql_close(conn);
        return NULL;
    }

    char* disponibility = malloc(8192 * 512);
    disponibility[0] = '\0';
    while ((row = mysql_fetch_row(res))) {
        char date[8192] = "\0";
        
        int num_fields = mysql_num_fields(res);
        MYSQL_FIELD *fields = mysql_fetch_fields(res);

        for (int i = 0; i < num_fields; i++) {
            char value[8192] = "\0";
            replace_newlines_with_spaces(row[i]);
            snprintf(value, 8192, "%s=%s;", fields[i].name, row[i]);
            strcat(date, value);
        }

        strcat(date, "\n");
        strcat(disponibility, date);
    }

    mysql_close(conn);
    return disponibility;
}

int get_user_id_from_housing_id(int housing_id) {
    char query[1024];
    snprintf(query, sizeof(query), "SELECT ownerID FROM _Housing WHERE housingID=%d", housing_id);

    MYSQL* conn = init_database();
    MYSQL_RES* res;
    MYSQL_ROW row;

    if (mysql_query(conn, query)) {
        fprintf(stderr, "Error querying database: %s\n", mysql_error(conn));
        mysql_close(conn);
        return -1;
    }

    res = mysql_store_result(conn);
    if (res == NULL) {
        fprintf(stderr, "Error storing result: %s\n", mysql_error(conn));
        mysql_close(conn);
        return -1;
    }

    row = mysql_fetch_row(res);
    if (row == NULL) {
        fprintf(stderr, "No housing found with ID %d\n", housing_id);
        mysql_close(conn);
        return -1;
    }

    int user_id = atoi(row[0]);
    mysql_close(conn);
    return user_id;
}