<?php
session_start();
require_once("include/connection.php");

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Gestion Clients</title>
    <style>
        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            margin: 0; 
            padding: 20px; 
            background: linear-gradient(135deg, #8b1d15ff 0%, #a24b4bff 100%);
            min-height: 100vh;
        }
        
        .header {
            background: linear-gradient(135deg, #721e1eff, #982a2aff);
            color: #fff;
            padding: 20px;
            text-align: center;
            border-radius: 12px;
            margin-bottom: 30px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background-color: #fff6f6;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        
        h2 { 
            color: #1e3c72; 
            text-align: center; 
            margin-bottom: 30px;
            font-size: 2rem;
        }
        
        table { 
            border-collapse: collapse; 
            width: 100%; 
            margin-top: 20px;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        th, td { 
            padding: 15px; 
            text-align: left; 
            border-bottom: 1px solid #eee; 
        }
        
        th { 
            background: linear-gradient(135deg, #972222ff, #982a2aff);
            color: white;
            font-weight: 600;
        }
        
        tr:hover { 
            background-color: #f8f9ff; 
            transition: background-color 0.3s ease;
        }
        
        .actions a { 
            margin-right: 15px; 
            color: #721e1eff; 
            text-decoration: none;
            padding: 8px 15px;
            border-radius: 6px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .actions a:hover {
            background-color: #721e1eff;
            color: white;
            transform: translateY(-2px);
        }
        
        .search-box { 
            margin: 20px 0; 
            padding: 12px 20px; 
            width: 300px;
            border: 2px solid #721e1eff;
            border-radius: 25px;
            font-size: 16px;
            outline: none;
            transition: all 0.3s ease;
        }
        
        .search-box:focus {
            box-shadow: 0 0 15px rgba(114, 30, 30, 0.3);
        }
        
        #btn-deco { 
            display: block; 
            width: fit-content; 
            margin: 40px auto 0; 
            padding: 12px 25px; 
            background: linear-gradient(135deg, #ff416c, #ff4b2b);
            color: #fff; 
            border-radius: 25px; 
            text-decoration: none; 
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(255, 65, 108, 0.3);
        }
        
        #btn-deco:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(255, 65, 108, 0.4);
        }
        
        
        .actif { 
            background-color: #d4edda; 
            color: #155724; 
            font-weight: bold;
            padding: 5px 12px;
            border-radius: 20px;
            text-align: center;
        }
        
        .verrouille { 
            background-color: #f8d7da; 
            color: #721c24; 
            font-weight: bold;
            padding: 5px 12px;
            border-radius: 20px;
            text-align: center;
        }
        
        /* Messages d'alerte */
        .success-message, .error-message {
            padding: 15px;
            margin: 20px auto;
            width: 90%;
            max-width: 600px;
            text-align: center;
            border-radius: 8px;
            font-weight: 500;
        }
        
        .success-message {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .error-message {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>
<body>

<div class="header">
    <h1>Gestion des Clients</h1>
    <p>Administration de la Banque BTS</p>
</div>

<div class="container">

<?php
if (isset($_SESSION['success_message'])) {
    echo '<div class="success-message">'.$_SESSION['success_message'].'</div>';
    unset($_SESSION['success_message']);
}
if (isset($_SESSION['error_message'])) {
    echo '<div class="error-message">'.$_SESSION['error_message'].'</div>';
    unset($_SESSION['error_message']);
}

if (isset($_GET['success'])): ?>
    <div style="background-color: <?= $_GET['success'] == 1 ? '#d4edda' : '#f8d7da' ?>; 
                color: <?= $_GET['success'] == 1 ? '#155724' : '#721c24' ?>;
                padding: 15px; margin: 20px auto; width: 90%; max-width: 600px; text-align: center;
                border-radius: 8px; border: 1px solid <?= $_GET['success'] == 1 ? '#c3e6cb' : '#f5c6cb' ?>;">
        <?= $_GET['success'] == 1 ? '✔️ Modification enregistrée avec succès.' : '❌ Aucune modification enregistrée.' ?>
    </div>
<?php endif;

$clients = $conn->query("SELECT * FROM user WHERE role = 'client'");
?>

<h2>Liste des Clients</h2>

<input type="text" class="search-box" placeholder="Rechercher un client..." onkeyup="filterClients()">

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Email</th>
            <th>Téléphone</th>
            <th>État</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($client = $clients->fetch_assoc()): 
            $etat_class = ($client['Etat'] == 'actif') ? 'actif' : 'verrouille';
            $etat_text = ($client['Etat'] == 'actif') ? 'Actif' : 'Verrouillé';
        ?>
        <tr>
            <td><?= $client['id'] ?></td>
            <td><?= htmlspecialchars($client['nom']) ?></td>
            <td><?= htmlspecialchars($client['prenom']) ?></td>
            <td><?= htmlspecialchars($client['email']) ?></td>
            <td><?= htmlspecialchars($client['telephone'] ?? 'N/A') ?></td>
            <td class="<?= $etat_class ?>"><?= $etat_text ?></td>
            <td class="actions">
                <a href="edit_client.php?id=<?= $client['id'] ?>">Modifier</a>
                <a href="delete_client.php?id=<?= $client['id'] ?>" onclick="return confirm('Supprimer ce client ?')">Supprimer</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>
<div>
            <a id="btn-deco" href="admin_home.php" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Retour
            </a>
</div>
<a id="btn-deco" href="logout.php">Se déconnecter</a>

</div>

<script>
function filterClients() {
    const input = document.querySelector('.search-box').value.toLowerCase();
    const rows = document.querySelectorAll('tbody tr');
    
    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(input) ? '' : 'none';
    });
}
</script>

</body>
</html>