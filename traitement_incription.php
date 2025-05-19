<?php

session_start();
include_once "connexion.php";
include_once "header.php";


try {
    // 4. Récupération des données POST en sécurité
    $nom = $_POST['nom'] ?? '';
    $secteur_activite = $_POST['secteur_activite'] ?? '';
    $email_contact = $_POST['email_contact'] ?? '';
    $telephone = $_POST['telephone'] ?? '';
    $participation = $_POST['participation'] ?? '';

    // Optionnel : tu peux ajouter des validations simples ici
    if(empty($nom) || empty($email_contact)) {
        $_SESSION['nom_vide'] = "Votre nom est vide";
        $_SESSION['email_vide'] = "Votre email est vide";

        header("Location: inscription.php");
        exit();
    }

    session_start();

    $email = $_POST['email_contact'] ?? '';

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['email_vide'] = "Votre email est invalide";

        header("Location: inscription.php");
    }


    // 5. Préparation et exécution de la requête d'insertion
    $sql = "INSERT INTO entreprises (nom, secteur_activite, email_contact, telephone, participation)
        VALUES (?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nom, $secteur_activite, $email_contact, $telephone, $participation]);

} catch (PDOException $e) {
    // En cas d'erreur, affiche un message simple (à améliorer en prod)
    echo "Erreur : " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <title>Validation</title>
</head>
<body>
    <div class="d-flex justify-content-center align-items-cente border border-dark p-2 py-3 m-2">
        <p class="w-75 text-left d-flex align-items-center text-decoration-none m-0">Inscription réussie !</p>
        <p class="d-flex align-items-center m-0">
            <i class="bi bi-check-circle-fill text-success"></i>
        </p>
    </div>
    <div class="d-flex justify-content-center align-items-center mt-4">
        <a href="liste.php" class="btn btn-dark">Poursuivre vers la page d'acceuil</a>
    </div>
</body>
</html>
