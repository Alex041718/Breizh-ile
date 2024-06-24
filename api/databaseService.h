#ifndef DATABASE_SERVICE_H
#define DATABASE_SERVICE_H

#include <stdbool.h>
#include <mysql/mysql.h>

// Crée une nouvelle clé API dans la base de données
bool create_api_key(int user_id, bool is_superadmin);

// Vérifie les informations d'authentification d'un utilisateur
bool check_user_credentials(char* email, char* password);

// Récupère l'ID d'un utilisateur à partir de son adresse email
int get_user_id_from_email(char* email);

// Récupère l'ID d'un utilisateur à partir de sa clé API
int get_user_id_from_api_key(char* api_key);

// Vérifie si une clé API est valide
bool check_user_api_key(char* api_key);

#endif