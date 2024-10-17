<?php
try {
    $db = new PDO('sqlite:/var/www/html/database/loteria.db');

    // Criação da tabela de bilhetes
    $db->exec("CREATE TABLE IF NOT EXISTS bilhetes (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        numeros TEXT NOT NULL
    )");

    // Criação da tabela do bilhete premiado
    $db->exec("CREATE TABLE IF NOT EXISTS bilhete_premiado (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        numeros TEXT NOT NULL
    )");

    echo "Banco de dados criado com sucesso.";
} catch (PDOException $e) {
    echo "Erro ao criar o banco de dados: " . $e->getMessage();
}
