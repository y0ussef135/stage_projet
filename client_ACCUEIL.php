<?php
session_start();

if (!isset($_SESSION['user_id'])) {
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espace Client | Gestion de Crédit</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Segoe+UI:wght@400;500;600;700&display=swap">
    <style>
        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            margin: 0; 
            padding: 20px; 
            background: linear-gradient(135deg, #8b1d15ff 0%, #a24b4bff 100%);
            min-height: 100vh;
        }
        
        .header {
            background: linear-gradient(135deg, #721e1eff, #a21c1cff);
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
        
        .welcome-section {
            text-align: center;
            margin-bottom: 40px;
        }
        
        .welcome-section h1 {
            color: #721e1eff;
            font-size: 2.5rem;
            margin-bottom: 10px;
        }
        
        .highlight {
            color: #ff4141ff;
        }
        
        .account-info {
            color: #982a2aff;
            font-size: 1.1rem;
            font-weight: 500;
        }
        
        .logo-container {
            text-align: center;
            margin: 20px 0;
        }
        
        .logo {
            height: 100px;
            filter: drop-shadow(0 4px 8px rgba(0,0,0,0.2));
        }
        
        .action-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            margin: 40px 0;
        }
        
        .action-card {
            background: white;
            border-radius: 15px;
            padding: 30px;
            text-align: center;
            text-decoration: none;
            color: #721e1eff;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            border: 2px solid transparent;
        }
        
        .action-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.2);
            border-color: #721e1eff;
        }
        
        .action-card.primary {
            background: linear-gradient(135deg, #721e1eff, #982a2aff);
            color: white;
        }
        
        .action-card.primary:hover {
            background: linear-gradient(135deg, #982a2aff, #721e1eff);
            transform: translateY(-15px);
        }
        
        .card-icon {
            font-size: 3rem;
            margin-bottom: 20px;
        }
        
        .action-card h3 {
            font-size: 1.5rem;
            margin-bottom: 15px;
            font-weight: 600;
        }
        
        .action-card p {
            font-size: 1.1rem;
            line-height: 1.6;
            opacity: 0.9;
        }
        
        .logout-section {
            text-align: center;
            margin-top: 50px;
        }
        
        .logout-btn {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 15px 30px;
            background: linear-gradient(135deg, #ff416c, #ff4b2b);
            color: white;
            border-radius: 30px;
            text-decoration: none;
            font-size: 1.1rem;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(255, 65, 108, 0.3);
        }
        
        .logout-btn:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(255, 65, 108, 0.4);
        }
        
        @media (max-width: 768px) {
            .action-grid {
                grid-template-columns: 1fr;
            }
            
            .header {
                padding: 15px;
            }
            
            .welcome-section h1 {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>
    <script>
        // Block back button navigation
        window.history.pushState(null, "", window.location.href);
        window.onpopstate = function () {
            window.history.pushState(null, "", window.location.href);
        };
    </script>

    <div class="header">
        <h1>Espace Client Banque BTS</h1>
        <p>Gestion de vos demandes de crédit</p>
    </div>

    <div class="container">
        <div class="welcome-section">
            <h1>Bienvenue, <span class="highlight"><?php echo htmlspecialchars($nom); ?></span></h1>
            <p class="account-info">Membre depuis : <?php echo htmlspecialchars($date_creation); ?></p>
        </div>

        <div class="logo-container">
            <img src="IMG/BTS_Banque.png" alt="Company Logo" class="logo">
        </div>

        <div class="action-grid">
            <a href="demandes_hist.php" class="action-card">
                <div class="card-icon">📋</div>
                <h3>Historique des Demandes</h3>
                <p>Consultez vos précédentes demandes de crédit et suivez leur statut</p>
            </a>

            <a href="acceuil.php" class="action-card primary">
                <div class="card-icon">➕</div>
                <h3>Nouvelle Demande</h3>
                <p>Initiez une nouvelle demande de crédit en quelques clics</p>
            </a>
        </div>

        <div class="logout-section">
            <a href="logout.php" class="logout-btn">
                 Déconnexion
            </a>
        </div>
    </div>
</body>
</html>