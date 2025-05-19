<?php

include_once "header.php";

?>

<div class="container mt-5">
  <div class="card shadow rounded-4">
    <div class="card-body">
      <h3 class="card-title mb-4 text-center">Inscription</h3>
      <form action="traitement_incription.php" method="POST">
        <div class="mb-3">
          <label for="nom" class="form-label">Nom de l'entreprise</label>
          <input type="text" class="form-control" id="nom" placeholder="Entrez votre nom" name="nom">
          <p class="error text-danger">
                <?php 
                if (isset($_SESSION['nom_vide'])) {
                    echo $_SESSION['nom_vide'];
                    unset($_SESSION['nom_vide']); // pour qu'elle disparaisse après affichage
                }
                ?>
          </p>
        </div>

        <div class="mb-3">
          <label for="secteur_activite" class="form-label">Secteur d'activité</label>
          <input type="text" class="form-control" id="secteur_activite" placeholder="Entrer votre secteur de participation" name="secteur_activite">
        </div>

        <div class="mb-3">
          <label for="email_contact" class="form-label">Email de contact</label>
          <input type="email" class="form-control" id="email_contact" placeholder="Entrer votre email de contact" name="email_contact">
          <p class="error text-danger">
            <?php 
                if (isset($_SESSION['email_vide'])) {
                    echo $_SESSION['email_vide'];
                    unset($_SESSION['email_vide']); // pour qu'elle disparaisse après affichage
                }
            ?>
          </p>
        </div>

        <div class="mb-3">
          <label for="telephone" class="form-label">Téléphone</label>
          <input type="tel" class="form-control" id="telephone" placeholder="Entrer votre numéro de téléphone" name="telephone">
        </div>

        <div class="mb-3">
          <label for="participation" class="form-label">Type de participation</label>
          <input type="text" class="form-control" id="participation" placeholder="Entrer votre type de participation" name="participation">
        </div>

        <button type="submit" class="btn btn-primary w-100">S'inscrire</button>
      </form>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
