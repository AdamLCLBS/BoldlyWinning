<?php

require '../inc/init.inc.php';

$title = "BoldlyWinning";
$h1 = "Show off, fight the odds, all in the hope of Boldly Winning !";
require '../inc/header.inc.php';
if (isset($_GET['action']) && $_GET['action'] == 'deconnexion') {
    session_start();
    session_destroy();
    header('location:accueil.php');
    exit();
}
if (!isset($_GET['id_user'])) {
    header('location:accueil.php');
    exit();
}
$requete = $pdoTournoi->prepare("SELECT * FROM users WHERE id_user =:id_user ");
$requete->execute([
    ':id_user' => $_GET['id_user'],
]);
$Profile = $requete->fetch();



if (!estConnecte()) {
    header('location:accueil.php');
    exit();
}
?>
<main class="container py-5">


    <div class="card  col-lg-5 col-md-5 col-9 bg-transparent m-auto p-0 h-25">
        <div class="card-body text-white">
            <h2><?php echo "$Profile[prenom] $Profile[nom]" ?></h2>
            <p>Mail : <?php echo "$Profile[mail]" ?></p>
            <p>Pseudo : <?php echo "$Profile[pseudo]" ?></p>
            <p>Genre :
                <?php
                if ($Profile['civilite'] == 'f') {
                    echo "Femme";
                } elseif ($Profile['civilite'] == 'm') {
                    echo "Homme";
                } else {
                    echo "Autre";
                }
                ?>
            </p>
            <?php if ($Profile['ville'] != '') { ?>
                <p>Ville :<?php echo "$Profile[ville]" ?></p>
            <?php } ?>
        </div>
        <div class="d-flex justify-content-between  mx-2">
            <a href="modifprofil.php?id_user=<?php echo $Profile['id_user'] ?>" class="btn btn-primary">Modifier mon profil</a>
            <a href="profil.php?action=deconnexion" class="btn btn-danger ">Se déconnecter</a>
        </div>
    </div>


</main>

<?php
require '../inc/footer.inc.php';
?>