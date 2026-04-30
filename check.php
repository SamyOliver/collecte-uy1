<?php
// Emplacement : C:\xampp\htdocs\collecte_uy1\check.php
require_once 'config/db.php';

echo "<h2>Diagnostic du Système Collecte UY1</h2>";

if ($pdo) {
    echo "<p style='color:green;'>✅ Connexion à la base de données : <strong>RÉUSSIE</strong></p>";
    
    // Vérification si les tables existent
    try {
        $query = $pdo->query("SHOW TABLES LIKE 'users'");
        if ($query->rowCount() > 0) {
            echo "<p style='color:green;'>✅ Table 'users' : <strong>DÉTECTÉE</strong></p>";
        } else {
            echo "<p style='color:red;'>❌ Table 'users' : <strong>NON TROUVÉE</strong> (Avez-vous exécuté le code SQL dans phpMyAdmin ?)</p>";
        }
    } catch (Exception $e) {
        echo "Erreur : " . $e->getMessage();
    }
} else {
    echo "<p style='color:red;'>❌ Connexion à la base de données : <strong>ÉCHEC</strong></p>";
}
?>