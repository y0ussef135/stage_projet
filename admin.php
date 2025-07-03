<?php
session_start();
require_once("include/connection.php");

if (!isset($_SESSION['admin'])) {
    
    header("Location: admin_login.html");
    exit();
}


$result = $conn->query("SELECT * FROM client");
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
<meta http-equiv="Pragma" content="no-cache" />
<meta http-equiv="Expires" content="0" />

    <meta charset="UTF-8">
    <title>Liste des clients</title>
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
        <h2>Liste des Clients</h2>

        <table border="1" cellpadding="10" style="background-color:white; color:black;">
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Email</th>
                <th>Téléphone</th>
                <th>Actions</th>
            </tr>

            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= htmlspecialchars($row['nom'] . ' ' . $row['prenom']) ?></td>
                    <td><?= htmlspecialchars($row['email']) ?></td>
                    <td><?= htmlspecialchars($row['telephone']) ?></td>
                    <td>
                        <a href="edit_client.php?id=<?= $row['id'] ?>">Modifier</a> |
                        <a href="delete_client.php?id=<?= $row['id'] ?>" onclick="return confirm('Supprimer ce client ?')">Supprimer</a>
                    </td>
                </tr>
            <?php } ?>
        </table> 
          <style>
          #btn1{
        
            width: 100%;
            padding: 12px;
            font-size: 15px;
            background-color: #a91717;
            color: #ffffff;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        
       #btn1:hover {
            background-color: #5c0303;
        }
</style>
            <p>
            <a href="admin_logout.php" id="btn1" > Se déconnecter</a>
        </p>
    </form>
    
</body>
</html>
