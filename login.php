<?php
session_start();
require_once("include/connection.php");


// Désactiver le cache pour empêcher le retour arrière
header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1
header("Pragma: no-cache"); // HTTP 1.0
header("Expires: 0"); // Proxies


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    $sql = "SELECT * FROM user WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();

    if ($user) {
        if ($user['Etat'] === 'vérrouillé') {
            echo "<script>alert('Votre compte est désactivé. Veuillez contacter le support.'); window.location.href='index.html';</script>";
            exit();
        }

        if (password_verify($password, $user['password'])) {
            // Authentification réussie
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['nom'] = $user['nom'];
            $_SESSION['date_creation'] = $user['date_creation'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['email'] = $user['email'];
            // Réinitialiser les tentatives
            $reset = $conn->prepare("UPDATE user SET nb_cnx = 0 WHERE email = ?");
            $reset->bind_param("s", $email);
            $reset->execute();
            $reset->close();

            // Redirection selon le rôle
           
        if ($user['role'] === 'admin') {
            header("Location: admin_home.php");
}        else {
             header("Location: client_ACCUEIL.php"); 
}

            exit();
        } else {
            // Mauvais mot de passe
            $fail = $conn->prepare("UPDATE user SET nb_cnx = nb_cnx + 1 WHERE email = ?");
            $fail->bind_param("s", $email);
            $fail->execute();
            $fail->close();

            // Vérifier si 3 tentatives échouées
            $check = $conn->prepare("SELECT nb_cnx FROM user WHERE email = ?");
            $check->bind_param("s", $email);
            $check->execute();
            $res = $check->get_result();
            $row = $res->fetch_assoc();
            $check->close();

            if ($row && $row['nb_cnx'] >= 3) {
                $lock = $conn->prepare("UPDATE user SET Etat = 'vérrouillé', nb_cnx = 0 WHERE email = ?");
                $lock->bind_param("s", $email);
                $lock->execute();
                $lock->close();

                echo "<script>alert('Votre compte a été désactivé après 3 tentatives échouées.'); window.location.href='index.html';</script>";
                exit();
            } else {
                echo "<script>alert('Email ou mot de passe incorrect.'); window.location.href='index.html';</script>";
                exit();
            }
        }
    } else {
        echo "<script>alert('Email non trouvé.'); window.location.href='index.html';</script>";
        exit();
    }
}

$conn->close();
?>
