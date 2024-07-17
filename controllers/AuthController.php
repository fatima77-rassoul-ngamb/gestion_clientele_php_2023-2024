<?php
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../config/database.php';

class AuthController {
    private $db;
    private $user;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->user = new User($this->db);
    }

    public function login($data) {
        $this->user->username = $data['username'];
        $this->user->password = $data['password']; // Mot de passe en clair
    
        if ($this->user->login()) {
            session_start();
            $_SESSION['user_id'] = $this->user->id;
            $_SESSION['role_id'] = $this->user->role_id;
            return true;
        }
    
        return false;
    }
    
    

    public function logout() {
        session_destroy();
        header("Location: ../login.php");
        exit();
    }

    public function register($data) {
        $this->user->username = $data['username'];
        $this->user->password = $data['password'];
        $this->user->role_id = $data['role'];

        if ($this->user->create()) {
            return true;
        }

        return false;
    }
}
?>
