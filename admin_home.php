<?php
session_start();
require_once("include/connection.php");

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.html");
    exit();
}

// Récupérer les statistiques
$total_clients = 0;
$total_demandes = 0;
$demandes_en_attente = 0;

try {
    // Nombre total de clients
    $result = $conn->query("SELECT COUNT(*) as total FROM user WHERE role = 'client'");
    $total_clients = $result->fetch_assoc()['total'];
    
    // Nombre total de demandes
    $result = $conn->query("SELECT COUNT(*) as total FROM client_demande");
    $total_demandes = $result->fetch_assoc()['total'];
    
    // Nombre de demandes en attente
    $result = $conn->query("SELECT COUNT(*) as total FROM client_demande WHERE etat = 'en attente'");
    $demandes_en_attente = $result->fetch_assoc()['total'];
} catch(Exception $e) {
    // En cas d'erreur, les statistiques restent à 0
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tableau de bord - Administration Banque BTS</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <style>
    html, body {
      height: 100%;
      margin: 0;
      padding: 0;
      overflow: hidden; /* Empêche le scroll de la page */
      background: linear-gradient(135deg, #8b1d15ff 0%, #a24b4bff 100%);
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .dashboard-container {
      display: flex;
      flex-direction: column;
      height: 100%;
      padding: 10px;
      box-sizing: border-box;
    }

    .dashboard-header {
      background: linear-gradient(135deg, #721e1eff, #982a2aff);
      color: white;
      padding: 15px 20px;
      border-radius: 15px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
      text-align: center;
      flex-shrink: 0; /* Empêche le header de rétrécir */
      margin-bottom: 15px;
    }

    .main-content {
      flex: 1; /* Prend tout l'espace restant */
      display: flex;
      flex-direction: column;
      justify-content: center; /* Centre verticalement */
      align-items: center; /* Centre horizontalement */
      overflow: hidden; /* Empêche le scroll interne si le contenu dépasse */
      gap: 30px; /* Espacement entre les sections */
    }

    .stats-section {
      display: flex;
      justify-content: center;
      gap: 25px;
      width: 100%;
      max-width: 1200px;
      flex-shrink: 0; /* Empêche la section de rétrécir */
    }

    .stats-card {
      background: white;
      border-radius: 15px;
      box-shadow: 0 8px 25px rgba(0,0,0,0.1);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      border: none;
      width: 220px;
      height: 160px;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
    }

    .stats-card:hover {
      transform: translateY(-8px);
      box-shadow: 0 15px 35px rgba(0,0,0,0.15);
    }

    .stats-icon {
      width: 60px;
      height: 60px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 24px;
      margin-bottom: 12px;
    }

    .actions-section {
      background: rgba(255,255,255,0.95);
      border-radius: 20px;
      padding: 2rem;
      box-shadow: 0 10px 30px rgba(0,0,0,0.1);
      text-align: center;
      width: 100%;
      max-width: 800px;
      flex-shrink: 0; /* Empêche la section de rétrécir */
    }

    .feature-icon {
      font-size: 2.5rem;
      margin-bottom: 1rem;
      color: #721e1e;
    }

    .btn-dashboard {
      padding: 1.2rem 2rem;
      font-size: 1.1rem;
      font-weight: 600;
      border-radius: 12px;
      transition: all 0.3s ease;
      border: none;
      margin: 0.8rem;
      box-shadow: 0 4px 15px rgba(0,0,0,0.1);
      min-width: 250px;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .btn-dashboard:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 25px rgba(0,0,0,0.2);
    }

    .btn-clients {
      background: linear-gradient(135deg, #ff7700ff, #d42e00ff);
      color: white;
    }

    .btn-demandes {
      background: linear-gradient(135deg, #ff2f2fff, #b02c27ff);
      color: white;
    }

    .btn-logout {
      background: linear-gradient(135deg, #ff416c, #ff4b2b);
      color: white;
      margin-top: 1.5rem;
    }

    /* Media queries pour s'adapter aux différentes tailles d'écran */
    @media (max-width: 1100px) {
        .stats-section {
            flex-wrap: wrap;
            gap: 15px;
        }
        .stats-card {
            width: 200px;
            height: 150px;
        }
    }

    @media (max-width: 768px) {
        .stats-section {
            gap: 10px;
        }
        .stats-card {
            width: 160px;
            height: 130px;
            padding: 10px;
        }
        .stats-icon {
            width: 50px;
            height: 50px;
            font-size: 20px;
        }
        h3 {
            font-size: 1.3rem;
        }
        .actions-section {
            padding: 1.5rem;
        }
        .btn-dashboard {
            padding: 1rem 1.5rem;
            font-size: 1rem;
            min-width: 200px;
            margin: 0.5rem;
        }
        .feature-icon {
            font-size: 2rem;
        }
    }

    @media (max-height: 700px) {
        .stats-card {
            height: 120px;
        }
        .actions-section {
            padding: 1rem;
        }
        .btn-dashboard {
            padding: 0.9rem 1.3rem;
            margin: 0.4rem;
        }
    }
  </style>
</head>
<body>
  <div class="dashboard-container">
    <!-- Header -->
    <div class="dashboard-header">
      <h1><i class="fas fa-chart-line me-3"></i>Tableau de bord Administrateur</h1>
      <p class="lead mb-0">Bienvenue dans l'interface de gestion de la Banque BTS</p>
    </div>

    <!-- Contenu principal -->
    <div class="main-content">
      <!-- Statistiques -->
      <div class="stats-section">
        <div class="stats-card">
          <div class="stats-icon bg-primary text-white">
            <i class="fas fa-users"></i>
          </div>
          <h3><?php echo $total_clients; ?></h3>
          <p class="text-muted mb-0">Clients Inscrits</p>
        </div>
        
        <div class="stats-card">
          <div class="stats-icon bg-success text-white">
            <i class="fas fa-file-alt"></i>
          </div>
          <h3><?php echo $total_demandes; ?></h3>
          <p class="text-muted mb-0">Demandes Totales</p>
        </div>
        
        <div class="stats-card">
          <div class="stats-icon bg-warning text-white">
            <i class="fas fa-clock"></i>
          </div>
          <h3><?php echo $demandes_en_attente; ?></h3>
          <p class="text-muted mb-0">Demandes en Attente</p>
        </div>
      </div>

      <!-- Section des actions -->
      <div class="actions-section">
        <div class="mb-4">
          <i class="feature-icon fas fa-tasks"></i>
          <h2 class="mb-4">Espace Administration</h2>
          
          <div class="d-flex flex-wrap justify-content-center">
            <a class="btn btn-dashboard btn-clients me-2 mb-2" href="admin_clients.php">
              <i class="fas fa-users me-2"></i>Accéder aux Clients
            </a>
            <a class="btn btn-dashboard btn-demandes mb-2" href="admin_demandes.php">
              <i class="fas fa-file-invoice me-2"></i>Accéder aux Demandes
            </a>
          </div>
        </div>

        <a class="btn btn-dashboard btn-logout" href="logout.php">
          <i class="fas fa-sign-out-alt me-2"></i>Se déconnecter
        </a>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>