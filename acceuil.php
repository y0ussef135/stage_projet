
<?php
session_start();

if (!isset($_SESSION['client_id'])) {
    header("Location: index.html");
    exit();
}

$nom = $_SESSION['nom'];
$date_creation = $_SESSION['date_creation'];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Accueil Client</title>
    <link rel="stylesheet" href="CSS/style.css">
</head>
<body>
      <script>
    // Empêche de revenir à la page précédente avec le bouton "retour"
    window.history.pushState(null, "", window.location.href);
    window.onpopstate = function () {
        window.history.pushState(null, "", window.location.href);
    };
</script>
    <form>
        <h2>Bienvenue, <?php echo htmlspecialchars($nom); ?> 👋</h2>

        <div class="form-group">
            <label>Date de création du compte :</label>
            <input type="text" value="<?php echo $date_creation; ?>" readonly>
        </div>

        <p style="text-align:center; margin-top:15px;">
            <a href="demande.php">Faire une demande de crédit</a><br><br>
            <a href="logout.php"> Se déconnecter</a>
        </p>
    </form>
</body>
</html>