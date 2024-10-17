<?php
require '../vendor/autoload.php';

use Loteria\Controllers\SorteioController;
use Loteria\Services\SorteioService;

try {
    $db = new PDO('sqlite:/var/www/html/database/loteria.db');
} catch (PDOException $e) {
    echo json_encode(['erro' => 'Erro ao conectar ao banco de dados: ' . $e->getMessage()]);
    exit;
}

$sorteioService = new SorteioService($db);
$sorteioController = new SorteioController($sorteioService);

header('Content-Type: application/json');

$route = $_GET['route'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $route === 'bilhete') {
    $dados = json_decode(file_get_contents("php://input"), true);
    echo json_encode($sorteioController->gerarBilhetes($dados['quantidadeBilhetes'], $dados['quantidadeDezenas']));
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && $route === 'sorteio') {
    echo json_encode($sorteioController->gerarSorteio());
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && $route === 'conferir') {
    echo $sorteioController->conferirBilhetes();
    exit;
}