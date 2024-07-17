<?php
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../config/database.php';

class UserController {
    private $db;
    private $user;

    public function __construct() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $database = new Database();
        $this->db = $database->getConnection();
        $this->user = new User($this->db);
    }

    public function login($data) {
        $username = $data['username'];
        $password = $data['password'];

        $user = $this->user->login($username, $password);
        if ($user) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username']; // Enregistrer le nom d'utilisateur
            $_SESSION['role_id'] = $user['role_id'];
            return true;
        } else {
            return false;
        }
    }

    public function logout() {
        session_destroy();
        header("Location: ../login.php");
        exit();
    }
}
?>
