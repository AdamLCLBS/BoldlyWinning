<?php
require '../inc/init.inc.php';

$title = "BoldlyWinning";
$h1 = "Show off, fight the odds, all in the hope of Boldly Winning !";
require '../inc/header.inc.php';
?>


<?php

if (!empty($_POST)) {

    foreach ($_POST as $cle => $valeur) {
        if (!empty($valeur)) {
            $_POST[$cle] = htmlspecialchars($valeur);
        }
    }

    
    if (!isset($_POST['civilite']) || $_POST['civilite'] != 'm' && $_POST['civilite'] != 'f' && $_POST['civilite'] != 'a') {
        $contenu .= "<div class=\"alert alert-danger\">Cette civilité n'est pas valable</div>";
    }

    if (!isset($_POST['prenom']) || strlen($_POST['prenom']) < 2 || strlen($_POST['prenom']) > 20) {
        $contenu .= "<div class=\"alert alert-danger\">Votre prénom doit avoir entre 2 et 20 caractères</div>";
    }

    if (!isset($_POST['nom']) || strlen($_POST['nom']) < 2 || strlen($_POST['nom']) > 20) {
        $contenu .= "<div class=\"alert alert-danger\">Votre nom doit avoir entre 2 et 20 caractères</div>";
    }

    if (!isset($_POST['mail']) || !filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)) {
        $contenu .= "<div class=\"alert alert-danger\">Votre mail n'est pas conforme</div>";
    }


    if (empty($contenu)) {
        /* si la variable contenu est vide ça signifie qu'il n'ya pas d'erreur et on peut lancer la requête */
        $verifPseudo = $pdoTournoi->prepare("SELECT * FROM users WHERE pseudo =:pseudo ");
        $verifPseudo->execute([
            ':pseudo' => $_POST['pseudo'],
        ]);
        /* 
        Etant donné que la connexion se fera à partir du pseudo,
        nous vérifirons que le pseudo est entré par l'utilisateur voulant s'inscrire n'éxiste pas déjà dans la BDD.
        S'il existe déjà alors on lui mettra un message d'erreur, lui demandant de changer son pseudo. 
        */

        if ($verifPseudo->rowCount() > 0) {
            $contenu .= "<div class=\"alert alert-danger\">Ce pseudo est indisponible veuillez en choisir un autre.</div>";
        }

        $verifEmail = $pdoTournoi->prepare("SELECT * FROM users WHERE mail = :mail");
        $verifEmail->execute([':mail' => $_POST['mail']]);
        if ($verifEmail->rowCount() > 0) {
            $contenu .= "<div class=\"alert alert-danger\">Cet email est déjà utilisé. Veuillez en choisir un autre.</div>";
        }


        if (empty($contenu)) { {
                $mdp = password_hash($_POST['mdp'], PASSWORD_DEFAULT);

                $insert = $pdoTournoi->prepare('INSERT INTO users (civilite, prenom, nom, mail, pseudo, mdp, statut) VALUES (:civilite, :prenom, :nom, :mail, :pseudo, :mdp, 0)');

                $insert->execute(array(
                    ':civilite' => $_POST['civilite'],
                    ':prenom' => $_POST['prenom'],
                    ':nom' => $_POST['nom'],
                    ':mail' => $_POST['mail'],
                    ':pseudo' => $_POST['pseudo'],
                    ':mdp' => $mdp
                ));
            }
            if ($insert) {
                header('location:connexion.php');
                exit();
            }
        }
    }
}
?>
<main class=" container ">
    <!-- civilité, nom, prénom, mail, pseudo, mdp -->
    <?php echo $contenu; ?>
<div class="col-md-9  col-lg-9   col-12   mx-auto pt-5">
    
        <form action="#" method="POST" class=" bg-transparent text-white">
            <h2 class="text-center text-white mb-4">Inscription</h2>
            <div>
                <label for="civilite">Civilité</label>
                <input type="radio" name="civilite" id="civilite" value="m" class="form-check-input mx-1">Homme
                <input type="radio" name="civilite" id="civilite" value="f" class="form-check-input mx-1">Femme
                <input type="radio" name="civilite" id="civilite" value="a" class="form-check-input mx-1">Autre
            </div>
    
            <div>
                <label for="nom">Nom</label>
                <input type="text" name="nom" id="nom" class="col-12 bg-gris text-white rounded" required>
            </div>
    
            <div>
                <label for="prenom">Prénom</label>
                <input type="text" name="prenom" id="prenom" class="col-12 bg-gris text-white rounded" required>
            </div>
    
            <div>
                <label for="mail">Mail</label>
                <input type="mail" name="mail" id="mail" class="col-12 bg-gris text-white rounded" required>
            </div>
    
            <div>
                <label for="pseudo">Pseudo</label>
                <input type="text" name="pseudo" id="pseudo" class="col-12 bg-gris text-white rounded" required>
            </div>
    
            <div>
                <label for="mdp">Mot de passe</label>
                <input type="password" name="mdp" id="mdp" class="col-12 bg-gris text-white rounded" required>
            </div>
    
            <input type="submit" value="S'inscrire" class="btn btn-primary mt-2 ">
        </form>
</div>
</main>
<?php
require  '../inc/footer.inc.php';

?>