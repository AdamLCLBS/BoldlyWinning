<?php
require '../inc/init.inc.php';
$title = "BoldlyWinning";
$h1 = "Show off, fight the odds, all in the hope of Boldly Winning !";
require '../inc/header.inc.php';

// Vérifier si les données sont envoyées via la méthode GET dans l'url
if (isset($_GET['id_match'])) {
    // Récupérer l'ID du bracket depuis les données postées
    $id_match = $_GET['id_match'];

   
    

    $match = $pdoTournoi->prepare("SELECT * FROM match_bracket,bracket WHERE bracket.id_bracket = match_bracket.id_bracket AND id_match = :id_match ");
    $match->execute([
        ':id_match' => $id_match,
    ]);
    $infomatch = $match->fetch(PDO::FETCH_ASSOC);
    $p1 = $infomatch['p1'];
    $p2 = $infomatch['p2'];
    $id1 = $infomatch['id_joueur1'];
    $id2 = $infomatch['id_joueur2'];
    if (isset($_POST['score'])) {
        foreach ($_POST as $cle => $valeur) {
            if (!empty($valeur)) {
                $_POST[$cle] = htmlspecialchars($valeur);
            }
        }
    
        // Mettre à jour les scores dans la base de données en fonction des noms des joueurs
        // Remplacer 'score_p1' et 'score_p2' par les champs correspondants dans votre base de données
        // Remplacer 'match_bracket' par le nom de votre table contenant les matchs
        $rocket = $pdoTournoi->prepare("UPDATE match_bracket SET score_p1= :score_p1, score_p2 = :score_p2, p1 = :p1, p2 = :p2, winner = :winner WHERE id_joueur1 = :id_joueur1 AND id_joueur2 = :id_joueur2");
        // Récupérer les scores à partir du formulaire (à remplacer par les noms de vos champs)

      


        // Exécuter la requête
        $rocket->execute([
            ':score_p1' => $_POST['score_p1'],
            ':score_p2' => $_POST['score_p2'],
            ':p1' => $p1,
            ':p2' => $p2,
            ':id_joueur1' => $id1,
            ':id_joueur2' => $id2,
            ':winner' => $_POST['winner'],

        ]);
        if ($rocket) {
            $contenu .= "<div class=\"alert alert-danger\">Les scores on été rentré !</div>";
        } 
        $requeteScoreActuelJoueur1 = $pdoTournoi->prepare("SELECT * FROM joueur WHERE id_joueur = :id_joueur1 ");
        $requeteScoreActuelJoueur1->execute([
            ':id_joueur1' => $id1,
        ]);
        $scoreActuelJoueur1 = $requeteScoreActuelJoueur1->fetch(PDO::FETCH_ASSOC);


        $requeteScoreActuelJoueur2 = $pdoTournoi->prepare("SELECT * FROM joueur WHERE id_joueur = :id_joueur2 ");
        $requeteScoreActuelJoueur2->execute([
            ':id_joueur2' => $id2,
        ]);
        $scoreActuelJoueur2 = $requeteScoreActuelJoueur2->fetch(PDO::FETCH_ASSOC);

        $winJ1 = $scoreActuelJoueur1['win'];
        $winJ2 = $scoreActuelJoueur2['win'];
        $loseJ1 = $scoreActuelJoueur1['loses'];
        $loseJ2 = $scoreActuelJoueur2['loses'];
        $nbrpointJ1 = $scoreActuelJoueur1['nombre_point'];
        $nbrpointJ2 = $scoreActuelJoueur2['nombre_point'];


        if ($_POST['winner'] == $p1) {
            $winJ1 = $winJ1 + 1;
            $loseJ2 = $loseJ2 + 1;
        } else {
            $loseJ1 = $loseJ1 + 1;
            $winJ2 = $winJ2;
        }



        if ($_POST['winner'] == $p1 || $p2) {
            $nbrpointJ1 = $nbrpointJ1 + $_POST['score_p1'];
            $nbrpointJ2 = $nbrpointJ2 + $_POST['score_p2'];
        }

       

        $requeteScoreActualiserJoueur1 = $pdoTournoi->prepare("UPDATE joueur SET nombre_point = :nombre_point, win = :winj1, loses = :losej1  WHERE id_joueur = :id_joueur1 ");
        $requeteScoreActualiserJoueur1->execute([
            ':nombre_point' => $nbrpointJ1,
            ':winj1' => $winJ1,
            ':losej1' => $loseJ1,
            ':id_joueur1' => $id1,
        ]);


        $requeteScoreActualiserJoueur2 = $pdoTournoi->prepare("UPDATE joueur SET nombre_point = :nombre_point, win = :winj2, loses = :losej2  WHERE id_joueur = :id_joueur2 ");
        $requeteScoreActualiserJoueur2->execute([
            ':nombre_point' => $nbrpointJ2,
            ':winj2' => $winJ2,
            ':losej2' => $loseJ2,
            ':id_joueur2' => $id2,
        ]);
      
    }
?>



 
    <main class="container ">
       <div class="row py-5 align-items-center flex-column">
         <div class="row col-md-6 col-12 ">
               <?php if(empty($contenu)){?>
             <form action="#" method="post" id="go">
                 <div class="form-group">
                     <label for="score_p1">Score de <?php echo $p1; ?>:</label>
                     <input type="number"  id="score_p1" name="score_p1" value="0" class="col-12 bg-gris text-white rounded">
                 </div>
                 <div class="form-group">
                     <label for="score_p2">Score de <?php echo $p2; ?>:</label>
                     <input type="number" id="score_p2" name="score_p2" value="0" class="col-12 bg-gris text-white rounded">
                 </div>
        
                 <div class="mb-3">
                     <label for="winner" class="form-label">Vainqueur</label>
                     <select name="winner" id="winner" class="col-12 bg-gris text-white rounded">
                         <option value="<?php echo $p1 ?>"><?php echo $p1 ?></option>
                         <option value="<?php echo $p2 ?>"><?php echo $p2 ?></option>
                     </select>
                 </div>
                 <button type="submit" class="btn btn-primary" name="score">Enregistrer le score</button>
             </form>
         </div>
           <?php  } echo $contenu?>   
           
         <div class="row col-md-6 col-12">
         <form action="bracket.php" method="POST" id="taga">
                 <!-- Utilisez un champ caché pour transmettre l'ID du bracket -->
                 <input type="hidden" name="id_bracket" value="<?php echo $infomatch['id_bracket'];?>">
                 <input type="hidden" name="id_tournoi" value="<?php echo $infomatch['id_tournoi'];?>">
                 <input type="submit" value="Retourner au bracket" class="btn btn-primary mt-3" name="voir">
             </form>
         </div>
       </div class="row">
    </main>
<?php } ?>

<!-- <script>
    document.getElementById('go').addEventListener('submit', function() {
        // Soumettre le deuxième formulaire
        document.getElementById('taga').submit();
    });
</script> -->
<?php
require '../inc/footer.inc.php';
?>