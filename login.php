
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

    if ($client && password_verify($password, $client['password'])) {
        $_SESSION['client_id'] = $client['id'];
        $_SESSION['nom'] = $client['nom'];
        $_SESSION['date_creation'] = $client['date_creation'];
        header("Location: acceuil.php");
        exit();
    } else {
        echo "Email ou mot de passe incorrect.";
    }

    $stmt->close();
}

$conn->close();
?>
