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
    $result = $conn->query("SELECT COUNT(*) as total FROM client_demande WHERE etat = 'en_attente'");
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
    body {
      background: linear-gradient(135deg, #8b1d15ff 0%, #a24b4bff 100%);
      min-height: 100vh;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .dashboard-header {
      background: linear-gradient(135deg, #721e1eff, #982a2aff);
      color: white;
      padding: 2rem 0;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    .stats-card {
      background: white;
      border-radius: 15px;
      box-shadow: 0 8px 25px rgba(0,0,0,0.1);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      border: none;
      margin-bottom: 1.5rem;
    }

    .stats-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 15px 35px rgba(0,0,0,0.15);
    }

    .stats-icon {
      width: 70px;
      height: 70px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 28px;
      margin-bottom: 1rem;
    }

    .btn-dashboard {
      padding: 1.2rem 2rem;
      font-size: 1.1rem;
      font-weight: 600;
      border-radius: 12px;
      transition: all 0.3s ease;
      border: none;
      margin: 0.5rem;
      box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }

    .btn-dashboard:hover {
      transform: translateY(-3px);
      box-shadow: 0 8px 25px rgba(0,0,0,0.2);
    }

    .btn-clients {
      background: linear-gradient(135deg, #b06400ff, #c93d3dff);
      color: white;
    }

    .btn-demandes {
      background: linear-gradient(135deg, #d75c33ff, #fecfcfff);
      color: white;
    }

    .btn-logout {
      background: linear-gradient(135deg, #ff416c, #ff4b2b);
      color: white;
    }

    .welcome-section {
      background: rgba(255,255,255,0.95);
      border-radius: 20px;
      padding: 2rem;
      box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }

    .feature-icon {
      font-size: 2.5rem;
      margin-bottom: 1rem;
    }
  </style>
</head>
<body>

  <!-- Header -->
  <div class="dashboard-header text-center">
    <div class="container">
      <h1><i class="fas fa-chart-line me-3"></i>Tableau de bord Administrateur</h1>
      <p class="lead">Bienvenue dans l'interface de gestion de la Banque BTS</p>
    </div>
  </div>

  <!-- Statistiques -->
  <div class="container mt-5">
    <div class="row">
      <div class="col-md-4">
        <div class="stats-card p-4 text-center">
          <div class="stats-icon bg-primary text-white mx-auto">
            <i class="fas fa-users"></i>
          </div>
          <h3><?php echo $total_clients; ?></h3>
          <p class="text-muted">Clients Inscrits</p>
        </div>
      </div>
      
      <div class="col-md-4">
        <div class="stats-card p-4 text-center">
          <div class="stats-icon bg-success text-white mx-auto">
            <i class="fas fa-file-alt"></i>
          </div>
          <h3><?php echo $total_demandes; ?></h3>
          <p class="text-muted">Demandes Totales</p>
        </div>
      </div>
      
      <div class="col-md-4">
        <div class="stats-card p-4 text-center">
          <div class="stats-icon bg-warning text-white mx-auto">
            <i class="fas fa-clock"></i>
          </div>
          <h3><?php echo $demandes_en_attente; ?></h3>
          <p class="text-muted">Demandes en Attente</p>
        </div>
      </div>
    </div>

    <!-- Section principale -->
    <div class="welcome-section mt-4">
      <div class="text-center mb-5">
        <h2><i class="fas fa-tachometer-alt me-2"></i>Espace Administration</h2>
        <p class="text-muted">Gérez efficacement vos clients et leurs demandes</p>
      </div>

      <div class="text-center">
        <div class="mb-4">
          <i class="feature-icon fas fa-users-cog text-primary"></i>
          <h4>Gestion des Clients</h4>
          <p>Consultez, modifiez et gérez tous les clients de la banque</p>
          <a class="btn btn-dashboard btn-clients" href="admin_clients.php">
            <i class="fas fa-users me-2"></i>Accéder aux Clients
          </a>
        </div>

        <hr class="my-5">

        <div>
          <i class="feature-icon fas fa-tasks text-success"></i>
          <h4>Gestion des Demandes</h4>
          <p>Traitez les demandes de crédit et suivez leur statut</p>
          <a class="btn btn-dashboard btn-demandes" href="admin_demandes.php">
            <i class="fas fa-file-alt me-2"></i>Accéder aux Demandes
          </a>
        </div>

        <div class="mt-5">
          <a class="btn btn-dashboard btn-logout" href="logout.php">
            <i class="fas fa-sign-out-alt me-2"></i>Se déconnecter
          </a>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>