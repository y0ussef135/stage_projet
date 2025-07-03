<?php
session_start();
if (isset($_SESSION['email'])) {
    header("Location: admin_login.php");
    exit;}
require_once("include/connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM admin WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $admin = $result->fetch_assoc();

    if ($admin && $password == $admin['password']) {
        $_SESSION['admin'] = $admin['id'];
        header("Location: admin.php");
        exit();
    } 
    else {
        echo "Accès refusé.";
        echo $admin['password'];
    }

    $stmt->close();
}

$conn->close();
?>
