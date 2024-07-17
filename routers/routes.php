<?php
require_once '../controllers/ClientController.php';

$controller = new ClientController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['action'] === 'create') {
        $result = $controller->createClient($_POST);
        echo $result;
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $clients = $controller->listClients();
    echo json_encode($clients);
}
?>
