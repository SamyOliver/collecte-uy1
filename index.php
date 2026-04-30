<?php 
require_once 'config/db.php'; 
$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $pdo->beginTransaction(); // Sécurité : Tout ou rien

        // 1. Enregistrement de l'étudiant
        $stmt = $pdo->prepare("INSERT INTO users (sexe, filiere, niveau) VALUES (?, ?, ?)");
        $stmt->execute([$_POST['sexe'], $_POST['filiere'], $_POST['niveau']]);
        $userId = $pdo->lastInsertId();

        // 2. Enregistrement des réponses (Note et Choix Restau)
        $stmtRep = $pdo->prepare("INSERT INTO reponses (user_id, question_id, valeur) VALUES (?, ?, ?)");
        $stmtRep->execute([$userId, 1, $_POST['note']]);
        $stmtRep->execute([$userId, 2, $_POST['resto']]);

        $pdo->commit();
        $message = "<div class='alert alert-success shadow-sm'>✅ Merci ! Votre contribution a été enregistrée avec succès.</div>";
    } catch (Exception $e) {
        $pdo->rollBack();
        $message = "<div class='alert alert-danger'>❌ Erreur lors de l'enregistrement.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Collecte UY1 - Qualité Restau U</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root { --uy1-blue: #004a99; --uy1-gold: #fbbf24; }
        body { background-color: #f0f2f5; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .card-header { background-color: var(--uy1-blue); color: white; border-radius: 15px 15px 0 0 !important; }
        .btn-primary { background-color: var(--uy1-blue); border: none; }
        .btn-primary:hover { background-color: #003366; }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-7">
                <div class="card shadow border-0" style="border-radius: 15px;">
                    <div class="card-header text-center p-4">
                        <h3 class="mb-0">Université de Yaoundé I</h3>
                        <small>Enquête de Satisfaction - Restaurants Universitaires</small>
                    </div>
                    <div class="card-body p-4">
                        <?= $message ?>
                        <form method="POST" class="needs-validation">
                            <h5 class="text-muted mb-3 border-bottom pb-2">Informations Générales</h5>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Sexe</label>
                                    <select name="sexe" class="form-select" required>
                                        <option value="Masculin">Masculin</option>
                                        <option value="Féminin">Féminin</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Niveau</label>
                                    <select name="niveau" class="form-select" required>
                                        <option value="L1">Licence 1</option><option value="L2">Licence 2</option>
                                        <option value="L3">Licence 3</option><option value="M1">Master 1</option>
                                        <option value="M2">Master 2</option><option value="Doctorat">Doctorat</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="form-label">Établissement (UY1)</label>
                                <select name="filiere" class="form-select" required>
                                    <option value="Faculté des Sciences">Faculté des Sciences (FS)</option>
                                    <option value="FALSH">FALSH</option>
                                    <option value="ENSPY">Polytechnique (ENSPY)</option>
                                    <option value="ENS">E.N.S</option>
                                    <option value="FMSB">Médecine (FMSB)</option>
                                </select>
                            </div>

                            <h5 class="text-muted mb-3 border-bottom pb-2">Évaluation</h5>
                            <div class="mb-3">
                                <label class="form-label">Quel restaurant fréquentez-vous ?</label>
                                <select name="resto" class="form-select" required>
                                    <option value="Restaurant 1">Restaurant N°1 (Principal)</option>
                                    <option value="Restaurant 2">Restaurant N°2 (Annexe)</option>
                                </select>
                            </div>
                            <div class="mb-4">
                                <label class="form-label d-flex justify-content-between">
                                    Note de qualité : <span id="noteVal" class="badge bg-primary">3</span>
                                </label>
                                <input type="range" name="note" class="form-range" min="1" max="5" value="3" 
                                       oninput="document.getElementById('noteVal').innerText = this.value">
                            </div>
                            <button type="submit" class="btn btn-primary w-100 py-3 fw-bold">Soumettre mon avis</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>