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
        if(empty($nom) || empty($email_contact)) {
            $error = "Le nom et l'email sont obligatoires.";
        } elseif (!filter_var($email_contact, FILTER_VALIDATE_EMAIL)) {
            $error = "Email invalide.";
        } else {
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