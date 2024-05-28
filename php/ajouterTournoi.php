<?php
require '../inc/init.inc.php';
$title = "BoldlyWinning";
$h1 = "Show off, fight the odds, all in the hope of Boldly Winning !";
require '../inc/header.inc.php';


if (!estConnecte()) {
    header('location:connexion.php');
    exit();
}

if (!empty($_POST)) {
  /*   $_POST['nom_tournoi'] = htmlspecialchars($_POST['nom_tournoi']);
    $_POST['description'] = htmlspecialchars($_POST['description']);
    $_POST['nombre_joueur'] = !empty($_POST['nombre_joueur']) ? htmlspecialchars($_POST['nombre_joueur']) : null;
    $_POST['date_debut'] = htmlspecialchars($_POST['date_debut']);
    $_POST['date_fin'] = !empty($_POST['date_fin']) ? htmlspecialchars($_POST['date_fin']) : null;
    $_POST['check_in'] = !empty($_POST['check_in']) ? htmlspecialchars($_POST['check_in']) : null;
    $_POST['check_in_fin'] = !empty($_POST['check_in_fin']) ? htmlspecialchars($_POST['check_in_fin']) : null;
    $_POST['cp'] = !empty($_POST['cp']) ? htmlspecialchars($_POST['cp']) : null;
    $_POST['montant_entree'] = !empty($_POST['montant_entree']) ? htmlspecialchars($_POST['montant_entree']) : null;
    $_POST['montant_jeux'] = !empty($_POST['montant_jeux']) ? htmlspecialchars($_POST['montant_jeux']) : null;
    $_POST['jeux'] = !empty($_POST['jeux']) ? htmlspecialchars($_POST['jeux']) : null;
    $_POST['image'] = htmlspecialchars($_POST['image']);
    $_POST['banniere'] = !empty($_POST['banniere']) ? htmlspecialchars($_POST['banniere']) : null;
 */

foreach ($_POST as $cle => $valeur) {
    // Vérifier si la valeur est vide et si elle ne peut pas être null
    if (empty($valeur) && $cle !== 'nom_bracket') {
        $_POST[$cle] = null; // Définir la valeur sur null
    } else {
        $_POST[$cle] = htmlspecialchars($valeur); // Appliquer htmlspecialchars aux valeurs non vides
    }
}
    if (!empty($_POST)) {
        // Vérifiez si des informations obligatoires sont manquantes
        $champs_obligatoires = ['nom_tournoi', 'description', 'image', 'jeux', 'date_debut'];
        foreach ($champs_obligatoires as $champ) {
            if (empty($_POST[$champ])) {
                $contenu .= "<div class=\"alert alert-danger\">Le champ $champ est obligatoire</div>";
            }
        }
    }
    if (!empty($contenu)) {
        echo '<div class="alert alert-danger">Veuillez corriger les erreurs ci-dessous :</div>';
    }
    if (empty($contenu)) {
        $ajout = $pdoTournoi->prepare("INSERT INTO tournoi (nom_tournoi, description, nom_createur, id_user, nombre_joueur, date_debut, date_fin, check_in, check_in_fin, cp, montant_entree, montant_jeux, jeux, image, banniere) VALUES (:nom_tournoi, :description, :nom_createur, :id_user, :nombre_joueur, :date_debut, :date_fin, :check_in, :check_in_fin, :cp, :montant_entree, :montant_jeux, :jeux, :image, :banniere)");

        $ajout->execute(array(
            ':nom_tournoi' => $_POST['nom_tournoi'],
            ':description' => $_POST['description'],
            ':nom_createur' => $_SESSION['users']['pseudo'],
            ':id_user' => $_SESSION['users']['id_user'],
            ':nombre_joueur' => $_POST['nombre_joueur'],
            ':date_debut' => $_POST['date_debut'],
            ':date_fin' => $_POST['date_fin'],
            ':check_in' => $_POST['check_in'],
            ':check_in_fin' => $_POST['check_in_fin'],
            ':cp' => $_POST['cp'],
            ':montant_entree' => $_POST['montant_entree'],
            ':montant_jeux' => $_POST['montant_jeux'],
            ':jeux' => $_POST['jeux'],
            ':image' => $_POST['image'],
            ':banniere' => $_POST['banniere']
        ));      
        $id_tournoi = $pdoTournoi->lastInsertId();

        // Insertion du bracket dans la base de données
        $jeux = $_POST['jeux'];
        $Creationbracket = $pdoTournoi->prepare("INSERT INTO bracket (nom_bracket, jeux, id_tournoi,taille_bracket) VALUES (:nom_bracket, :jeux, :id_tournoi, :taille_bracket)");
        $Creationbracket->execute([
            ':id_tournoi' => $id_tournoi, // Utilisation de l'identifiant du tournoi
            ':nom_bracket' => $_POST['nom_bracket'],
            ':taille_bracket' => $_POST['taille_bracket'],
            ':jeux' => $jeux
        ]);
          if($ajout){
 header("location:voirTournoi.php?id_tournoi=" . $id_tournoi . "");
    exit();
    }
    }
} else {
    $contenu .= "<div class=\"alert alert-danger\">Le tournoi n'a pas pu être ajouté !</div>";
}
/* } */


