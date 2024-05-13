<?php

class SessionService {

    /**
     * Système de gestion de la session, cette méthode est à appeler dans chaque view qui nécessite une session.
     */

    public static function system(string $role,string $conectionPage, string $redirectPage = null) {
        if (!self::isAuthenticated() || self::get('role') !== 'admin' || self::isExpired()) {
            // Rediriger vers la page de connexion si l'administrateur n'est pas connecté
            header('Location: ../../views/admin/adminConnection.php');
            exit();
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

    /**
     * Authentifie un utilisateur.
     * @param int $userId
     * @param string $username
     * @param string $role
     */
    public static function authenticate($userId, $username, $role) {
        self::startSession();
        $_SESSION['user_id'] = $userId;
        $_SESSION['username'] = $username;
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
     * Vérifie si une clé de session spécifique existe.
     * @param string $key
     * @return bool
     */
    public static function has($key) {
        self::startSession();
        return isset($_SESSION[$key]);
    }
}
