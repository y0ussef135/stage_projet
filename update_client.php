<?php
session_start();
require_once("include/connection.php");

// Vérification admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.html");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupération données client
    $email = $_POST['email'] ?? '';
    $nom = trim($_POST['nom'] ?? '');
    $prenom = trim($_POST['prenom'] ?? '');
    $password = $_POST['password'] ?? '';

    // Validation simple (à adapter selon besoins)
    if (!$email || !$nom || !$prenom) {
        header("Location: edit_client.php?id=" . urlencode($_GET['id'] ?? '') . "&success=0");
        exit();
    }

    // Mise à jour du client (sans changer l'email, clé primaire)
    if ($password) {
        // Hasher le nouveau mot de passe
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("UPDATE user SET nom = ?, prenom = ?, password = ? WHERE email = ?");
        $stmt->bind_param("ssss", $nom, $prenom, $passwordHash, $email);
    } else {
        // Pas de modification de mot de passe
        $stmt = $conn->prepare("UPDATE user SET nom = ?, prenom = ? WHERE email = ?");
        $stmt->bind_param("sss", $nom, $prenom, $email);
    }

    $stmt->execute();

    // Mise à jour de l'état de la demande (si envoyé)
    if (!empty($_POST['id_demande']) && isset($_POST['etat'])) {
        $id_demande = intval($_POST['id_demande']);
        $etat = $_POST['etat'];

        // Vérifier que la valeur d'état est correcte
        $validEtats = ['en attente', 'acceptée', 'refusée'];
        if (in_array($etat, $validEtats)) {
            $stmt2 = $conn->prepare("UPDATE client_demande SET etat = ? WHERE id = ?");
            $stmt2->bind_param("si", $etat, $id_demande);
            $stmt2->execute();
        }
        
        $stmt2->close();
        // Mise à jour de l'état de l'utilisateur
        if (isset($_POST['Etat'])) {
            $etat_user = $_POST['Etat'];
            $validUserEtats = ['actif', 'vérrouillé'];
            if (in_array($etat_user, $validUserEtats)) {
                $stmt3 = $conn->prepare("UPDATE user SET Etat = ? WHERE email = ?");
                $stmt3->bind_param("ss", $etat_user, $email);
                $stmt3->execute();
                $stmt3->close();
            }
        }
    }
    // Redirection avec message de succès
    header("Location: admin_clients.php?success=1");
    exit();
} else {
    header("Location: admin_clients.php");
    exit();
}
?>
