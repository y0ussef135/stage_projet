<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Demande un crédit</title>


  <script>
    window.history.pushState(null, "", window.location.href);
    window.onpopstate = function () {
        window.history.pushState(null, "", window.location.href);
    };
</script>

  <style>
    body {
      font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
      background: #ffffff;
      color: #2e2e2e;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      margin: 0;
      overflow-x: hidden;
    }
    .container {
      max-width: 1200px;
      margin: 0 auto;
      background: var(--white);
      border-radius: 8px;
      box-shadow: var(--shadow-md);
      padding: 2rem;
                    }
    .back-btn {
       display: inline-flex;
       align-items: center;
       gap: 0.5rem;
       padding: 0.75rem 1.5rem;
       background: #2c3e50;
      color: white;
      border-radius: 6px;
      text-decoration: none;
      font-weight: 800;
      transition: var(--transition);
       margin-bottom: 1.5rem;
        }

        .back-btn:hover {
            background: #1a252f;
            transform: translateY(-2px);
            box-shadow: var(--shadow-sm);
        }

    form {
      background: rgba(255, 255, 255, 0.12);
      backdrop-filter: blur(12px);
      padding: 2.5rem;
      border-radius: 20px;
      box-shadow: 0 8px 32px rgba(139, 0, 0, 0.3);
      width: 100%;
      max-width: 800px;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    form:hover {
      transform: translateY(-5px);
      box-shadow: 0 12px 40px rgba(139, 0, 0, 0.4);
    }

    h2 {
      text-align: center;
      margin-bottom: 2rem;
      font-size: 2rem;
      font-weight: 700;
      background: linear-gradient(to right, #8B0000, #DC143C);
      -webkit-background-clip: text;
      background-clip: text;
      color: transparent;
      text-transform: uppercase;
    }

    h3 {
      margin-top: 1rem;
      margin-bottom: 1rem;
      font-size: 1.2rem;
      font-weight: bold;
      color: #8B0000;
    }

    label {
      font-weight: 600;
      color: #4a0e0e;
      margin-top: 1rem;
    }

    input, select {
      width: 100%;
      padding: 0.6rem;
      margin-top: 0.3rem;
      border-radius: 10px;
      border: 1px solid #ccc; /* Bordure grise claire visible */
      background: #fff; /* Fond blanc bien lisible */
      color: #4a0e0e;
      font-size: 1rem;
      transition: border-color 0.3s ease, box-shadow 0.3s ease;
    }

    input:focus, select:focus {
      border-color: #8B0000; /* Couleur rouge lors du focus */
      outline: none;
      box-shadow: 0 0 0 3px rgba(139, 0, 0, 0.2);
    }

    .step {
      display: none;
    }

    .step.active {
      display: block;
    }

    .progress-bar {
      width: 33.33%;
      height: 6px;
      background-color: #8B0000;
      border-radius: 5px;
      margin: 20px 0;
      transition: width 0.3s ease-in-out;
    }

    button {
      margin-top: 20px;
      padding: 0.75rem 1.5rem;
      font-weight: bold;
      background: linear-gradient(to right, #8B0000, #B22222);
      border: none;
      border-radius: 10px;
      color: white;
      cursor: pointer;
      transition: all 0.3s ease;
    }

    button:hover {
      background: linear-gradient(to right, #5a0000, #8B0000);
    }

    .btn-group {
      display: flex;
      justify-content: space-between;
      gap: 10px;
    }
  </style>
</head>
<body>
  <form id="inscriptionFor" action="demande_cr.php" method="POST">
    
<div class="container">
    <a class="back-btn" href="client_ACCUEIL.php">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <line x1="19" y1="12" x2="5" y2="12"></line>
            <polyline points="12 19 5 12 12 5"></polyline>
        </svg>
        Retour
    </a><h2>Demande un crédit</h2>
    <div class="progress-bar" id="progressBar"></div>
    <!-- Étape 1 -->
    <div class="step active" data-step="1">
      <h3>Informations Personnelles</h3>

      <label for="civilite">Civilité</label>
      <select id="civilite" name="civilite" required>
        <option value="">Sélectionnez</option>
        <option value="M">Monsieur</option>
        <option value="Mme">Madame</option>
        <option value="Mlle">Mademoiselle</option>
      </select>

      <label for="nom">Nom</label>
      <input type="text" id="nom" name="nom" required>

      <label for="prenom">Prénom</label>
      <input type="text" id="prenom" name="prenom" required>

      <label for="nom_epoux">Nom d'époux(se)</label>
      <input type="text" id="nom_epoux" name="nom_epoux">

      <label for="date_naissance">Date de naissance</label>
      <input type="date" id="date_naissance" name="date_naissance" required>

      <label for="lieu_naissance">Lieu de naissance</label>
      <input type="text" id="lieu_naissance" name="lieu_naissance" required>

      <label for="nationalite">Nationalité</label>
      <input type="text" id="nationalite" name="nationalite" required>

      <label for="etat_civil">État civil</label>
      <select id="etat_civil" name="etat_civil" required>
        <option value="">Sélectionnez</option>
        <option value="Célibataire">Célibataire</option>
        <option value="Marié(e)">Marié(e)</option>
        <option value="Divorcé(e)">Divorcé(e)</option>
        <option value="Veuf(ve)">Veuf(ve)</option>
      </select>

      <label for="genre">Genre</label>
      <select id="genre" name="genre" required>
        <option value="">Sélectionnez</option>
        <option value="Homme">Homme</option>
        <option value="Femme">Femme</option>
        <option value="Autre">Autre</option>
      </select>

      <label for="nbre_enfants">Nombre d'enfants</label>
      <input type="number" id="nbre_enfants" name="nbre_enfants" min="0" required>

      <label for="type_pid">Type de pièce d'identité</label>
      <select id="type_pid" name="type_pid" required>
        <option value="">Sélectionnez</option>
        <option value="CIN">CIN</option>
        <option value="Passeport">Passeport</option>
      </select>

      <label for="numero_pid">Numéro de pièce d'identité</label>
      <input type="text" id="numero_pid" name="numero_pid" required>

      <label for="date_delivrance">Date de délivrance</label>
      <input type="date" id="date_delivrance" name="date_delivrance" required>

      <label for="lieu_delivrance">Lieu de délivrance</label>
      <input type="text" id="lieu_delivrance" name="lieu_delivrance" required>

      <label for="profession">Profession</label>
      <input type="text" id="profession" name="profession" required>

      <label for="telephone">Numéro de téléphone</label>
      <input type="text" id="telephone" name="telephone" required>

      <label for="email">Adresse Email</label>
      <input type="email" id="email" name="email" required>
      
      <label for="file">Vos données </label>
      <input type="file" id="file" name="file" required>

      <button type="button" class="next-btn" data-next="2">Suivant</button>
    </div>

    <!-- Étape 2 -->
    <div class="step" data-step="2">
      <h3>Informations de Demande</h3>

      <label for="objet_credit">Objet du crédit</label>
      <input type="text" id="objet_credit" name="objet_credit" required>

      <label for="montant_demande">Montant demandé</label>
      <input type="number" id="montant_demande" name="montant_demande" min="0" required>

      <label for="duree">Durée (en mois)</label>
      <input type="number" id="duree" name="duree" min="1" required>

      <label for="periodicite">Périodicité</label>
      <select id="periodicite" name="periodicite" required>
        <option value="">Sélectionnez</option>
        <option value="Mensuelle">Mensuelle</option>
        <option value="Trimestrielle">Trimestrielle</option>
        <option value="Semestrielle">Semestrielle</option>
        <option value="Annuelle">Annuelle</option>
      </select>

      <label for="agence">Agence</label>
      <input type="text" id="agence" name="agence" required>

      <div class="btn-group">
        <button type="button" class="prev-btn" data-prev="1">Précédent</button>
        <button type="button" class="next-btn" data-next="3">Suivant</button>
      </div>
    </div>

    <!-- Étape 3 -->
    <div class="step" data-step="3">
      <h3>Informations de Projet</h3>

      <label for="objet_projet">Objet du projet</label>
      <input type="text" id="objet_projet" name="objet_projet" required>

      <label for="adresse">Adresse</label>
      <input type="text" id="adresse" name="adresse" required>

      <label for="gouvernorat">Gouvernorat</label>
      <input type="text" id="gouvernorat" name="gouvernorat" required>

      <label for="delegation">Délégation</label>
      <input type="text" id="delegation" name="delegation" required>

      <label for="localite">Localité</label>
      <input type="text" id="localite" name="localite" required>

      <label for="code_postal">Code postal</label>
      <input type="text" id="code_postal" name="code_postal" required>

      <label for="nbre_emplois_creer">Nombre d'emplois à créer</label>
      <input type="number" id="nbre_emplois_creer" name="nbre_emplois_creer" min="0" required>

      <label for="nbre_emplois_existants">Nombre d'emplois existants</label>
      <input type="number" id="nbre_emplois_existants" name="nbre_emplois_existants" min="0" required>

      <label for="installe">Installé</label>
      <select id="installe" name="installe" required>
        <option value="">Sélectionnez</option>
        <option value="Oui">Oui</option>
        <option value="Non">Non</option>
      </select>

      <div class="btn-group">
        <button type="button" class="prev-btn" data-prev="2">Précédent</button>
        <button type="submit">Valider</button>
      </div>
    </div>
  </form>

  <script>
    const steps = document.querySelectorAll(".step");
    const nextBtns = document.querySelectorAll(".next-btn");
    const prevBtns = document.querySelectorAll(".prev-btn");
    const progressBar = document.getElementById("progressBar");

    function validateStep(step) {
      const inputs = step.querySelectorAll("input[required], select[required]");
      for (let input of inputs) {
        if (!input.value.trim()) {
          input.style.borderColor = "red";
          return false;
        } else {
          input.style.borderColor = "";
        }
      }
      return true;
    }

    function updateProgress(currentStep) {
      const progress = (currentStep / steps.length) * 100;
      progressBar.style.width = progress + "%";
    }

    nextBtns.forEach((btn) => {
      btn.addEventListener("click", () => {
        const currentStep = document.querySelector(".step.active");
        if (validateStep(currentStep)) {
          const nextStep = btn.getAttribute("data-next");
          currentStep.classList.remove("active");
          document.querySelector(`.step[data-step="${nextStep}"]`).classList.add("active");
          updateProgress(nextStep);
        } else {
          alert("Veuillez remplir tous les champs obligatoires.");
        }
      });
    });

    prevBtns.forEach((btn) => {
      btn.addEventListener("click", () => {
        const prevStep = btn.getAttribute("data-prev");
        document.querySelector(".step.active").classList.remove("active");
        document.querySelector(`.step[data-step="${prevStep}"]`).classList.add("active");
        updateProgress(prevStep);
      });
    });

    document.getElementById("inscriptionForm").addEventListener("submit", function (e) {
      const currentStep = document.querySelector(".step.active");
      if (!validateStep(currentStep)) {
        e.preventDefault();
        alert("Veuillez remplir tous les champs avant de soumettre.");
      }
    });
  </script>
</body>
</html>
