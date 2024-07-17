<?php
class User {
    private $conn;
    private $table_name = "users";

    public $id;
    public $username;
    public $password;
    public $role_id;

    public function __construct($db) {
        $this->conn = $db;
    }
    //METHODE CREER
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " SET username=:username, password=:password, role_id=:role_id";
        $stmt = $this->conn->prepare($query);
    
        $this->username = htmlspecialchars(strip_tags($this->username));
        $hashedPassword = password_hash($this->password, PASSWORD_BCRYPT); // Utiliser une variable intermédiaire pour le hachage
        $this->role_id = htmlspecialchars(strip_tags($this->role_id));
    
        $stmt->bindParam(":username", $this->username);
        $stmt->bindParam(":password", $hashedPassword); // Utiliser la variable intermédiaire ici
        $stmt->bindParam(":role_id", $this->role_id);
    
        if ($stmt->execute()) {
            return true;
        }
    
        return false;
    }
    
    

    public function login() {
        $query = "SELECT id, username, password, role_id FROM " . $this->table_name . " WHERE username = :username LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
    
        $this->username = htmlspecialchars(strip_tags($this->username));
        $stmt->bindParam(":username", $this->username);
    
        $stmt->execute();
        $num = $stmt->rowCount();
    
        if ($num > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->id = $row['id'];
            $this->username = $row['username'];
            $this->role_id = $row['role_id'];
    
            // Debug: Vérifiez les valeurs avant de vérifier le mot de passe
            error_log('Mot de passe stocké : ' . $row['password']);
            error_log('Mot de passe entré : ' . $this->password);
    
            // Vérification du mot de passe
            if (password_verify($this->password, $row['password'])) {
                return true;
            } else {
                error_log('Échec de la vérification du mot de passe.');
            }
        }
    
        return false;
    }
    
}
?>
