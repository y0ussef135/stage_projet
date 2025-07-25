<?php
require_once("include/connection.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Sécurisation des données
    function clean($data) {
        return htmlspecialchars(trim($data));
    }

    // Étape 1 : infos personnelles
    $civilite = clean($_POST['civilite']);
    $nom = clean($_POST['nom']);
    $prenom = clean($_POST['prenom']);
    $nom_epoux = clean($_POST['nom_epoux']);
    $date_naissance = $_POST['date_naissance'];
    $lieu_naissance = clean($_POST['lieu_naissance']);
    $nationalite = clean($_POST['nationalite']);
    $etat_civil = clean($_POST['etat_civil']);
    $genre = clean($_POST['genre']);
    $nbre_enfants = intval($_POST['nbre_enfants']);
    $type_pid = clean($_POST['type_pid']);
    $numero_pid = clean($_POST['numero_pid']);
    $date_delivrance = $_POST['date_delivrance'];
    $lieu_delivrance = clean($_POST['lieu_delivrance']);
    $profession = clean($_POST['profession']);
    $telephone = clean($_POST['telephone']);
    $email = clean($_POST['email']);

    // Étape 2 : infos demande
    $objet_credit = clean($_POST['objet_credit']);
    $montant_demande = floatval($_POST['montant_demande']);
    $duree = intval($_POST['duree']);
    $periodicite = clean($_POST['periodicite']);
    $agence = clean($_POST['agence']);

    // Étape 3 : infos projet
    $objet_projet = clean($_POST['objet_projet']);
    $adresse = clean($_POST['adresse']);
    $gouvernorat = clean($_POST['gouvernorat']);
    $delegation = clean($_POST['delegation']);
    $localite = clean($_POST['localite']);
    $code_postal = clean($_POST['code_postal']);
    $nbre_emplois_creer = intval($_POST['nbre_emplois_creer']);
    $nbre_emplois_existants = intval($_POST['nbre_emplois_existants']);
    $file = clean($_POST['files']);
    $installe = clean($_POST['installe']);

    // Requête SQL
    $sql = "INSERT INTO client_demande (
        civilite, nom, prenom, nom_epoux, date_naissance, lieu_naissance, nationalite,
        etat_civil, genre, nbre_enfants, type_pid, numero_pid, date_delivrance, lieu_delivrance,
        profession, telephone, email, objet_credit, montant_demande, duree, periodicite, agence,
        objet_projet, adresse, gouvernorat, delegation, localite, code_postal,
        nbre_emplois_creer, nbre_emplois_existants,files, installe
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param(
        "sssssssssisisssssssdisssssssiiss",
        $civilite, $nom, $prenom, $nom_epoux, $date_naissance, $lieu_naissance, $nationalite,
        $etat_civil, $genre, $nbre_enfants, $type_pid, $numero_pid, $date_delivrance, $lieu_delivrance,
        $profession, $telephone, $email, $objet_credit, $montant_demande, $duree, $periodicite, $agence,
        $objet_projet, $adresse, $gouvernorat, $delegation, $localite, $code_postal,
        $nbre_emplois_creer, $nbre_emplois_existants, $file,$installe
    );
    

    if ($stmt->execute()) {
        echo "<script>alert('Demande envoyée avec succès !'); window.location.href='client_ACCUEIL.php';</script>";
    } else {
        echo "Erreur : " . $stmt->error;
    }


    $stmt->close();
    $conn->close();
} else {
    echo "Méthode non autorisée.";
}
?>
