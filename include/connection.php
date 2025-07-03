


<?php
$host = "localhost";
$user = "root";
$password = "";
$database = "stage_projet";

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Erreur de connexion : " . $conn->connect_error);
}
?>
