<?php
include_once "header.php";
include_once "connexion.php";


if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: liste.php");
    exit;
}

$id = intval($_GET['id']);

try {
    // Récupérer l'entreprise par id
    $stmt = $pdo->prepare("SELECT * FROM entreprises WHERE id = ?");
    $stmt->execute([$id]);
    $entreprise = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$entreprise) {
        echo "Entreprise non trouvée.";
        exit;
    }

    // Si formulaire soumis (méthode POST), on met à jour
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nom = $_POST['nom'] ?? '';
        $secteur_activite = $_POST['secteur_activite'] ?? '';
        $email_contact = $_POST['email_contact'] ?? '';
        $telephone = $_POST['telephone'] ?? '';
        $participation = $_POST['participation'] ?? '';

        // Simple validation
        $erreur = false;

        if (empty($nom)) {
            $_SESSION['nom_vide'] = "Le nom est obligatoire.";
            $erreur = true;
        }

        if (empty($email_contact)) {
            $_SESSION['email_vide'] = "L'email est obligatoire.";
            $erreur = true;
        } elseif (!filter_var($email_contact, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['email_vide'] = "Email invalide.";
            $erreur = true;
        }

        if (!$erreur) {
            // Mise à jour en base
            $update = $pdo->prepare("UPDATE entreprises SET nom = ?, secteur_activite = ?, email_contact = ?, telephone = ?, participation = ? WHERE id = ?");
            $update->execute([$nom, $secteur_activite, $email_contact, $telephone, $participation, $id]);

            $_SESSION['message'] = "Entreprise mise à jour avec succès.";
            header("Location: liste.php");
            exit;
        }
    }

} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
    exit;
}
?>


<div class="container mt-4">
    <h2>Modifier l'entreprise</h2>

    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form action="" method="POST">
        <div class="mb-3">
            <label for="nom" class="form-label">Nom de l'entreprise</label>
            <input type="text" id="nom" name="nom" class="form-control" value="<?= htmlspecialchars($entreprise['nom']) ?>" required>
        </div>

        <div class="mb-3">
            <label for="secteur_activite" class="form-label">Secteur d'activité</label>
            <input type="text" id="secteur_activite" name="secteur_activite" class="form-control" value="<?= htmlspecialchars($entreprise['secteur_activite']) ?>">
        </div>

        <div class="mb-3">
            <label for="email_contact" class="form-label">Email de contact</label>
            <input type="email" id="email_contact" name="email_contact" class="form-control" value="<?= htmlspecialchars($entreprise['email_contact']) ?>" required>
        </div>

        <div class="mb-3">
            <label for="telephone" class="form-label">Téléphone</label>
            <input type="text" id="telephone" name="telephone" class="form-control" value="<?= htmlspecialchars($entreprise['telephone']) ?>">
        </div>

        <div class="mb-3">
            <label for="participation" class="form-label">Type de participation</label>
            <input type="text" id="participation" name="participation" class="form-control" value="<?= htmlspecialchars($entreprise['participation']) ?>">
        </div>

        <button type="submit" class="btn btn-primary">Mettre à jour</button>
        <a href="liste.php" class="btn btn-secondary">Annuler</a>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
