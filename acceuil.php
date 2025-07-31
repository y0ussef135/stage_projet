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
      display: block; /* Ajout pour espacer les labels */
    }
    input, select {
      width: 100%;
      padding: 0.6rem;
      margin-top: 0.3rem;
      border-radius: 10px;
      border: 1px solid #ccc;
      background: #fff;
      color: #4a0e0e;
      font-size: 1rem;
      transition: border-color 0.3s ease, box-shadow 0.3s ease;
      box-sizing: border-box; /* Ajout pour gérer le padding correctement */
    }
    input:focus, select:focus {
      border-color: #8B0000;
      outline: none;
      box-shadow: 0 0 0 3px rgba(139, 0, 0, 0.2);
    }
    /* Style pour les messages d'erreur */
    .error {
        color: red;
        font-size: 0.8rem;
        margin-top: 5px;
        display: none; /* Caché par défaut */
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
  <!-- Correction de l'ID du formulaire -->
  <form id="inscriptionForm" action="demande_cr.php" method="POST">
    <div class="container">
        <a class="back-btn" href="client_ACCUEIL.php">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="19" y1="12" x2="5" y2="12"></line>
                <polyline points="12 19 5 12 12 5"></polyline>
            </svg>
            Retour
        </a>
        <h2>Demande un crédit</h2>
        <div class="progress-bar" id="progressBar"></div>

        <!-- Étape 1 -->
        <div class="step active" data-step="1">
          <h3>Informations Personnelles</h3>
          <label for="civilite">Civilité *</label>
          <select id="civilite" name="civilite" required>
            <option value="">Sélectionnez</option>
            <option value="M">Monsieur</option>
            <option value="Mme">Madame</option>
            <option value="Mlle">Mademoiselle</option>
          </select>
          <label for="nom">Nom *</label>
          <input type="text" id="nom" name="nom" required>
          <label for="prenom">Prénom *</label>
          <input type="text" id="prenom" name="prenom" required>
          <!-- Champ optionnel -->
          <label for="nom_epoux">Nom d'époux(se)</label>
          <input type="text" id="nom_epoux" name="nom_epoux">
          <label for="date_naissance">Date de naissance *</label>
          <input type="date" id="date_naissance" name="date_naissance" required>
          <label for="lieu_naissance">Lieu de naissance *</label>
          <input type="text" id="lieu_naissance" name="lieu_naissance" required>
          <label for="nationalite">Nationalité *</label>
          <input type="text" id="nationalite" name="nationalite" required>
          <label for="etat_civil">État civil *</label>
          <select id="etat_civil" name="etat_civil" required>
            <option value="">Sélectionnez</option>
            <option value="Célibataire">Célibataire</option>
            <option value="Marié(e)">Marié(e)</option>
            <option value="Divorcé(e)">Divorcé(e)</option>
            <option value="Veuf(ve)">Veuf(ve)</option>
          </select>
          <label for="genre">Genre *</label>
          <select id="genre" name="genre" required>
            <option value="">Sélectionnez</option>
            <option value="Homme">Homme</option>
            <option value="Femme">Femme</option>
            <option value="Autre">Autre</option>
          </select>
          <!-- Champ optionnel -->
          <label for="nbre_enfants">Nombre d'enfants</label>
          <input type="number" id="nbre_enfants" name="nbre_enfants" min="0">
          <label for="type_pid">Type de pièce d'identité *</label>
          <select id="type_pid" name="type_pid" required>
            <option value="">Sélectionnez</option>
            <option value="CIN">CIN</option>
            <option value="Passeport">Passeport</option>
          </select>
          <label for="numero_pid">Numéro de pièce d'identité *</label>
          <input type="text" id="numero_pid" name="numero_pid" required minlength="8" maxlength="8">
          <span id="numero_pid_error" class="error">Le numéro de pièce d'identité doit contenir exactement 8 caractères.</span>
          <label for="date_delivrance">Date de délivrance *</label>
          <input type="date" id="date_delivrance" name="date_delivrance" required>
          <label for="lieu_delivrance">Lieu de délivrance *</label>
          <input type="text" id="lieu_delivrance" name="lieu_delivrance" required>
          <label for="profession">Profession *</label>
          <input type="text" id="profession" name="profession" required>
          <label for="telephone">Numéro de téléphone *</label>
          <input type="text" id="telephone" name="telephone" required minlength="8" maxlength="8">
          <span id="telephone_error" class="error">Le numéro de téléphone doit contenir exactement 8 chiffres.</span>
          <label for="email">Adresse Email *</label>
          <input type="email" id="email" name="email" required>
          <span id="email_error" class="error">Veuillez saisir une adresse email valide.</span>
          <button type="button" class="next-btn" data-next="2">Suivant</button>
        </div>

        <!-- Étape 2 -->
        <div class="step" data-step="2">
          <h3>Informations de Demande</h3>
          <label for="objet_credit">Objet du crédit *</label>
          <input type="text" id="objet_credit" name="objet_credit" required>
          <label for="montant_demande">Montant demandé *</label>
          <input type="number" id="montant_demande" name="montant_demande" min="0" required>
          <label for="duree">Durée (en mois) *</label>
          <input type="number" id="duree" name="duree" min="1" required>
          <label for="periodicite">Périodicité *</label>
          <select id="periodicite" name="periodicite" required>
            <option value="">Sélectionnez</option>
            <option value="Mensuelle">Mensuelle</option>
            <option value="Trimestrielle">Trimestrielle</option>
            <option value="Semestrielle">Semestrielle</option>
            <option value="Annuelle">Annuelle</option>
          </select>
          <label for="agence">Agence *</label>
          <input type="text" id="agence" name="agence" required>
          <div class="btn-group">
            <button type="button" class="prev-btn" data-prev="1">Précédent</button>
            <button type="button" class="next-btn" data-next="3">Suivant</button>
          </div>
        </div>

        <!-- Étape 3 -->
        <div class="step" data-step="3">
          <h3>Informations de Projet</h3>
          <label for="objet_projet">Objet du projet *</label>
          <input type="text" id="objet_projet" name="objet_projet" required>
          <label for="adresse">Adresse *</label>
          <input type="text" id="adresse" name="adresse" required>
          <label for="gouvernorat">Gouvernorat *</label>
          <input type="text" id="gouvernorat" name="gouvernorat" required>
          <label for="delegation">Délégation *</label>
          <input type="text" id="delegation" name="delegation" required>
          <label for="localite">Localité *</label>
          <input type="text" id="localite" name="localite" required>
          <label for="code_postal">Code postal *</label>
          <input type="text" id="code_postal" name="code_postal" required>
          <label for="nbre_emplois_creer">Nombre d'emplois à créer *</label>
          <input type="number" id="nbre_emplois_creer" name="nbre_emplois_creer" min="0" required>
          <label for="nbre_emplois_existants">Nombre d'emplois existants *</label>
          <input type="number" id="nbre_emplois_existants" name="nbre_emplois_existants" min="0" required>
          <label for="installe">Installé *</label>
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
    </div>
  </form>

  <script>
    const steps = document.querySelectorAll(".step");
    const nextBtns = document.querySelectorAll(".next-btn");
    const prevBtns = document.querySelectorAll(".prev-btn");
    const progressBar = document.getElementById("progressBar");

    // Fonction de validation améliorée
    function validateStep(stepElement) {
        let isValid = true;
        const inputs = stepElement.querySelectorAll("input[required], select[required]");

        for (let input of inputs) {
            // Réinitialiser les styles
            input.style.borderColor = "";
            // Masquer les messages d'erreur spécifiques
            const errorSpan = document.getElementById(input.id + "_error");
            if (errorSpan) errorSpan.style.display = "none";

            // Vérification standard des champs requis
            if (!input.value.trim()) {
                input.style.borderColor = "red";
                isValid = false;
                continue; // Passer à l'input suivant
            }

            // Vérifications spécifiques
            if (input.id === "numero_pid" || input.id === "telephone") {
                const value = input.value.trim();
                if (value.length !== 8 || isNaN(value)) {
                    input.style.borderColor = "red";
                    const errorSpan = document.getElementById(input.id + "_error");
                    if (errorSpan) errorSpan.style.display = "block";
                    isValid = false;
                }
            }

            if (input.id === "email") {
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(input.value.trim())) {
                    input.style.borderColor = "red";
                    const errorSpan = document.getElementById("email_error");
                    if (errorSpan) errorSpan.style.display = "block";
                    isValid = false;
                }
            }
        }
        return isValid;
    }

    function updateProgress(currentStep) {
      // Calcul basé sur 3 étapes au lieu de 4
      const totalSteps = 3;
      const progress = (currentStep / totalSteps) * 100;
      progressBar.style.width = progress + "%";
    }

    nextBtns.forEach((btn) => {
      btn.addEventListener("click", () => {
        const currentStepElement = document.querySelector(".step.active");
        const currentStepNumber = parseInt(currentStepElement.dataset.step);

        if (validateStep(currentStepElement)) {
          const nextStepNumber = parseInt(btn.getAttribute("data-next"));
          currentStepElement.classList.remove("active");
          document.querySelector(`.step[data-step="${nextStepNumber}"]`).classList.add("active");
          updateProgress(nextStepNumber);
        } else {
          alert("Veuillez remplir correctement tous les champs obligatoires.");
        }
      });
    });

    prevBtns.forEach((btn) => {
      btn.addEventListener("click", () => {
        const prevStepNumber = parseInt(btn.getAttribute("data-prev"));
        document.querySelector(".step.active").classList.remove("active");
        document.querySelector(`.step[data-step="${prevStepNumber}"]`).classList.add("active");
        updateProgress(prevStepNumber);
      });
    });

    // Gestion de la soumission finale
    document.getElementById("inscriptionForm").addEventListener("submit", function (e) {
      const currentStepElement = document.querySelector(".step.active");
      const currentStepNumber = parseInt(currentStepElement.dataset.step);

      if (currentStepNumber !== 3 || !validateStep(currentStepElement)) {
        e.preventDefault();
        if(currentStepNumber !== 3) {
             alert("Veuillez terminer toutes les étapes.");
        } else {
             alert("Veuillez remplir correctement tous les champs obligatoires avant de soumettre.");
        }
      }
      // Si currentStepNumber est 3 et validateStep retourne true, la soumission continue normalement
    });
  </script>
</body>
</html>