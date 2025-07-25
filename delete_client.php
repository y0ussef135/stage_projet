<?php
session_start();
require_once("include/connection.php");

// Sécurité : vérifie que l'utilisateur est un admin connecté
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.html");
    exit();
}

// Vérifier si un ID est passé dans l'URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: admin.php?success=0"); // Redirige avec erreur
    exit();
}

$client_id = intval($_GET['id']);

// Récupérer l'email du client avant suppression
$stmt_email = $conn->prepare("SELECT email FROM user WHERE id = ? AND role = 'client'");
$stmt_email->bind_param("i", $client_id);
$stmt_email->execute();
$result = $stmt_email->get_result();

if ($result->num_rows === 0) {
    header("Location: admin_home.php?success=0"); // Client introuvable
    exit();
}

$row = $result->fetch_assoc();
$email_client = $row['email'];

// Supprimer les demandes associées à ce client (s'il y en a)
$stmt_delete_demande = $conn->prepare("DELETE FROM client_demande WHERE email = ?");
$stmt_delete_demande->bind_param("s", $email_client);
$stmt_delete_demande->execute();

// Supprimer le client
$stmt_delete_user = $conn->prepare("DELETE FROM user WHERE id = ?");
$stmt_delete_user->bind_param("i", $client_id);

if ($stmt_delete_user->execute()) {
    header("Location: admin_home.php?success=1"); // Succès
} else {
    header("Location: admin_home.php?success=0"); // Échec
}
exit();
?>
