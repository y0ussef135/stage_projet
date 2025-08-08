<?php
session_start();
require_once("include/connection.php");

$errors = [];

// --- TRAITEMENT DU FORMULAIRE ---
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nom = trim($_POST['nom']);
    $prenom = trim($_POST['prenom']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // --- VALIDATIONS SERVEUR ---
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

    if ($password !== $confirm_password) {
        $errors[] = "Les mots de passe ne correspondent pas.";
    }

    // Vérifier si email existe déjà
    $check = $conn->prepare("SELECT id FROM user WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();
    if ($check->num_rows > 0) {
        $errors[] = "Cet email est déjà utilisé.";
    }
    $check->close();

    // --- SI AUCUNE ERREUR ---
    if (empty($errors)) {
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $date_creation = date('Y-m-d H:i:s');

        $sql = "INSERT INTO user (nom, prenom, email, password, role, date_creation) 
                VALUES (?, ?, ?, ?, 'client', ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssss", $nom, $prenom, $email, $password_hash, $date_creation);

        if ($stmt->execute()) {
            $user_id = $stmt->insert_id;
            $stmt->close();

            // Connexion automatique
            $_SESSION['user_id'] = $user_id;
            $_SESSION['email'] = $email;
            $_SESSION['nom'] = $nom;
            $_SESSION['prenom'] = $prenom;
            $_SESSION['role'] = 'client';
            $_SESSION['date_creation'] = $date_creation;

            header("Location: client_ACCUEIL.php");
            exit();
        } else {
            $errors[] = "Erreur lors de l'inscription. Veuillez réessayer.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription Client | Banque BTS</title>
    <link href="https://fonts.googleapis.com/css2?family=Segoe+UI:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            margin: 0; 
            padding: 20px; 
            background: linear-gradient(135deg, #8b1d15ff 0%, #a24b4bff 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .header {
            background: linear-gradient(135deg, #721e1e, #982a2a);
            color: #fff;
            padding: 20px;
            text-align: center;
            border-radius: 12px;
            margin-bottom: 30px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        form {
            max-width: 600px;
            width: 90%;
            background-color: #fff6f6;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            margin: 20px auto;
        }
        h2 {
            color: #ef5d5d;
            text-align: center;
            margin-bottom: 30px;
            font-size: 2rem;
            font-weight: 600;
        }
        .row {
            display: flex;
            gap: 20px;
            margin-bottom: 25px;
        }
        .form-group {
            margin-bottom: 25px;
            flex: 1;
            transition: transform 0.2s ease;
        }
        .form-group:focus-within {
            transform: scale(1.02);
        }
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #721e1e;
            font-size: 1.1rem;
        }
        input[type="text"], input[type="email"], input[type="password"] {
            width: 100%;
            padding: 15px;
            border: 2px solid #721e1e;
            border-radius: 10px;
            font-size: 16px;
            transition: all 0.3s ease;
            box-sizing: border-box;
        }
        input[type="text"]:focus, input[type="email"]:focus, input[type="password"]:focus {
            outline: none;
            border-color: #721e1e;
            box-shadow: 0 0 15px rgba(30, 60, 114, 0.3);
        }
        .error-message {
            color: red;
            display: none;
            font-size: 0.9em;
            margin-top: 5px;
        }
        /* Affichage erreurs serveur */
        .server-error {
            background:#ffe6e6;
            color:#b30000;
            border:1px solid #cc0000;
            padding:10px;
            margin-bottom:15px;
            border-radius:8px;
            text-align:center;
        }
        button[type="submit"] {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #721e1e, #982a2a);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 18px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(30, 60, 114, 0.3);
            margin-top: 10px;
        }
        button[type="submit"]:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(30, 60, 114, 0.4);
        }
        p {
            text-align: center;
            margin: 20px 0;
            font-size: 1.1rem;
        }
        a {
            color: #721e1e;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        a:hover {
            color: #ff4141;
            text-decoration: underline;
        }
        @media (max-width: 768px) {
            form {
                padding: 25px;
                margin: 10px;
            }
            h2 {
                font-size: 1.5rem;
            }
            .row {
                flex-direction: column;
                gap: 0;
            }
        }
    </style>
</head>
<body>
    <div style="width: 100%; max-width: 700px;">
        <div class="header">
            <h1>Inscription</h1>
            <p>Banque BTS - Création de compte sécurisé</p>
        </div>
        
        <form method="POST">
            <h2>Créer votre compte</h2>

            <!-- Afficher les erreurs serveur -->
            <?php if (!empty($errors)): ?>
                <div class="server-error">
                    <?php foreach ($errors as $err) echo htmlspecialchars($err) . "<br>"; ?>
                </div>
            <?php endif; ?>

            <div class="row">
                <div class="form-group">
                    <label for="nom">Nom</label>
                    <input type="text" name="nom" id="nom" value="<?= htmlspecialchars($_POST['nom'] ?? '') ?>" required placeholder="Votre nom">
                    <span id="nom_error" class="error-message"></span>
                </div>

                <div class="form-group">
                    <label for="prenom">Prénom</label>
                    <input type="text" name="prenom" id="prenom" value="<?= htmlspecialchars($_POST['prenom'] ?? '') ?>" required placeholder="Votre prénom">
                    <span id="prenom_error" class="error-message"></span>
                </div>
            </div>

            <div class="form-group">
                <label for="email">Adresse Email</label>
                <input type="email" name="email" id="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required placeholder="votre@email.com">
                <span id="email_error" class="error-message"></span>
            </div>

            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input type="password" name="password" id="password" required placeholder="••••••••">
                <span id="password_error" class="error-message"></span>
            </div>

            <div class="form-group">
                <label for="confirm_password">Confirmer le mot de passe</label>
                <input type="password" name="confirm_password" id="confirm_password" required placeholder="••••••••">
                <span id="confirm_password_error" class="error-message"></span>
            </div>
            
            <button type="submit">S'inscrire</button>

            <p>
                Déjà un compte ? <a href="client_ACCUEIL.php">Se connecter 🔐 </a>
            </p>
        </form>
    </div>

    <script>
    document.querySelector("form").addEventListener("submit", function(e) {
        let isValid = true;

        const nom = document.getElementById("nom");
        const prenom = document.getElementById("prenom");
        const email = document.getElementById("email");
        const password = document.getElementById("password");
        const confirm_password = document.getElementById("confirm_password");

        function showError(input, message) {
            const errorSpan = document.getElementById(input.id + "_error");
            if (message) {
                errorSpan.textContent = message;
                errorSpan.style.display = "block";
                input.style.borderColor = "red";
            } else {
                errorSpan.style.display = "none";
                input.style.borderColor = "#721e1e";
            }
        }

        [nom, prenom, email, password, confirm_password].forEach(input => showError(input, ""));

        if (!nom.value.trim() || nom.value.length < 2) {
            showError(nom, "Le nom doit contenir au moins 2 caractères");
            isValid = false;
        }

        if (!prenom.value.trim() || prenom.value.length < 2) {
            showError(prenom, "Le prénom doit contenir au moins 2 caractères");
            isValid = false;
        }

        if (!email.value.includes("@")) {
            showError(email, "Veuillez entrer un email valide");
            isValid = false;
        }

        if (password.value.length < 6) {
            showError(password, "Le mot de passe doit contenir au moins 6 caractères");
            isValid = false;
        }

        if (password.value !== confirm_password.value) {
            showError(confirm_password, "Les mots de passe ne correspondent pas");
            isValid = false;
        }

        if (!isValid) e.preventDefault();
    });
    </script>
</body>
</html>
