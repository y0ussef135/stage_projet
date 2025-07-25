<?php
session_start();
require_once("include/connection.php");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!isset($_SESSION['user_id'])) {
    header("Location: index.html");
    exit();
}
$email = $_SESSION['email'];
$sql = "SELECT objet_credit, montant_demande, duree, periodicite, agence, date_delivrance, etat 
        FROM client_demande 
        WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historique des Demandes | Gestion de Crédit</title>
    <link href="https://fonts.googleapis.com/css2?family=Segoe+UI:wght@400;500;600;700&display=swap" rel="stylesheet">
    
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
        
        h1 {
            color: #ee5858ff;
            text-align: center;
            margin: 1.5rem 0 2.5rem;
            font-weight: 600;
            font-size: 2rem;
        }
        
        .back-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 12px 25px;
            background: linear-gradient(135deg, #72281eff, #982a2aff);
            color: white;
            border-radius: 25px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(30, 60, 114, 0.3);
            margin-bottom: 1.5rem;
        }
        
        .back-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(30, 60, 114, 0.4);
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 1.5rem 0;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            border-radius: 10px;
            background: white;
        }
        
        thead {
            background: linear-gradient(135deg, #721e1eff, #982a2aff);
            color: white;
        }
        
        th {
            padding: 1.2rem;
            text-align: left;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.9rem;
            letter-spacing: 0.5px;
        }
        
        td {
            padding: 1.2rem;
            border-bottom: 1px solid #eee;
        }
        
        tr:hover {
            background-color: #edb2b2ff;
            transition: background-color 0.3s ease;
        }
        
        .no-data {
            text-align: center;
            padding: 3rem;
            color: #982a2aff;
            font-size: 1.2rem;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            margin: 2rem 0;
        }
        
        .status-badge {
            display: inline-block;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .status-en_attente {
            background-color: #fff3cd;
            color: #856404;
        }
        
        .status-acceptee {
            background-color: #d4edda;
            color: #155724;
        }
        
        .status-refusee {
            background-color: #f8d7da;
            color: #721c24;
        }
        
        @media (max-width: 768px) {
            body {
                padding: 10px;
            }
            
            .container {
                padding: 20px;
            }
            
            table {
                display: block;
                overflow-x: auto;
            }
            
            th, td {
                padding: 0.8rem;
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>

<div class="header">
    <h1>Historique des Demandes</h1>
    <p>Gestion de vos demandes de crédit - Banque BTS</p>
</div>

<div class="container">
    <a class="back-btn" href="client_ACCUEIL.php">
        ← Retour
    </a>

    <h1>Mes Demandes de Crédit</h1>

    <?php if ($result->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Objet Crédit</th>
                    <th>Montant</th>
                    <th>Durée</th>
                    <th>Périodicité</th>
                    <th>Agence</th>
                    <th>Date de Délivrance</th>
                    <th>État</th> 
                </tr>
            </thead>
            <tbody>
                <?php while ($demande = $result->fetch_assoc()): 
                    $etat_class = 'status-' . $demande['etat'];
                    $etat_text = ucfirst(str_replace('_', ' ', $demande['etat']));
                ?>
                    <tr>
                        <td><?= htmlspecialchars($demande['objet_credit']) ?></td>
                        <td><?= htmlspecialchars($demande['montant_demande']) ?> TND</td>
                        <td><?= htmlspecialchars($demande['duree']) ?> mois</td>
                        <td><?= htmlspecialchars($demande['periodicite']) ?></td>
                        <td><?= htmlspecialchars($demande['agence']) ?></td>
                        <td><?= htmlspecialchars($demande['date_delivrance']) ?></td>
                        <td><span class="status-badge <?= $etat_class ?>"><?= $etat_text ?></span></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="no-data">
            <p>Aucune demande enregistrée pour le moment.</p>
        </div>
    <?php endif; ?>

    <?php
    $stmt->close();
    $conn->close();
    ?>
</div>

</body>
</html>