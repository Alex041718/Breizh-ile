<?php

class SessionService {

    /**
     * Système de gestion de la session, cette méthode est à appeler dans chaque view qui nécessite une session.
     */

    public static function system(string $role, string $redirectPage = null) {
        if (!self::isAuthenticated()
            || self::get('role') == null
            || self::isExpired() || self::get('role') != $role
        ) {
            // encodage de la page de redirection
            $redirectPage = urlencode($redirectPage);

            if ($role == 'admin') {
                header('Location: ../../admin/adminConnection.php'.($redirectPage ? '?redirect='.$redirectPage : ''));
            } else if ($role == 'owner') {
                header('Location: /back/connection'.($redirectPage ? '?redirect='.$redirectPage : ''));
            } else if ($role == 'client') {
                header('Location: /client/connection'.($redirectPage ? '?redirect='.$redirectPage : ''));
            } else {
                header('Location: /client/connection'.($redirectPage ? '?redirect='.$redirectPage : ''));
            }
            exit();
        }

        // Utilisateur connecté

        // Affichage d'un toast
        self::loadToast();
    }

    public static function createToast(string $message, string $type) {
        self::set('toast', ['message' => $message, 'type' => $type]);
    }

    public static function loadToast() {
        if (self::has('toast')) {
            $toast = self::get('toast');

            echo '

            <link rel="stylesheet" href="/components/Toast/Toast.css">
            
            <script type="module" src="/components/Toast/Toast.js"></script>
            <script type="module"> 
                import { Toast } from "/components/Toast/Toast.js";
                Toast("'.$toast['message'].'", "'.$toast['type'].'");
            </script>
            
            
';


            self::remove('toast');
        }
    }


    /**
     * Démarre la session avec des paramètres sécurisés.
     */
    public static function startSession() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start([
                'cookie_lifetime' => 86400,
                'read_and_close'  => false,
                'cookie_secure'   => false, // vu qu'on fonctionne avec http et qu'on a pas de certificat ssl
                'cookie_httponly' => true
            ]);
        }
    }

    /**
     * Vérifie si l'utilisateur est connecté.
     * @return bool
     */
    public static function isAuthenticated() {
        self::startSession();  // Assurez-vous que la session est démarrée
        return isset($_SESSION['logged_in']) && $_SESSION['logged_in'];
    }

    public static function isOwnerAuthenticated() {
        self::startSession();  // Assurez-vous que la session est démarrée
        return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] && $_SESSION['role'] == "owner";
    }

    public static function isClientAuthenticated() {
        self::startSession();  // Assurez-vous que la session est démarrée
        return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] && $_SESSION['role'] == "client";
    }



    /**
     * Authentifie un utilisateur.
     * @param int $userId
     * @param string $mail
     * @param string $role
     */
    public static function authenticate($userId, $mail, $role) {
        self::startSession();
        $_SESSION['user_id'] = $userId;
        $_SESSION['mail'] = $mail;
        $_SESSION['role'] = $role;
        $_SESSION['logged_in'] = true;
        $_SESSION['last_activity'] = time();
    }

    public static function isExpired() {
        self::startSession();
        $timeout = 1800 ; // 30 minutes
        if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > $timeout) {
            return true;
        }
        $_SESSION['last_activity'] = time();
        return false;
    }

    /**
     * Déconnecte l'utilisateur.
     */
    public static function logout() {
        self::startSession();
        $_SESSION = array();

        // Si vous voulez tuer le cookie de session aussi
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        session_destroy();
    }

    /**
     * Retourne une valeur de session.
     * @param string $key
     * @return mixed
     */
    public static function get($key) {
        self::startSession();
        return $_SESSION[$key] ?? null;
    }

    /**
     * Définit une valeur de session.
     * @param string $key
     * @param mixed $value
     */
    public static function set($key, $value) {
        self::startSession();
        $_SESSION[$key] = $value;
    }

    /**
     * Supprime une valeur de session.
     * @param string $key
     */
    public static function remove($key) {
        self::startSession();
        unset($_SESSION[$key]);
    }

    /**
     * Vérifie si une clé de session spécifique existe.
     * @param string $key
     * @return bool
     */
    public static function has($key) {
        self::startSession();
        return isset($_SESSION[$key]);
    }
}
