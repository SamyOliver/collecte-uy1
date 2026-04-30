<?php 
require_once 'config/db.php';

// 1. Calcul de la moyenne générale
$avgStmt = $pdo->query("SELECT AVG(CAST(valeur AS UNSIGNED)) as moyenne FROM reponses WHERE question_id = 1");
$moyenne = round($avgStmt->fetch()['moyenne'], 2);

// 2. Participation par Faculté
$facStmt = $pdo->query("SELECT filiere, COUNT(*) as nb FROM users GROUP BY filiere");
$facData = $facStmt->fetchAll();

// 3. Comparaison Restau 1 vs Restau 2
$restoStmt = $pdo->query("SELECT valeur, COUNT(*) as nb FROM reponses WHERE question_id = 2 GROUP BY valeur");
$restoData = $restoStmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Analytics UY1 - Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .stat-card { border-radius: 12px; border: none; transition: transform 0.2s; }
        .stat-card:hover { transform: translateY(-5px); }
        .bg-uy1 { background-color: #004a99; color: white; }
    </style>
</head>
<body class="bg-light">
    <nav class="navbar navbar-dark bg-uy1 mb-4 shadow-sm">
        <div class="container">
            <span class="navbar-brand mb-0 h1">UY1 Data Analytics</span>
        </div>
    </nav>

    <div class="container">
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card stat-card bg-uy1 shadow-sm p-4 text-center">
                    <h6>Moyenne Satisfaction</h6>
                    <h2 class="display-5 fw-bold"><?= $moyenne ?> / 5</h2>
                </div>
            </div>
            </div>

        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="card border-0 shadow-sm p-3">
                    <h5 class="text-center text-muted">Répartition par Faculté</h5>
                    <canvas id="facChart"></canvas>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="card border-0 shadow-sm p-3">
                    <h5 class="text-center text-muted">Fréquentation des Restaurants</h5>
                    <canvas id="restoChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Graphique Facultés
        new Chart(document.getElementById('facChart'), {
            type: 'pie',
            data: {
                labels: <?= json_encode(array_column($facData, 'filiere')) ?>,
                datasets: [{
                    data: <?= json_encode(array_column($facData, 'nb')) ?>,
                    backgroundColor: ['#004a99', '#fbbf24', '#28a745', '#dc3545', '#17a2b8']
                }]
            }
        });

        // Graphique Restaurants
        new Chart(document.getElementById('restoChart'), {
            type: 'bar',
            data: {
                labels: <?= json_encode(array_column($restoData, 'valeur')) ?>,
                datasets: [{
                    label: 'Nombre d\'étudiants',
                    data: <?= json_encode(array_column($restoData, 'nb')) ?>,
                    backgroundColor: '#004a99'
                }]
            },
            options: { scales: { y: { beginAtZero: true } } }
        });
    </script>
</body>
</html>