<?php 
require_once 'config/db.php'; 
$message = "";

// Traitement du formulaire lors de la soumission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Préparation de la requête selon les colonnes réelles de ta base
        // colonnes : question_id, sexe, niveau, etablissement, restaurant, note_qualite, contenu_reponse
        $stmt = $pdo->prepare("INSERT INTO reponses 
            (question_id, sexe, niveau, etablissement, restaurant, note_qualite, contenu_reponse) 
            VALUES (?, ?, ?, ?, ?, ?, ?)");

        // Exécution avec les données envoyées par le formulaire HTML
        $stmt->execute([
            1,                          // question_id (par défaut)
            $_POST['sexe'],             // 'Masculin' ou 'Féminin'
            $_POST['niveau'],           // L1, L2, etc.
            $_POST['filiere'],          // Sera stocké dans 'etablissement'
            $_POST['resto'],            // Sera stocké dans 'restaurant'
            $_POST['note'],             // Note de 1 à 5
            "Avis étudiant UY1"         // contenu_reponse par défaut
        ]);

        $message = "<div class='alert alert-success shadow-sm'>✅ Merci ! Votre avis sur les restaurants de l'UY1 a été enregistré.</div>";
    } catch (Exception $e) {
        // En cas d'erreur, on affiche le message technique pour comprendre le blocage
        $message = "<div class='alert alert-danger'>❌ Erreur technique : " . $e->getMessage() . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Collecte UY1 - Satisfaction Restau U</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root { --uy1-blue: #004a99; --uy1-gold: #fbbf24; }
        body { background-color: #f0f2f5; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .card-header { background-color: var(--uy1-blue); color: white; border-radius: 15px 15px 0 0 !important; }
        .btn-primary { background-color: var(--uy1-blue); border: none; }
        .btn-primary:hover { background-color: #003366; }
        .badge-note { font-size: 1.1rem; padding: 0.5em 1em; }
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
                        
                        <!-- Affichage du message de succès ou d'erreur -->
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
                                        <option value="Licence 1">Licence 1</option>
                                        <option value="Licence 2">Licence 2</option>
                                        <option value="Licence 3">Licence 3</option>
                                        <option value="Master 1">Master 1</option>
                                        <option value="Master 2">Master 2</option>
                                        <option value="Doctorat">Doctorat</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Établissement (UY1)</label>
                                <select name="filiere" class="form-select" required>
                                    <option value="Faculté des Sciences (FS)">Faculté des Sciences (FS)</option>
                                    <option value="FALSH">FALSH</option>
                                    <option value="Polytechnique (ENSPY)">Polytechnique (ENSPY)</option>
                                    <option value="ENS">E.N.S</option>
                                    <option value="FMSB">Médecine (FMSB)</option>
                                </select>
                            </div>

                            <h5 class="text-muted mb-3 border-bottom pb-2">Évaluation du Service</h5>
                            <div class="mb-3">
                                <label class="form-label">Quel restaurant fréquentez-vous ?</label>
                                <select name="resto" class="form-select" required>
                                    <option value="Restaurant N°1 (Principal)">Restaurant N°1 (Principal)</option>
                                    <option value="Restaurant N°2 (Annexe)">Restaurant N°2 (Annexe)</option>
                                </select>
                            </div>

                            <div class="mb-4">
                                <label class="form-label d-flex justify-content-between">
                                    Note de qualité : <span id="noteVal" class="badge bg-primary badge-note">3</span>
                                </label>
                                <input type="range" name="note" class="form-range" min="1" max="5" value="3" 
                                       oninput="document.getElementById('noteVal').innerText = this.value">
                                <div class="d-flex justify-content-between mt-1">
                                    <small class="text-muted">Médiocre</small>
                                    <small class="text-muted">Excellent</small>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 py-3 fw-bold shadow-sm">
                                ENREGISTRER MON AVIS
                            </button>
                        </form>
                    </div>
                </div>
                <div class="text-center mt-3 text-muted">
                    <small>&copy; 2026 - Projet de Collecte de Données - UY1</small>
                </div>
            </div>
        </div>
    </div>
</body>
</html>