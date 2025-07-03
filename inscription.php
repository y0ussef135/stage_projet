
<?php
require_once("include/connection.php");

$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupération et nettoyage
    $nom = trim($_POST['nom']);
    $prenom = trim($_POST['prenom']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $date_naissance = $_POST['date_naissance'];
    $lieu_naissance = trim($_POST['lieu_naissance']);
    $carte_postale = trim($_POST['carte_postale']);
    $adresse = trim($_POST['adresse']);
    $cin_passeport = trim($_POST['cin_passeport']);
    $telephone = trim($_POST['telephone']);

    // Validations (كما في الرد السابق)
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

    if (empty($date_naissance)) {
        $errors[] = "La date de naissance est requise.";
    }

    if (empty($lieu_naissance)) {
        $errors[] = "Le lieu de naissance est requis.";
    }

    if (!preg_match("/^[0-9]{4,10}$/", $carte_postale)) {
        $errors[] = "Code postal invalide (4 à 10 chiffres).";
    }

    if (strlen($adresse) < 5) {
        $errors[] = "L'adresse doit contenir au moins 5 caractères.";
    }

    if (empty($cin_passeport)) {
        $errors[] = "CIN ou passeport est requis.";
    }

    if (!preg_match("/^[0-9]{8,15}$/", $telephone)) {
        $errors[] = "Numéro de téléphone invalide (entre 8 et 15 chiffres).";
    }

    $check = $conn->prepare("SELECT id FROM client WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();
    if ($check->num_rows > 0) {
        $errors[] = "Cet email est déjà utilisé.";
    }
    $check->close();

    if (empty($errors)) {
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO client (nom, prenom, email, password, date_naissance, lieu_naissance, carte_postale, adresse, cin_passeport, telephone)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssssss", $nom, $prenom, $email, $password_hash, $date_naissance, $lieu_naissance, $carte_postale, $adresse, $cin_passeport, $telephone);

        if ($stmt->execute()) {
            echo "Inscription réussie. <a href='index.html'>Se connecter</a>";
        } else {
            echo " Erreur : " . $conn->error;
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
