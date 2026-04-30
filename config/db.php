<?php
// Emplacement : config/db.php
$host = 'mysql-1e74f5ad-stivofolefacknanfack-ecde.l.aivencloud.com'; 
$port = '13763'; // Le port que tu as sur Aiven
$db   = 'defaultdb';
$user = 'avnadmin';

// LA LIGNE MAGIQUE : Le mot de passe n'est plus écrit dans le code !
$pass = getenv('DB_PASS'); 

$dsn = "mysql:host=$host;port=$port;dbname=$db;charset=utf8mb4";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
?>