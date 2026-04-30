<?php
// Emplacement : C:\xampp\htdocs\collecte_uy1\config\db.php

$host = 'localhost';
$db   = 'collecte_uy1_db';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    // Message d'erreur propre
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}
?>