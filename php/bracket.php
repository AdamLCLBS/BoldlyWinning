<?php
$id_bracket = null;
$id_tournoi = null;
require '../inc/init.inc.php';
$title = "BoldlyWinning";
$h1 = "Show off, fight the odds, all in the hope of Boldly Winning !";
require '../inc/header.inc.php';
if (isset($_POST['id_bracket']) && isset($_POST['id_tournoi'])) {
    $id_bracket = $_POST['id_bracket'];
    $id_tournoi = $_POST['id_tournoi'];
    $infobracket = $pdoTournoi->prepare("SELECT * from  bracket,joueur WHERE joueur.id_bracket = bracket.id_bracket  and bracket.id_bracket = :id_bracket ");
    $infobracket->execute([

        ':id_bracket' => $id_bracket,
    ]);
    if ($infobracket->rowCount() == 0) {
        header('location:accueil.php');
        exit();
    }
    $listepoint = $pdoTournoi->prepare("SELECT * FROM joueur,bracket WHERE joueur.id_bracket = bracket.id_bracket  and bracket.id_bracket = :id_bracket ORDER BY nombre_point DESC LIMIT 5  ");
    $listepoint->execute([

        ':id_bracket' => $id_bracket,
    ]);
} else {
    header('location:accueil.php');
    exit();
}
if (estConnecte()) {
    $verifOrga = $pdoTournoi->prepare("SELECT * FROM tournoi WHERE id_user =:id_user and id_tournoi = :id_tournoi");
    $verifOrga->execute([
        ':id_user' => $_SESSION['users']['id_user'],
        ':id_tournoi' => $id_tournoi
    ]);
}
/*



// Récupérer les matchs à partir de la base de données
$requete_matchs = $pdoTournoi->prepare("SELECT * FROM match_bracket WHERE id_bracket = :id_bracket");
$requete_matchs->execute([':id_bracket' => $id_bracket]);
$matchs = $requete_matchs->fetchAll(PDO::FETCH_ASSOC);
?> */
$verifbracket = $pdoTournoi->prepare("SELECT * FROM match_bracket where id_bracket = :id_bracket ");
$verifbracket->execute([
    ':id_bracket' => $id_bracket,

]);

?>

