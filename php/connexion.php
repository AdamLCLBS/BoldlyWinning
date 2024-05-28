<?php
require '../inc/init.inc.php';
$title = "BoldlyWinning";
$h1 = "Show off, fight the odds, all in the hope of Boldly Winning !";
require '../inc/header.inc.php';
?>

<?php 
if (!empty($_POST)) {
    if (empty($_POST['pseudo']) || empty($_POST['mdp'])) {
        $contenu .= "<div class=\"alert alert-danger\">Le pseudo et le mot de passe sont requis</div>";
    }

    if (empty($contenu)) {
        $verifPseudo = $pdoTournoi->prepare("SELECT * FROM users WHERE pseudo = :pseudo");
        $verifPseudo->execute([
            ':pseudo' => $_POST['pseudo'],
        ]);
        if ($verifPseudo->rowCount() == 1) {
            $utilisateur = $verifPseudo->fetch(PDO::FETCH_ASSOC);

            if (password_verify($_POST['mdp'], $utilisateur['mdp'])) {

                $_SESSION['users'] = $utilisateur;

                header('location:accueil.php');
                exit();
            } else {
                $contenu .= "<div class=\"alert alert-danger\">Attention, mot de passe incorrect !</div>";
            }
        } else { // si on ne trouve pas le pseudo en BDD
            $contenu .= "<div class=\"alert alert-danger\">Attention, pseudo incorrect !</div>";
        }
    }
}

?>

<main class="col-md-6 row m-auto main-content ">
    <?php   
    echo $contenu;
    ?>
    <form action="#" method="POST" class="p-5 my-2 border-primary">

        <div class="mb-3">
            <label for="pseudo">Pseudo</label>
            <input type="text" name="pseudo" id="pseudo" class="col-12 bg-gris text-white rounded">
        </div>

        <div class="mb-3">
            <label for="mdp">Mot de passe</label>
            <input type="password" name="mdp" id="mdp" class="col-12 bg-gris text-white rounded">
        </div>
        <input type="submit" value="Se connecter" class="btn btn-primary">
        <a href="inscription.php" class="btn btn-secondary">Crée un compte</a>
    </form>
   
</main>



</div>
<?php 
require  '../inc/footer.inc.php';

?>