<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header('Location: login.php');
    exit();
}

// Inclure la connexion
include 'include/connection.php';

// Récupérer l'ID du client
$client_id = $_GET['id'] ?? null;

if (!$client_id) {
    header('Location: admin_clients.php');
    exit();
}

// Récupérer les données du client
$stmt = $conn->prepare("SELECT id, nom, prenom, email, Etat FROM user WHERE id = ? AND role = 'client'");
$stmt->bind_param("i", $client_id);
$stmt->execute();
$result = $stmt->get_result();
$client = $result->fetch_assoc();

if (!$client) {
    header('Location: admin_clients.php');
    exit();
}

// Traitement du formulaire de modification
$message = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $etat = $_POST['etat'];
    
    // Requête de mise à jour incluant l'état
    $stmt = $conn->prepare("UPDATE user SET nom = ?, prenom = ?, email = ?, Etat = ? WHERE id = ?");
    $stmt->bind_param("ssssi", $nom, $prenom, $email, $etat, $client_id);
    
    if ($stmt->execute()) {
        $message = '<div style="background-color: #d4edda; color: #155724; padding: 15px; margin: 20px 0; border: 1px solid #c3e6cb; border-radius: 8px; text-align: center;">Client modifié avec succès !</div>';
        // Mettre à jour les données affichées
        $client['nom'] = $nom;
        $client['prenom'] = $prenom;
        $client['email'] = $email;
        $client['Etat'] = $etat;
    } else {
        $message = '<div style="background-color: #f8d7da; color: #721c24; padding: 15px; margin: 20px 0; border: 1px solid #f5c6cb; border-radius: 8px; text-align: center;">Erreur lors de la modification : ' . $conn->error . '</div>';
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Client - Banque BTS</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
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
            max-width: 800px;
            margin: 0 auto;
            background-color: #fff6f6;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        
        h3 { 
            color: #721e1eff; 
            text-align: center; 
            margin-bottom: 30px;
            font-size: 1.8rem;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #721e1eff;
        }
        
        input[type="text"], input[type="email"], select {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #721e1e;
            border-radius: 8px;
            font-size: 16px;
            transition: all 0.3s ease;
            box-sizing: border-box;
            background-color: white;
        }
        
        input[type="text"]:focus, input[type="email"]:focus, select:focus {
            outline: none;
            border-color: #721e1e;
            box-shadow: 0 0 15px rgba(114, 30, 30, 0.3);
        }
        
        input[readonly] {
            background-color: #f8f9fa;
            cursor: not-allowed;
        }
        
        .btn {
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
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #721e1e, #982a2a);
            color: white;
        }
        
        .btn-secondary {
            background: linear-gradient(135deg, #6c757d, #495057);
            color: white;
        }
        
        .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.2);
        }
        
        .btn-container {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
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
            text-align: center;
        }
        
        #btn-deco:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(255, 65, 108, 0.4);
        }
        
        .etat-actif {
            color: #155724;
            font-weight: bold;
        }
        
        .etat-verrouille {
            color: #721c24;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="header">
    <h1>Modifier Client</h1>
    <p>Administration de la Banque BTS</p>
</div>

<div class="container">
    <h3><i class="fas fa-edit"></i> Modification des informations client</h3>
    
    <?php echo $message; ?>
    
    <form method="POST">
        <div class="form-group">
            <label for="id">ID Client</label>
            <input type="text" id="id" value="<?php echo htmlspecialchars($client['id']); ?>" readonly>
        </div>
        
        <div class="form-group">
            <label for="nom">Nom</label>
            <input type="text" id="nom" name="nom" 
                   value="<?php echo htmlspecialchars($client['nom']); ?>" required>
        </div>
        
        <div class="form-group">
            <label for="prenom">Prénom</label>
            <input type="text" id="prenom" name="prenom" 
                   value="<?php echo htmlspecialchars($client['prenom']); ?>" required>
        </div>
        
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" 
                   value="<?php echo htmlspecialchars($client['email']); ?>" required>
        </div>
        
        <div class="form-group">
            <label for="etat">État</label>
            <select id="etat" name="etat" required>
                <option value="actif" <?php echo ($client['Etat'] == 'actif') ? 'selected' : ''; ?>>Actif</option>
                <option value="vérrouillé" <?php echo ($client['Etat'] == 'vérrouillé') ? 'selected' : ''; ?>>Vérrouillé</option>
            </select>
        </div>
        
        <div class="btn-container">
            <a href="admin_clients.php" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Retour
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Enregistrer les modifications
            </button>
        </div>
    </form>
    
    <a id="btn-deco" href="logout.php">Se déconnecter</a>
</div>

</body>
</html>