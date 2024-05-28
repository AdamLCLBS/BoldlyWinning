<?php
require '../inc/init.inc.php';
if (isset($_POST['id_tournoi'])) {
    // Récupérer l'ID du tournoi depuis les données postées
    $id_tournoi = $_POST['id_tournoi'];

$infobracket = $pdoTournoi->prepare("SELECT * from  bracket,tournoi WHERE tournoi.id_tournoi = bracket.id_tournoi  and tournoi.id_tournoi = :id_tournoi ");
$infobracket->execute([

    ':id_tournoi' => $id_tournoi,
]);
if ($infobracket->rowCount() == 0) {
    header('location:accueil.php');
    exit();
}
$modifTournoi = $infobracket->fetch(PDO::FETCH_ASSOC);
}else { // si pas d'id_tournoi dans l'url
    header('location:accueil.php');
    exit();
}



        $verifOrga = $pdoTournoi->prepare("SELECT * FROM tournoi WHERE id_user =:id_user and id_tournoi = :id_tournoi");
        $verifOrga->execute([
            ':id_user' => $_SESSION['users']['id_user'],
            ':id_tournoi' => $id_tournoi
        ]);

        if ($verifOrga->rowCount() == 0 && !estAdmin()) {
            header("location:voirTournoi.php?id_tournoi=" . $id_tournoi . "");
            exit();
        }

   
$title = 'Boldly Winning';
require '../inc/header.inc.php';


if (!empty($_POST['update'])) {

    foreach ($_POST as $cle => $valeur) {
        if (!empty($valeur)) {
            $_POST[$cle] = htmlspecialchars($valeur);
        }
    }


    if (!empty($_POST['update'])) {
        // Vérifiez si des informations obligatoires sont manquantes
        $champs_obligatoires = ['nom_tournoi', 'description', 'image', 'jeux', 'date_debut'];
        foreach ($champs_obligatoires as $champ) {
            if (empty($_POST[$champ])) {
                $contenu .= "<div class=\"alert alert-danger\">Le champ $champ est obligatoire</div>";
            }
        }
    }
    if (!empty($contenu)) {
        echo '<div class="alert alert-danger">Les champs ci-dessous sont doivent-etre obligatoirement rempli :</div>';
    }
    if (empty($contenu)) {
        $MAJ = $pdoTournoi->prepare("UPDATE tournoi SET nom_tournoi = :nom_tournoi, description = :description, nombre_joueur = :nombre_joueur, date_debut = :date_debut, date_fin = :date_fin, check_in = :check_in, check_in_fin = :check_in_fin, cp = :cp, montant_entree = :montant_entree, montant_jeux = :montant_jeux, jeux = :jeux, image = :image, banniere = :banniere WHERE id_tournoi = :id_tournoi");

        $MAJ->execute(array(
            ':nom_tournoi' => $_POST['nom_tournoi'],
            ':description' => $_POST['description'],
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
            ':banniere' => $_POST['banniere'],
            ':id_tournoi' => $id_tournoi
        ));
       if ($MAJ) {
            header("location:voirTournoi.php?id_tournoi=" . $id_tournoi . "");
            exit();
        } else {
            $contenu .= "<div class=\"alert alert-danger\">La mise à jour n'a pas fonctionnée !</div>";
        } 
    }
}
?>

<main class="container d-flex justify-content-center addto">
    <form action="#" method="POST" class="border border-primary p-3 m-3 col-12 col-md-5" enctype="multipart/form-data">
        <label for="nom_tournoi">Nom du tournoi :</label>
        <input type="text" id="nom_tournoi" name="nom_tournoi" class="form-control" value="<?php echo $modifTournoi['nom_tournoi'] ?>">
        <?php if (!empty($_POST['update']) && empty($_POST['nom_tournoi'])) {
            echo " <br> <div class=\"alert alert-danger\">Votre tournoi doit obligatoirement avoir un nom</div>";
        } ?><br>

        <label for="description">Description :</label>
        <textarea id="description" name="description" class="form-control"><?php echo $modifTournoi['description'] ?></textarea>
        <?php if (!empty($_POST['update']) && empty($_POST['description'])) {
            echo "<br> <div class=\"alert alert-danger\">Vous devez avoir une description</div>";
        } ?><br>

        <label for="nombre_joueur">Nombre de joueurs :</label>
        <input type="number" id="nombre_joueur" name="nombre_joueur" class="form-control" value="<?php echo $modifTournoi['nombre_joueur'] ?>">
        <br>

        <label for="date_debut">Date de début :</label>
        <input type="datetime-local" id="date_debut" name="date_debut" class="form-control" value="<?php echo $modifTournoi['date_debut'] ?>">
        <?php if (!empty($_POST['update']) && empty($_POST['date_debut'])) {
            echo "<br> <div class=\"alert alert-danger\">Le tournoi doit bien commencer à un moment non ?</div>";
        } ?><br>

        <label for="date_fin">Date de fin :</label>
        <input type="datetime-local" id="date_fin" name="date_fin" class="form-control" value="<?php echo $modifTournoi['date_fin'] ?>"><br>

        <label for="check_in">Check-in :</label>
        <input type="datetime-local" id="check_in" name="check_in" class="form-control" value="<?php echo $modifTournoi['check_in'] ?>"><br>

        <label for="check_in_fin">Check-in fin :</label>
        <input type="datetime-local" id="check_in_fin" name="check_in_fin" class="form-control" value="<?php echo $modifTournoi['check_in_fin'] ?>"><br>

        <label for="cp">Cash Prize :</label>
        <input type="number" id="cp" name="cp" class="form-control" value="<?php echo $modifTournoi['cp'] ?>"><br>

        <label for="montant_entree">Montant de l'entrée :</label>
        <input type="number" id="montant_entree" name="montant_entree" class="form-control" value="<?php echo $modifTournoi['montant_entree'] ?>"><br>

        <label for="montant_jeux">Montant des jeux :</label>
        <input type="number" id="montant_jeux" name="montant_jeux" class="form-control" value="<?php echo $modifTournoi['montant_jeux'] ?>"><br>


        <label for="jeux">Jeux :</label>
        <input type="text" id="jeux" name="jeux" class="form-control" value="<?php echo $modifTournoi['jeux'] ?>">
        <?php if (!empty($_POST['update']) && empty($_POST['jeux'])) {
            echo "<br><div class=\"alert alert-danger\">A quoi va t-on jouer ?</div>";
        } ?><br>

       
            <label for="image">URL de l'image</label>
            <input type="text" name="image" id="image" class="form-control" value="<?php echo $modifTournoi['Image'] ?>">
            <?php if (!empty($_POST['update']) && empty($_POST['image'])) {
                echo "<br><div class=\"alert alert-danger\">Il vous faut une image</div>";
            } ?><br>
  
        
            <label for="image">URL de la banniere</label>
            <input type="text" name="banniere" id="banniere" class="form-control" value="<?php echo $modifTournoi['banniere'] ?>">
        <br>
        <input type="hidden" name="id_tournoi" value="<?php echo $id_tournoi; ?>">
        <input type="submit" value="Modifier" name="update">
    </form>
</main>


<?php
require '../inc/footer.inc.php';
?>