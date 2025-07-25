<?php
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
        $sql = "INSERT INTO user (nom, prenom, email, password) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $nom, $prenom, $email, $password_hash);

        if ($stmt->execute()) {
            echo "Inscription réussie. <a href=''>Se connecter</a>";
            header("Location: index.html");
        } else {
            echo "Erreur : " . $conn->error;
        }

        $stmt->close();
    } else {
        foreach ($errors as $e) {
            echo "<p style='color:red;'> " . htmlspecialchars($e) . "</p>";
        }
        echo "<p><a href='inscription.html'>⬅ Revenir au formulaire</a></p>";
    }
}

$conn->close();
?>