<main class="container my-5">
    <div class="row">
        <div class="col-md-12 bg-transparent text-white">
            <div class="overflow-container col-md-12 overflow-y-auto " id="div1">
                <ul class="list-group list-group-flush">
                    <?php while ($listejoueur = $infobracket->fetch(PDO::FETCH_ASSOC)) { ?>

                        <li class="list-group-item bg-transparent text-white">
                            <div class="row">
                           <div class="col-4">Pseudo : <?php echo $listejoueur['nom_joueur'] ?></div> 
                           <div class="col-4">Point : <?php echo $listejoueur['nombre_point'] ?></div> 
                           <div class="col-4">win : <?php echo $listejoueur['win'] ?> loose : <?php echo $listejoueur['loses'] ?></div> 
                        </div>
                        </li>
                    <?php } ?>
                </ul>
                <button class="btn btn-danger" onclick="toggleDivs()">Classement</button>
                <a class="btn btn-primary" href="voirTournoi.php?id_tournoi=<?php echo  $id_tournoi ?>">Voir le tournoi</a>
            </div>

            <div class="overflow-container col-md-12 overflow-y-auto bg-transparent text-white " style="display: none;" id="div2">
                <h3 class="text-center text-white">top 5</h3>
                <ul class="list-group list-group-flush">

                    <?php while ($listejoueurpoint = $listepoint->fetch(PDO::FETCH_ASSOC)) { ?>
                        <?php $classement = 0; ?>
                        <li class="list-group-item bg-transparent text-white"><?php $classement + 1 ?>
                        
                        <div class="row">
                           <div class="col-4">Pseudo : <?php echo $listejoueurpoint['nom_joueur'] ?></div> 
                           <div class="col-4">Point : <?php echo $listejoueurpoint['nombre_point'] ?></div> 
                           <div class="col-4">win : <?php echo $listejoueurpoint['win'] ?> loose : <?php echo $listejoueurpoint['loses'] ?></div> 
                        </div>

                  
                        
                        </li>
                    <?php } ?>
                </ul>
                <button class="btn btn-danger" onclick="toggleDivs()">Liste des joueurs</button>
                <a class="btn btn-primary" href="voirTournoi.php?id_tournoi=<?php echo $id_tournoi; ?>">Voir le tournoi</a>
            </div>
            <div class="col-12 col-md-1">
                <?php if ($verifbracket->rowCount() > 0) { ?>
                    <?php if (estConnecte()) { ?>
                        <?php if (!$verifOrga->rowCount() == 0 && !estAdmin()) { ?>

                            <form action="deletematch.php" method="POST">
                                <!-- Utilisez un champ caché pour transmettre l'ID du tournoi -->

                                <input type="hidden" name="id_bracket" value="<?php echo $_POST['id_bracket']; ?>">
                                <input type="hidden" name="id_tournoi" value="<?php echo $id_tournoi; ?>">
                                <input type="submit" value="Supprimer tout les matchs" class="btn btn-primary mt-3" name="delete">
                            </form>
                <?php }
                    }
                } ?> <!-- fermeture des 3 if -->
            </div>
        </div>



        <!-- // Afficher les matchs -->
        <div class="col-12 overflow-y-auto d-flex justify-content-center align-items-center">

            <?php
            if ($verifbracket->rowCount() == 0) {
                echo '<div class="row mb-4">'; // Ouvre une ligne Bootstrap avec une marge inférieure de 4 (pour l'espace vertical)
                /* Si il n'ya pas de match généré on verifie si l'utilisateur est connecté, si il est connecté on verifie si il est origa / admin et on lui affiche la génération des match sinon on lui dit que les matchs n'ont pas encore été géneré */

                if (estConnecte()) {      ?>

                    <?php if ($verifOrga->rowCount() == 0 && !estAdmin()) {
                        echo "<p>les matchs n'ont pas encore été géneré</p>";  // Si il n'est pas connecter on lui dit que les matchs ne sont pas géneré 
                    ?>
                    <?php } else { ?> <form action="generer_match.php" method="post" class="text-center">
                            <input type="hidden" name="id_bracket" value="<?php echo $id_bracket; ?>">
                            <input type="hidden" name="id_tournoi" value="<?php echo $id_tournoi; ?>">
                            <button class="btn btn-primary rounded-square" type="submit"> generer les matchs</button>
                        </form>
                <?php }
                } else {
                    echo "<p>les matchs n'ont pas encore été géneré</p>"; // Si il n'est pas connecter on lui dit que les matchs ne sont pas géneré
                };
            }




            $requete_matchs = $pdoTournoi->prepare("SELECT * FROM match_bracket WHERE id_bracket = :id_bracket");
            $requete_matchs->execute([':id_bracket' => $id_bracket]);
            $matchs = $requete_matchs->fetchAll(PDO::FETCH_ASSOC);

            echo '<div class="row col-md-12 col-12 mb-4">'; // Ouvre une ligne Bootstrap avec une marge inférieure de 4 (pour l'espace vertical)

            $roundCount = 0; // Compteur pour suivre le nombre de tours sur la ligne actuelle
            foreach ($matchs as $match) {

                ?>

                <!-- Affiche chaque match dans une colonne Bootstrap col-md-3  -->
                <div class="col-md-3 my-2">
                    <div class="border border-white">
                        <?php if ($match['winner'] == null) { ?>
                            <?php if (!estConnecte()) { ?>
                                <h4 class="text-white tailletitre text-center"> Match de <?php echo $match['p1'] ?> et <?php echo $match['p2'] ?></h4>
                            <?php } elseif ($_SESSION['users']['pseudo'] == $match['p1'] || $_SESSION['users']['pseudo'] == $match['p2']) { ?>
                                <h4 class="text-danger tailletitre text-center">Vos match</h4>
                            <?php } else { ?>
                                <h4 class="text-white tailletitre text-center"> Match de <?php echo $match['p1'] ?> et <?php echo $match['p2'] ?></h4>
                            <?php } ?>
                            <div class="row align-items-center px-1 col-md-12"> <!-- Utilisez une ligne Bootstrap pour aligner les éléments horizontalement -->
                                <div class="col-md-4 text-center"><?php echo $match['p1']; ?></div> <!-- Place le nom du joueur à gauche -->


                                <div class="col-md-4 text-center"> <!-- Place le bouton au centre -->

                                    <form action="score.php?id_match=<?php echo $match['id_match'] ?>" method="post" name="BRACKET">
                                        <input type="hidden" name="id_bracket" value="<?php echo $id_bracket; ?>">
                                        <input type="hidden" name="id_tournoi" value="<?php echo $id_tournoi; ?>">
                                        <?php if (estConnecte()) { ?>
                                            <?php if (($_SESSION['users']['pseudo'] == $match['p1'] || $_SESSION['users']['pseudo'] == $match['p2']) || estAdmin()) { ?>
                                                <button class="btn btn-primary rounded-square" type="submit" name="BRACKET">Score</button>
                                            <?php } else { ?>
                                                <button class="btn btn-primary rounded-square" type="button" name="BRACKET">Score</button>
                                        <?php
                                            }
                                        } else { ?>
                                             <button class="btn btn-primary rounded-square" type="button" name="BRACKET">Score</button>
                                           <?php }   ?>
                                        
                                     
                                    </form>
                                </div>

                                <div class="col-md-4 text-center"><?php echo $match['p2']; ?></div> <!-- Place le nom du joueur à droite -->
                            </div> <!-- Ferme la ligne Bootstrap -->
                    </div>
                </div> <!-- Ferme la colonne Bootstrap -->
            <?php
                        } else { ?>
                <h4 class="text-white tailletitre text-center"> Gagnant : <?php echo $match['winner']; ?></h4>
                <div class="row align-items-center px-1 col-md-12"> <!-- Utilisez une ligne Bootstrap pour aligner les éléments horizontalement -->
                    <div class="col-md-4 text-center"><?php echo $match['p1']; ?></div> <!-- Place le nom du joueur à gauche -->
                    <div class="col-md-4 text-center">
                        <p><?php echo $match['score_p1']; ?> - <?php echo $match['score_p2']; ?></p>
                    </div> <!-- Place le bouton au centre -->
                    <div class="col-md-4 text-center"><?php echo $match['p2']; ?></div> <!-- Place le nom du joueur à droite -->
                </div> <!-- Ferme la ligne Bootstrap -->
        </div>
    </div> <!-- Ferme la colonne Bootstrap -->

<?php } ?>

<?php $roundCount++; // Incrémente le compteur de tours sur la ligne actuelle
?>

<?php   } ?>

</div> <!-- fermer la ligne bootstrap avec la marge inférieur de 4 -->






</div>
</main>



<?php
require '../inc/footer.inc.php';
?>