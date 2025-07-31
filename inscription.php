<?php
// *** CHANGEMENT 1 : Démarrer la session ***
session_start();

require_once("include/connection.php");

$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupération et nettoyage
    $nom = trim($_POST['nom']);
    $prenom = trim($_POST['prenom']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Validations 
    if (empty($nom) || strlen($nom) < 2) {
        $errors[] = "Le nom est requis et doit contenir au moins 2 caractères.";
    }

    if (empty($prenom) || strlen($prenom) < 2) {
        $errors[] = "Le prénom est requis et doit contenir au moins 2 caractères.";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Email invalide.";
    }

    if (strlen($password) < 6) {
        $errors[] = "Le mot de passe doit contenir au moins 6 caractères.";
    }

    // Vérifier si l'email est déjà utilisé
    $check = $conn->prepare("SELECT id FROM user WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();
    if ($check->num_rows > 0) {
        $errors[] = "Cet email est déjà utilisé.";
    }
    $check->close();

    // Si tout est valide
    if (empty($errors)) {
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        // *** CHANGEMENT 2 : Ajouter la date de création ***
        $date_creation = date('Y-m-d H:i:s');
        // *** CHANGEMENT 3 : Insérer avec le rôle 'client' et la date de création ***
        $sql = "INSERT INTO user (nom, prenom, email, password, role, date_creation) VALUES (?, ?, ?, ?, 'client', ?)";
        $stmt = $conn->prepare($sql);
        // *** CHANGEMENT 4 : Lier le paramètre de date ***
        $stmt->bind_param("sssss", $nom, $prenom, $email, $password_hash, $date_creation);

        if ($stmt->execute()) {
            // *** CHANGEMENT 5 : Récupérer l'ID de l'utilisateur nouvellement inscrit ***
            $user_id = $stmt->insert_id;
            $stmt->close();

            // *** CHANGEMENT 6 : Connecter automatiquement l'utilisateur ***
            // Enregistrer les informations dans la session
            $_SESSION['user_id'] = $user_id;
            $_SESSION['email'] = $email;
            $_SESSION['nom'] = $nom; // Utile pour un affichage personnalisé
            $_SESSION['prenom'] = $prenom; // Utile pour un affichage personnalisé
            $_SESSION['role'] = 'client'; // Rôle par défaut pour un nouvel utilisateur
            $_SESSION['date_creation'] = $date_creation; // Date d'inscription

            // *** CHANGEMENT 7 : Rediriger vers la page d'accueil du client ***
            header("Location: client_ACCUEIL.php");
            exit(); // Très important après un header('Location')

        } else {
            // Afficher une erreur générique si l'insertion échoue
            echo "<p style='color:red;'>Erreur lors de l'inscription. Veuillez réessayer.</p>";
            echo "<p><a href='inscription.html'>⬅ Revenir au formulaire</a></p>";
        }

        // Note: $stmt->close(); est appelé plus haut si l'insertion réussit

    } else {
        // Afficher les erreurs de validation
        foreach ($errors as $e) {
            echo "<p style='color:red;'> " . htmlspecialchars($e) . "</p>";
        }
        echo "<p><a href='inscription.html'>⬅ Revenir au formulaire</a></p>";
    }
} else {
    // Si ce n'est pas une requête POST, rediriger vers le formulaire
    header("Location: inscription.html");
    exit();
}

$conn->close();
?>