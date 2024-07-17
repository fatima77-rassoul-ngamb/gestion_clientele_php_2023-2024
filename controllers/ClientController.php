<?php
require_once __DIR__ . '/../models/Client.php';
require_once __DIR__ . '/../models/History.php';
require_once __DIR__ . '/../config/database.php';

class ClientController {
    private $db;
    private $client;
    private $history;

    public function __construct() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['user_id'])) {
            header("Location: ../login.php");
            exit();
        }

        $database = new Database();
        $this->db = $database->getConnection();
        $this->client = new Client($this->db);
        $this->history = new History($this->db);
    }

    public function createClient($data) {
        $this->client->nom = $data['nom'];
        $this->client->adresse = $data['adresse'];
        $this->client->telephone = $data['telephone'];
        $this->client->email = $data['email'];
        $this->client->sexe = $data['sexe'];
        $this->client->statut = $data['statut'];
    
        if ($this->client->create()) {
            $this->logHistory($this->client->id, 'ajouté', json_encode($data));
            return "Client créé avec succès.";
        } else {
            return "Impossible de créer le client.";
        }
    }
    

    public function updateClient($data) {
        $this->client->id = $data['id'];
        $this->client->nom = $data['nom'];
        $this->client->adresse = $data['adresse'];
        $this->client->telephone = $data['telephone'];
        $this->client->email = $data['email'];
        $this->client->sexe = $data['sexe'];
        $this->client->statut = $data['statut'];

        if ($this->client->update()) {
            $this->logHistory($this->client->id, 'update', json_encode($data));
            return "Client mis à jour avec succès.";
        } else {
            return "Impossible de mettre à jour le client.";
        }
    }

    public function deleteClient($id) {
        $this->client->id = $id;
        if ($this->client->delete()) {
            $this->logHistory($id, 'delete', "Client ID: $id");
            return "Client supprimé avec succès.";
        } else {
            return "Impossible de supprimer le client.";
        }
    }

    private function logHistory($client_id, $action, $details) {
        $user_id = $_SESSION['user_id'];
        $username = $_SESSION['username'];
    
        $details = "Ce client a été $action par $username";
    
        $this->history->client_id = $client_id;
        $this->history->action = $action;
        $this->history->details = $details;
        $this->history->created_at = date('Y-m-d H:i:s');
        $this->history->create();
    }
    
    

    public function listClients() {
        $stmt = $this->client->readAll();
        $clients = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $clients;
    }

    public function filterClients($criteria) {
        $stmt = $this->client->filter($criteria);
        $clients = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $clients;
    }

    public function listPaginatedClients($page, $limit) {
        $offset = ($page - 1) * $limit;
        $stmt = $this->client->readPaginated($offset, $limit);
        $clients = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $clients;
    }

    public function getTotalClients() {
        return $this->client->countAll();
    }

    public function listClientHistory($client_id) {
        if ($_SESSION['role_id'] != '2') { 
            header("Location: /gestion_clientele/public/index.php");
            exit();
        }

        $stmt = $this->history->readByClient($client_id);
        $history = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $history;
    }

    public function exportToCSV() {
        $filename = "clients_" . date('Ymd') . ".csv";
        $clients = $this->client->readAll();
        $clients = $clients->fetchAll(PDO::FETCH_ASSOC);
    
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment;filename=' . $filename);
    
        $output = fopen('php://output', 'w');
        fputcsv($output, array('Nom', 'Adresse', 'Téléphone', 'Email', 'Sexe', 'Statut'));
    
        foreach ($clients as $client) {
            fputcsv($output, $client);
        }
        fclose($output);
        exit();
    }
    
    public function exportToPDF() {
        require_once __DIR__ . '/../lib/tcpdf/tcpdf.php';
    
        $pdf = new TCPDF();
        $pdf->AddPage();
        $pdf->SetFont('helvetica', '', 12);
    
        $html = '<h1>Liste des Clients</h1>';
        $html .= '<table border="1" cellpadding="4">';
        $html .= '<thead>
                    <tr>
                        <th>Nom</th>
                        <th>Adresse</th>
                        <th>Téléphone</th>
                        <th>Email</th>
                        <th>Sexe</th>
                        <th>Statut</th>
                    </tr>
                  </thead>
                  <tbody>';
    
        $clients = $this->client->readAll();
        $clients = $clients->fetchAll(PDO::FETCH_ASSOC);
    
        foreach ($clients as $client) {
            $html .= '<tr>
                        <td>' . $client['nom'] . '</td>
                        <td>' . $client['adresse'] . '</td>
                        <td>' . $client['telephone'] . '</td>
                        <td>' . $client['email'] . '</td>
                        <td>' . $client['sexe'] . '</td>
                        <td>' . $client['statut'] . '</td>
                      </tr>';
        }
    
        $html .= '</tbody></table>';
        $pdf->writeHTML($html);
        $pdf->Output('clients_' . date('Ymd') . '.pdf', 'D');
        exit();
    }
    
}
?>