?>
<main class="container d-flex justify-content-center">
    <form action="#" method="POST" class=" p-3 m-3 col-12 col-md-8" enctype="multipart/form-data">
        <p>Les champs avec une étoile doivent être obligatoirement remplis</p>
        <label for="nom_tournoi">Nom du tournoi *:</label>
        <input type="text" id="nom_tournoi" name="nom_tournoi" class="col-12 bg-gris text-white rounded pt-3">
        <?php if (!empty($_POST) && empty($_POST['nom_tournoi'])) {
            echo " <br> <div class=\"alert alert-danger\">Votre tournoi doit obligatoirement avoir un nom</div>";
        } ?><br>

        <label for="description">Description * :</label>
        <textarea id="description" name="description" class="col-12 bg-gris text-white rounded pt-3"></textarea>
        <?php if (!empty($_POST) && empty($_POST['description'])) {
            echo "<br> <div class=\"alert alert-danger\">Vous devez avoir une description</div>";
        } ?><br>

        <label for="nombre_joueur">Nombre de joueurs :</label>
        <input type="number" id="nombre_joueur" name="nombre_joueur" class="col-12 bg-gris text-white rounded pt-3">
        <br>

        <label for="date_debut">Date de début * :</label>
        <input type="datetime-local" id="date_debut" name="date_debut" class="col-12 bg-gris text-white rounded pt-3">
        <?php if (!empty($_POST) && empty($_POST['date_debut'])) {
            echo "<br> <div class=\"alert alert-danger\">Le tournoi doit bien commencer à un moment non ?</div>";
        } ?><br>

        <label for="date_fin">Date de fin :</label>
        <input type="datetime-local" id="date_fin" name="date_fin" class="col-12 bg-gris text-white rounded pt-3"><br>

        <label for="check_in">Check-in :</label>
        <input type="datetime-local" id="check_in" name="check_in" class="col-12 bg-gris text-white rounded pt-3"><br>

        <label for="check_in_fin">Check-in fin :</label>
        <input type="datetime-local" id="check_in_fin" name="check_in_fin" class="col-12 bg-gris text-white rounded pt-3"><br>

        <label for="cp">Cash Prize :</label>
        <input type="number" id="cp" name="cp" class="col-12 bg-gris text-white rounded pt-3"><br>

        <label for="montant_entree">Montant de l'entrée :</label>
        <input type="number" id="montant_entree" name="montant_entree" class="col-12 bg-gris text-white rounded pt-3"><br>

        <label for="montant_jeux">Montant des jeux :</label>
        <input type="number" id="montant_jeux" name="montant_jeux" class="col-12 bg-gris text-white rounded pt-3"><br>

        <label for="nom_bracket">Nom de votre premier bracket :</label>
        <input type="text" id="nom_bracket" name="nom_bracket" class="col-12 bg-gris text-white rounded pt-3"><br>

        <label for="taille_bracket">Limit de joueur sur ce bracket :</label>
        <input type="text" id="taille_bracket" name="taille_bracket" class="col-12 bg-gris text-white rounded pt-3"><br>


        <label for="jeux">Jeux * :</label>
        <input type="text" id="jeux" name="jeux" class="col-12 bg-gris text-white rounded pt-3">
        <?php if (!empty($_POST) && empty($_POST['jeux'])) {
            echo "<br><div class=\"alert alert-danger\">A quoi va t-on jouer ?</div>";
        } ?><br>

        <div class="mb-3">
            <label for="image">URL de l'image *</label>
            <input type="text" name="image" id="image" class="col-12 bg-gris text-white rounded pt-3">
            <?php if (!empty($_POST) && empty($_POST['image'])) {
                echo "<br><div class=\"alert alert-danger\">Il vous faut une image</div>";
            } ?>
        </div>
        <div class="mb-3">
            <label for="image">URL de la banniere</label>
            <input type="text" name="banniere" id="banniere" class="col-12 bg-gris text-white rounded pt-3">
        </div><br>

        <input type="submit" value="Créer le tournoi" class="btn btn-primary mt-2">
    </form>
</main>


<?php
require  '../inc/footer.inc.php';

?>