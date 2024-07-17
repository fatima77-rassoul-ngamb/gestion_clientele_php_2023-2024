<?php
class History {
    private $conn;
    private $table_name = "history";

    public $id;
    public $client_id;
    public $action;
    public $details;
    public $created_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " SET client_id=:client_id, action=:action, details=:details, created_at=:created_at";
        $stmt = $this->conn->prepare($query);

        $this->client_id = htmlspecialchars(strip_tags($this->client_id));
        $this->action = htmlspecialchars(strip_tags($this->action));
        $this->details = htmlspecialchars(strip_tags($this->details));
        $this->created_at = htmlspecialchars(strip_tags($this->created_at));

        $stmt->bindParam(":client_id", $this->client_id);
        $stmt->bindParam(":action", $this->action);
        $stmt->bindParam(":details", $this->details);
        $stmt->bindParam(":created_at", $this->created_at);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function readByClient($client_id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE client_id = ? ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $client_id);
        $stmt->execute();
        return $stmt;
    }
}
?>
