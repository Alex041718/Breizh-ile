import requests

# Configuration du serveur
HOST = "http://127.0.0.1:8080"

# Données à envoyer
headers = {"Content-Type": "application/json"}
body = {"key": "value"}

try:
    # Envoi de la requête POST
    response = requests.post(HOST, headers=headers, json=body)
    response.raise_for_status()  # Lever une exception en cas d'erreur

    # Affichage de la réponse
    print(response.text)

except requests.exceptions.RequestException as e:
    print(f"Erreur lors de la requête : {e}")