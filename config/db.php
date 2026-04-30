<?php
// Emplacement : config/db.php

// Récupération des variables (Priorité aux variables d'environnement de Render)
$host = getenv('DB_HOST') ?: 'mysql-1e74f5ad-stivofolefacknanfack-ecde.l.aivencloud.com';
$port = getenv('DB_PORT') ?: '13761'; 
$db   = getenv('DB_NAME') ?: 'defaultdb';
$user = getenv('DB_USER') ?: 'avnadmin';
$pass = getenv('DB_PASS'); 

// Configuration du DSN
$dsn = "mysql:host=$host;port=$port;dbname=$db;charset=utf8mb4";

// OPTIONS DE CONNEXION (Cruciales pour Aiven)
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
    // LA LIGNE MAGIQUE POUR LE CLOUD :
    PDO::MYSQL_ATTR_SSL_CA       => true, 
    PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    // On affiche une erreur claire pour le débogage
    error_log("Erreur de connexion base de données : " . $e->getMessage());
    die("Erreur de connexion : " . $e->getMessage());
}
?>