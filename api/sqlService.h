#ifndef SQL_SERVICE_H
#define SQL_SERVICE_H

#include <stdbool.h>
#include <mysql/mysql.h>

// Crée une nouvelle clé API dans la base de données
bool create_api_key(int user_id, bool is_superadmin);

#endif