<?php
session_start();
include_once "connexion.php";
include_once "header.php";

try {
    // 1. Préparer et exécuter la requête pour récupérer toutes les entreprises
    $stmt = $pdo->query("SELECT * FROM entreprises");
    $entreprises = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <title>Liste des entreprises</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
<div class="container mt-4">
    <h2>Liste des entreprises</h2>

    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>Nom</th>
                <th>Secteur d'activité</th>
                <th>Email</th>
                <th>Téléphone</th>
                <th>Participation</th>
                <th>Date inscription</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php if (count($entreprises) > 0): ?>
            <?php foreach ($entreprises as $entreprise): ?>
                <tr>
                    <td><?= htmlspecialchars($entreprise['nom']) ?></td>
                    <td><?= htmlspecialchars($entreprise['secteur_activite']) ?></td>
                    <td><?= htmlspecialchars($entreprise['email_contact']) ?></td>
                    <td><?= htmlspecialchars($entreprise['telephone']) ?></td>
                    <td><?= htmlspecialchars($entreprise['participation']) ?></td>
                    <td><?= htmlspecialchars($entreprise['date_inscription']) ?></td>
                    <td>
                        <a href="modifier.php?id=<?= $entreprise['id'] ?>" class="btn btn-warning btn-sm">Modifier</a>
                        <a href="supprimer.php?id=<?= $entreprise['id'] ?>" onclick="return confirm('Confirmer la suppression ?')" class="btn btn-sm btn-danger">Supprimer</a>

                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="6" class="text-center">Aucune entreprise trouvée</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
