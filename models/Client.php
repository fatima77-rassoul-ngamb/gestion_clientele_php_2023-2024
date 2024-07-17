<?php
class Client {
    private $conn;
    private $table_name = "clients";

    public $id;
    public $nom;
    public $adresse;
    public $telephone;
    public $email;
    public $sexe;
    public $statut;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " SET nom=:nom, adresse=:adresse, telephone=:telephone, email=:email, sexe=:sexe, statut=:statut";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":nom", $this->nom);
        $stmt->bindParam(":adresse", $this->adresse);
        $stmt->bindParam(":telephone", $this->telephone);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":sexe", $this->sexe);
        $stmt->bindParam(":statut", $this->statut);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function update() {
        $query = "UPDATE " . $this->table_name . " SET nom=:nom, adresse=:adresse, telephone=:telephone, email=:email, sexe=:sexe, statut=:statut WHERE id=:id";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":nom", $this->nom);
        $stmt->bindParam(":adresse", $this->adresse);
        $stmt->bindParam(":telephone", $this->telephone);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":sexe", $this->sexe);
        $stmt->bindParam(":statut", $this->statut);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function readAll() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY nom";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    //METHODE POUR LE FILTRAGE
    
    public function filter($criteria) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE 1=1";

        if (!empty($criteria['nom'])) {
            $query .= " AND nom LIKE :nom";
        }
        if (!empty($criteria['adresse'])) {
            $query .= " AND adresse LIKE :adresse";
        }
        if (!empty($criteria['telephone'])) {
            $query .= " AND telephone LIKE :telephone";
        }

        $stmt = $this->conn->prepare($query);

        if (!empty($criteria['nom'])) {
            $criteria['nom'] = "%{$criteria['nom']}%";
            $stmt->bindParam(':nom', $criteria['nom']);
        }
        if (!empty($criteria['adresse'])) {
            $criteria['adresse'] = "%{$criteria['adresse']}%";
            $stmt->bindParam(':adresse', $criteria['adresse']);
        }
        if (!empty($criteria['telephone'])) {
            $criteria['telephone'] = "%{$criteria['telephone']}%";
            $stmt->bindParam(':telephone', $criteria['telephone']);
        }

        $stmt->execute();

        return $stmt;
    }
    //methode pour une pagination
    public function readPaginated($offset, $limit) {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY nom LIMIT :offset, :limit";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
    
        return $stmt;
    }
    //pour compter le nombre de client
    public function countAll() {
        $query = "SELECT COUNT(*) as total FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
    
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'];
    }
    
    
}
?>
