<?php
session_start();
require_once("include/connection.php");

if (!isset($_SESSION['admin'])) {
    header("Location: index.html");
    exit();
}

if (!isset($_GET['status']) || !isset($_GET['id'])) {
    header("Location: admin.php");
    exit();
}

$status = $_GET['status'];
$id = $_GET['id'];

// Récupérer les infos du client pour afficher son nom
$stmt = $conn->prepare("SELECT nom, prenom FROM client WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$client = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <link rel="stylesheet" href="CSS/style.css?v=2">
    <meta charset="UTF-8">
    <title>Confirmation de modification</title>
   
</head>
<body>
    <div class="container">
        <?php if ($status == 'success'): ?>
            <div class="message success">
                Modification réussie ! Le client <?= htmlspecialchars($client['prenom']).' '.htmlspecialchars($client['nom']) ?> a été mis à jour.
            </div>
        <?php else: ?>
            <div class="message error">
                Erreur lors de la modification du client <?= htmlspecialchars($client['prenom']).' '.htmlspecialchars($client['nom']) ?>.
            </div>
        <?php endif; ?>
        
        <div style="text-align: center;">
            <a href="admin.php" class="btn">Retour à la liste des clients</a>
            <a href="edit_client.php?id=<?= $id ?>" class="btn">Modifier à nouveau</a>
        </div>
    </div>
</body>
</html>