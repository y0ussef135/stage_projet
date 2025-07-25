<?php
session_start();
require_once("include/connection.php");

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.html");
    exit();
}

// Traitement de la modification du statut (doit être fait avant tout HTML)
$message = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['demande_id'])) {
    $demande_id = $_POST['demande_id'];
    $etat = $_POST['etat'];
    
    // Vérifier que l'état est valide
    $etats_valides = ['en_attente', 'acceptee', 'refusee'];
    if (in_array($etat, $etats_valides)) {
        $stmt = $conn->prepare("UPDATE client_demande SET etat = ? WHERE id = ?");
        $stmt->bind_param("si", $etat, $demande_id);
        
        if ($stmt->execute()) {
            $message = 'success';
        } else {
            $message = 'error';
        }
        $stmt->close();
    } else {
        $message = 'invalid';
    }
    
    // Redirection avec message
    header('Location: admin_demandes.php?msg=' . $message);
    exit();
}

$demandes = $conn->query("SELECT * FROM client_demande ORDER BY date_creation DESC");
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Gestion Demandes</title>
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
            color: #721e1eff; 
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
            background: linear-gradient(135deg, #721e1eff, #982a2aff);
            color: white;
            font-weight: 600;
        }
        
        tr:hover { 
            background-color: #f8f9ff; 
            transition: background-color 0.3s ease;
        }
        
        .actions form { 
            display: inline-block;
            margin-right: 10px;
        }
        
        select {
            padding: 8px 12px;
            border: 1px solid #721e1eff;
            border-radius: 6px;
            margin-right: 10px;
        }
        
        .btn-update {
            background: linear-gradient(135deg, #00b09b, #96c93d);
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .btn-update:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,176,155,0.3);
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
        
        .etat-en_attente { 
            background-color: #fff3cd; 
            color: #856404; 
            font-weight: bold;
            padding: 5px 12px;
            border-radius: 20px;
            text-align: center;
        }
        
        .etat-acceptee { 
            background-color: #d4edda; 
            color: #155724; 
            font-weight: bold;
            padding: 5px 12px;
            border-radius: 20px;
            text-align: center;
        }
        
        .etat-refusee { 
            background-color: #f8d7da; 
            color: #721c24; 
            font-weight: bold;
            padding: 5px 12px;
            border-radius: 20px;
            text-align: center;
        }
        
        .traitée {
            color: #6c757d;
            font-style: italic;
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
        
        .btn-secondary {
            background: linear-gradient(135deg, #6c757d, #495057);
            color: white;
            padding: 12px 25px;
            border: none;
            border-radius: 25px;
            font-size: 16px;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-block;
            text-align: center;
            margin: 10px 5px;
        }
        
        .btn-secondary:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.2);
        }
    </style>
</head>
<body>

<div class="header">
    <h1>Gestion des Demandes</h1>
    <p>Administration de la Banque BTS</p>
</div>

<div class="container">

<?php
// Afficher les messages
if (isset($_GET['msg'])) {
    if ($_GET['msg'] == 'success') {
        echo '<div class="success-message">Statut mis à jour avec succès.</div>';
    } elseif ($_GET['msg'] == 'error') {
        echo '<div class="error-message">Erreur lors de la mise à jour.</div>';
    } elseif ($_GET['msg'] == 'invalid') {
        echo '<div class="error-message">État invalide.</div>';
    }
}

?>

<h2>Liste des Demandes</h2>

<input type="text" class="search-box" placeholder="Rechercher une demande..." onkeyup="filterDemandes()">

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Nom Prénom</th>
            <th>Objet Crédit</th>
            <th>Montant</th>
            <th>Agence</th>
            <th>Date</th>
            <th>État</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($demande = $demandes->fetch_assoc()): 
            $etat_class = 'etat-' . $demande['etat'];
            $etat_text = ucfirst(str_replace('_', ' ', $demande['etat']));
        ?>
        <tr>
            <td><?= $demande['id'] ?></td>
            <td><?= htmlspecialchars($demande['nom'] . ' ' . $demande['prenom']) ?></td>
            <td><?= htmlspecialchars($demande['objet_credit']) ?></td>
            <td><?= htmlspecialchars($demande['montant_demande']) ?> TND</td>
            <td><?= htmlspecialchars($demande['agence']) ?></td>
            <td><?= date('d/m/Y', strtotime($demande['date_creation'])) ?></td>
            <td class="<?= $etat_class ?>"><?= $etat_text ?></td>
            <td class="actions">
                <form method="POST">
                    <input type="hidden" name="demande_id" value="<?= $demande['id'] ?>">
                    <select name="etat">
                        <option value="en_attente" <?= $demande['etat'] == 'en_attente' ? 'selected' : '' ?>>En attente</option>
                        <option value="acceptee" <?= $demande['etat'] == 'acceptee' ? 'selected' : '' ?>>Acceptée</option>
                        <option value="refusee" <?= $demande['etat'] == 'refusee' ? 'selected' : '' ?>>Refusée</option>
                    </select>
                    <button type="submit" class="btn-update">Mettre à jour</button>
                </form>
            </td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<div style="text-align: center; margin-top: 30px;">
    <a href="admin_home.php" class="btn-secondary">
        <i class="fas fa-arrow-left"></i> Retour
    </a>
    <a id="btn-deco" href="logout.php">Se déconnecter</a>
</div>

</div>

<script>
function filterDemandes() {
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