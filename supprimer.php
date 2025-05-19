<?php
session_start();
include_once "connexion.php";

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: liste.php");
    exit;
}

$id = intval($_GET['id']);

try {
    $stmt = $pdo->prepare("DELETE FROM entreprises WHERE id = ?");
    $stmt->execute([$id]);

    $_SESSION['message'] = "Entreprise supprimée avec succès.";
} catch (PDOException $e) {
    $_SESSION['message'] = "Erreur lors de la suppression : " . $e->getMessage();
}

header("Location: liste.php");
exit;
