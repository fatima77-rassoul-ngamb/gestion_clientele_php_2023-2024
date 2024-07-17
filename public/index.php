<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../controllers/ClientController.php';
require_once __DIR__ . '/../controllers/UserController.php';

$clientController = new ClientController();
$userController = new UserController();

$page = $_GET['page'] ?? 1;
$limit = 10;

$action = $_POST['action'] ?? $_GET['action'] ?? '';

switch ($action) {
    case 'create':
        $result = $clientController->createClient($_POST);
        echo $result;
        break;
    
    case 'update':
        $result = $clientController->updateClient($_POST);
        echo $result;
        break;
    case 'delete':
        $result = $clientController->deleteClient($_POST['id']);
        echo $result;
        break;
        case 'export':
            if ($_GET['type'] == 'csv') {
                $clientController->exportToCSV();
            } elseif ($_GET['type'] == 'pdf') {
                $clientController->exportToPDF();
            }
            break;
        
    case 'filter':
        $criteria = [
            'nom' => $_POST['nom'] ?? '',
            'adresse' => $_POST['adresse'] ?? '',
            'telephone' => $_POST['telephone'] ?? ''
        ];
        $clients = $clientController->filterClients($criteria);
        echo json_encode($clients);
        break;
    case 'history':
        $client_id = $_GET['id'];
        $history = $clientController->listClientHistory($client_id);
        include __DIR__ . '/../views/clients/history.php';
        break;
    case 'login':
        $result = $userController->login($_POST);
        if ($result) {
            header("Location: index.php");
        } else {
            echo "Nom d'utilisateur ou mot de passe incorrect.";
        }
        break;
    case 'logout':
        $userController->logout();
        break;
    default:
        $clients = $clientController->listPaginatedClients($page, $limit);
        $totalClients = $clientController->getTotalClients();
        include __DIR__ . '/../views/clients/index.php';
        break;
}
?>
