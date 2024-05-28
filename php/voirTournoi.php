<?php
require '../inc/init.inc.php';
$title = "BoldlyWinning";
$h1 = "Show off, fight the odds, all in the hope of Boldly Winning !";
require '../inc/header.inc.php';


if (isset($_GET['id_tournoi'])) {
    $info = $pdoTournoi->prepare("SELECT * FROM tournoi, users WHERE tournoi.id_user = users.id_user AND id_tournoi = :id_tournoi");
    $info->execute([
        ':id_tournoi' => $_GET['id_tournoi'],
    ]);
    if ($info->rowCount() == 0) {
        header('location:galerieTournoi.php');
        exit();
    }
    $tournoi = $info->fetch(PDO::FETCH_ASSOC);
} else { // si pas d'id_tournoi dans l'url
    header('location:galerieTournoi.php');
    exit();
}



?>
<main class="container">
  <div class="col-12  col-md-12 row mx-auto d-flex justify-content-around ">
      <h1 class="text-center text-red"><?php echo $h1 ?></h1>
      <div class="  col-md-4   col-12  mx-2 mb-4 p-0  ">
          <img src="<?php echo $tournoi['Image'] ?>" alt="" class="img-fluid" style=" height=" 300" width="100%">
          <h5 class=""><?php echo $tournoi['nom_tournoi']; ?> </h5>
          <h6 class="card-subtitle mb-2">Organiser par: <?php echo substr($tournoi['nom_createur'], 0, 200); ?></h6>
          <p class=""><?php echo substr($tournoi['description'], 0, 200); ?> </p>
          <p class="">Début du tournoi : <?php echo $tournoi['date_debut']; ?> </p>
    
          <?php if (!empty($tournoi['date_fin'])) { ?>
              <p class="">Date de fin du tournoi : <?php echo $tournoi['date_fin']; ?> </p>
          <?php    } ?>
          <p class="">Nombre de places : <?php echo  $tournoi['nombre_joueur']; ?> </p>
          <?php if (!empty($tournoi['check_in'])) { ?>
              <p class="">Heure de début du check in : <?php echo $tournoi['check_in']; ?> </p>
          <?php    } ?>
          <?php if (!empty($tournoi['check_in_fin'])) { ?>
              <p class="">Heure de fin du check in : <?php echo $tournoi['check_in_fin']; ?> </p>
          <?php    } ?>
          <?php if (!empty($tournoi['cp'])) { ?>
              <p class="">Cashprize : <?php echo $tournoi['cp']; ?> </p>
          <?php    } ?>
          <?php if (!empty($tournoi['montant_entree'])) { ?>
              <p class="">Inscription venue : <?php echo $tournoi['montant_entree']; ?> </p>
          <?php    } ?>
          <?php if (!empty($tournoi['montant_jeux'])) { ?>
              <p class="">Inscription par jeux : <?php echo $tournoi['montant_jeux']; ?> </p>
          <?php    } ?>
          <p class="">Les jeux disponible: <?php echo $tournoi['jeux']; ?> </p>
          <div class="row">
              <div class="col-md-6">
                  <?php
    
                  if ($tournoi['tournoi_statut'] == 2) { ?> <!-- if tournoi  est fini -->
                      <input type="submit" value="Tournoi Terminé" class="btn btn-primary mt-3">
                  <?php } elseif ($tournoi['tournoi_statut'] == 1) { ?> <!-- if tournoi à commencé -->
                      <input type="submit" value="Tournoi commencé" class="btn btn-primary mt-3">
                      <?php   } else {
                      // le tournoi n'a pas commencer
                      if (estConnecte()) { ?> <form action="inscriptionbracket.php" method="post"> <!-- si il est connecter on lui montre le bouton d'inscription sinon connexion -->
                              <!-- Utilisez un champ caché pour transmettre l'ID du tournoi -->
                              <input type="hidden" name="id_tournoi" value="<?php echo $_GET['id_tournoi']; ?>">
                              <input type="submit" value="S'inscrire" class="btn btn-primary mt-3">
                          </form>
                      <?php } else { ?>
                          <p>Connectez-vous pour vous inscrire au tournoi.</p>
                          <a class="btn btn-secondary text-red" href="Connexion.php">Connexion</a>
                  <?php } // fin de if connecte
                  } // fin de if tournoi est terminer
                  ?>
              </div>
              <div class="col-md-6">
                  <?php if (estConnecte()) { ?>
                      <?php if (estAdmin() || $_SESSION['users']['id_user'] == $tournoi['id_user']) { ?>
                          <form action="modifTournoi.php" method="POST">
                              <!-- Utilisez un champ caché pour transmettre l'ID du tournoi -->
                              <input type="hidden" name="id_tournoi" value="<?php echo $_GET['id_tournoi']; ?>">
                              <input type="submit" value="Modifier" class="btn btn-primary mt-3" name="modifier">
                          </form>
                          <?php if ($tournoi['tournoi_statut'] == 1) { ?>
                              <form action="finirTournoi.php" method="POST">
                                  <!-- Utilisez un champ caché pour transmettre l'ID du tournoi -->
                                  <input type="hidden" name="id_tournoi" value="<?php echo $_GET['id_tournoi']; ?>">
                                  <input type="submit" value="Terminer le tournoi" class="btn btn-primary mt-3" name="terminer">
                              </form>
                          <?php } elseif ($tournoi['tournoi_statut'] == 2) { ?><!-- fin du if tournoi commencer -->
                              <form action="relancerTournoi.php" method="POST">
                                  <!-- Utilisez un champ caché pour transmettre l'ID du tournoi -->
                                  <input type="hidden" name="id_tournoi" value="<?php echo $_GET['id_tournoi']; ?>">
                                  <input type="submit" value="Reset" class="btn btn-primary mt-3" name="reset">
                              </form>
                          <?php }  ?><!-- fin de if du terminer tournoi -->
                      <?php }  ?><!-- fin de if du modifier -->
                  <?php } ?><!-- fin de if du estconnecte -->
              </div>
          </div>
      </div>
    
      <?php
    
    
      $infobracket = $pdoTournoi->prepare("SELECT * from  bracket,tournoi WHERE tournoi.id_tournoi = bracket.id_tournoi  and tournoi.id_tournoi = :id_tournoi ");
      $infobracket->execute([
    
          ':id_tournoi' => $_GET['id_tournoi'],
      ]);
    
      $listejoueur = $pdoTournoi->prepare("SELECT * from  joueur,bracket WHERE joueur.id_bracket = bracket.id_bracket and bracket.id_bracket = :id_bracket ");
    
      $meilleurjoueur = $pdoTournoi->prepare("SELECT * from  joueur,bracket WHERE joueur.id_bracket = bracket.id_bracket and bracket.id_bracket = :id_bracket ORDER BY joueur.nombre_point DESC LIMIT 1");
      /* requete pour afficher le gagnant (plus haut nombre de point) */
    
      while ($bracket = $infobracket->fetch(PDO::FETCH_ASSOC)) {
          $id_bracket = $bracket['id_bracket'];
    
          $meilleurjoueur->execute([
    
              ':id_bracket' => $id_bracket,
          ]);
          $listejoueur->execute([
    
              ':id_bracket' => $id_bracket,
          ]);
      ?>
    
    
          <div class=" card col-md-3  col-12  mx-2 mb-4 p-0 bg-gris text-white">
    
              <h5 class="card-title text-center"><?php echo $bracket['nom_bracket']; ?> <br><?php echo $bracket['jeux']; ?> </h5>
              <h5 class="card-subtitle text-center"><?php echo $bracket['taille_bracket']; ?> place total</h5>
              <div class="overflow-container ">
                  <?php while ($joueur = $listejoueur->fetch(PDO::FETCH_ASSOC)) { ?>
                      <ul class="list-group list-group-flush overflow-y-auto ">
                          <li class="list-group-item bg-gris text-white"><?php echo $joueur['nom_joueur'] ?> : Nombre de point : <?php echo $joueur['nombre_point'] ?> <br>Victoire : <?php echo $joueur['win'] ?> Défaite : <?php echo $joueur['loses'] ?></li>
                      </ul>
                  <?php } ?>
              </div>
              <form action="bracket.php" method="POST">
                  <!-- Utilisez un champ caché pour transmettre l'ID du bracket -->
                  <input type="hidden" name="id_bracket" value="<?php echo $bracket['id_bracket'];  ?>">
                  <input type="hidden" name="id_tournoi" value="<?php echo $_GET['id_tournoi']; ?>">
                  <input type="submit" value="Voir le bracket" class="btn btn-primary mt-3" name="voir">
              </form>
              <!-- si le tournoi est terminer on affiche le gagnat -->
              <?php if ($tournoi['tournoi_statut'] == 2) { ?>
                  <?php while ($gagnant = $meilleurjoueur->fetch(PDO::FETCH_ASSOC)) { ?>
                      <h4 class="text-center pt-5">Gagnant du tournoi :</h4>
                      <p class="text-center "><?php echo  $gagnant['nom_joueur'];?></p>
                  <?php } ?> <!-- fin du while -->
              <?php } ?><!-- fin de la boucle while ligne 113 -->
          <?php } ?>
          </div>
    
  </div>
</main>



<?php
require '../inc/footer.inc.php';
?>