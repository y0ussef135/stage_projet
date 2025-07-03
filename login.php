<?php
session_start();
require_once("include/connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    $sql = "SELECT * FROM client WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $client = $result->fetch_assoc();
    $stmt->close();

    if ($client) {
        if ($client['Etat'] === 'vérrouillé') {
            echo "<script>alert('Votre compte est désactivé. Veuillez contacter le support.'); window.location.href='index.html';</script>";
            exit();
        }

        if (password_verify($password, $client['password'])) {
            $_SESSION['client_id'] = $client['id'];
            $_SESSION['nom'] = $client['nom'];
            $_SESSION['date_creation'] = $client['date_creation'];

            $reset = $conn->prepare("UPDATE client SET nb_cnx = 0 WHERE email = ?");
            $reset->bind_param("s", $email);
            $reset->execute();
            $reset->close();

            header("Location: acceuil.php");
            exit();
        } else {
            // Mot de passe incorrect → incrémentation
            $fail = $conn->prepare("UPDATE client SET nb_cnx = nb_cnx + 1 WHERE email = ?");
            $fail->bind_param("s", $email);
            $fail->execute();
            $fail->close();

            // Vérifier si on atteint 3 tentatives
            $check = $conn->prepare("SELECT nb_cnx FROM client WHERE email = ?");
            $check->bind_param("s", $email);
            $check->execute();
            $res = $check->get_result();
            $row = $res->fetch_assoc();
            $check->close();

            if ($row && $row['nb_cnx'] >= 3) {
                $lock = $conn->prepare("UPDATE client SET Etat = 'vérrouillé', nb_cnx = 0 WHERE email = ?");
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

<!-- Display the counter below the login form -->
<?php if (isset($_SESSION['login_attempts'])): ?>
    <div style="text-align:center; margin-top:10px; color:#555;">
        <script>
            alert('Nombre de tentatives de connexion : <?php echo $_SESSION['login_attempts']; ?>');
        </script> </div>
<?php endif; ?>
