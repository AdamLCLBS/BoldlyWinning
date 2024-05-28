<?php

require '../inc/init.inc.php';

if ((isset($_GET['id_user']) && $_SESSION['users']['id_user'] == $_GET['id_user']) || estAdmin()) {
    $requete = $pdoTournoi->prepare(" SELECT * FROM users WHERE id_user = :id_user ");

    $requete->execute(array(
        ':id_user' => $_GET['id_user']
    ));
    if ($requete->rowCount() == 0) {
        header('location:accueil.php');
        exit();
    }
    $ModifPro = $requete->fetch(PDO::FETCH_ASSOC);



    $title = 'Boldly Winning';
    require '../inc/header.inc.php';

    if (!empty($_POST)) {
        /*    $_POST['prenom'] = htmlspecialchars($_POST['prenom']);
    $_POST['nom'] = htmlspecialchars($_POST['nom']);
    $_POST['pseudo'] = htmlspecialchars($_POST['pseudo']);
    $_POST['mail'] = htmlspecialchars($_POST['mail']); */
        foreach ($_POST as $cle => $valeur) {
            if (!empty($valeur)) {
                $_POST[$cle] = htmlspecialchars($valeur);
            }
        }

        if (!isset($_POST['mail']) || !filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)) {
            $contenu .= "<div class=\"alert alert-danger\">Votre email n'est pas conforme !</div>";
        }

        if (empty($contenu)) {

            if ($_POST['pseudo'] != $ModifPro['pseudo'] || $_POST['mail'] != $ModifPro['mail']) {
                // Vérification du pseudo uniquement si le pseudo est modifié
                if ($_POST['pseudo'] != $_SESSION['users']['pseudo']) {
                    $verifPseudo = $pdoTournoi->prepare("SELECT * FROM users WHERE pseudo = :pseudo");
                    $verifPseudo->execute([
                        ':pseudo' => $_POST['pseudo']
                    ]);

                    if ($verifPseudo->rowCount() > 0) {
                        $contenu .= "<div class=\"alert alert-danger\">Ce pseudo est indisponible, veuillez en choisir un autre. </div>";
                    }
                }

                // Vérification de l'email uniquement si l'email est modifié

                if ($_POST['mail'] != $ModifPro['mail']) {

                    $verifEmail = $pdoTournoi->prepare("SELECT * FROM users WHERE mail = :mail");
                    $verifEmail->execute([
                        ':mail' => $_POST['mail']
                    ]);

                    if ($verifEmail->rowCount() > 0) {
                        $contenu .= "<div class=\"alert alert-danger\">Cette adresse email est déjà utilisée par un autre utilisateur. Veuillez en choisir une autre. </div>";
                    }
                }
                if ($_POST['mdp'] != $ModifPro['mdp']) {
                    if ($_POST['mdp'] === '') {
                        // Si le champ du mot de passe est vide, afficher un message d'erreur
                        $contenu .= "<div class=\"alert alert-danger\">Veuillez saisir un mot de passe.</div>";
                    } else {
                        $verifmdp = $pdoTournoi->prepare("SELECT * FROM users WHERE mdp = :mdp");
                        $verifmdp->execute([
                            ':mdp' => $_POST['mdp']
                        ]);

                        if ($verifmdp->rowCount() > 0) {
                            $contenu .= "<div class=\"alert alert-danger\">Ce mdp n'est pas disponible. Veuillez en choisir un autre. </div>";
                        }
                    }
                }
            }


            if (empty($contenu)) {

                $mdp = password_hash($_POST['mdp'], PASSWORD_DEFAULT);
                $modif = $pdoTournoi->prepare('UPDATE users SET prenom = :prenom, nom = :nom, civilite = :civilite, mail = :mail,mdp = :mdp, pseudo = :pseudo WHERE id_user = :id_user ');

                $modif->execute(array(
                    ':prenom' => $_POST['prenom'],
                    ':nom' => $_POST['nom'],
                    ':civilite' => $_POST['civilite'],
                    ':mail' => $_POST['mail'],
                    ':pseudo' => $_POST['pseudo'],
                    ':id_user' => $_GET['id_user'],
                    ':mdp' => $mdp,
                ));

                if ($modif) {
                    header("location:profil.php?id_user=" . $_GET['id_user'] . "");
                    exit();
                } else {
                    $contenu .= "<div class=\"alert alert-danger\">Erreur lors de la modification</div>";
                }
            }
        }
    }
}
/* } else {
    header('location:accueil.php');
    exit();
} */
?>



<main class="container-fluid pt-5">

    <?php echo $contenu; ?>

    <form action="#" method="POST" class="col-12 col-md-4 mx-auto border border-primary p-5">

        <div class="mb-3">
            <label for="prenom" class="form-label">Prénom</label>
            <input type="text" id="prenom" name="prenom" class="form-control" value="<?php echo $ModifPro['prenom'] ?>">
        </div>

        <div class="mb-3">
            <label for="nom" class="form-label">Nom</label>
            <input type="text" id="nom" name="nom" class="form-control" value="<?php echo $ModifPro['nom'] ?>">
        </div>

        <div class="mb-3">
            <label for="pseudo" class="form-label">Pseudo</label>
            <input type="text" id="pseudo" name="pseudo" class="form-control" value="<?php echo $ModifPro['pseudo'] ?>">
        </div>
        <div class="mb-3">
            <?php $mdp1 = password_hash($ModifPro['mdp'], PASSWORD_DEFAULT); ?>
            <label for="mdp" class="form-label">mdp</label>
            <input type="text" id="mdp" name="mdp" class="form-control" value="<?php echo $mdp1 ?>">
            <input type="checkbox" onclick="myFunction()"> afficher le mot de passe
        </div>

        <div class="mb-3">
            <label for="mail" class="form-label">Email</label>
            <input type="text" id="mail" name="mail" class="form-control" value="<?php echo $ModifPro['mail'] ?>">
        </div>

        <div class="mb-3">
            <label for="civilite" class="form-label">Genre</label>
            <select name="civilite" id="civilite" class="form-select">
                <?php if ($ModifPro["civilite"] === "m") : ?>
                    <option value="m" selected>Homme</option>
                    <option value="f">Femme</option>
                    <option value="a">Autre</option>
                <?php elseif ($ModifPro["civilite"] === "f") : ?>
                    <option value="m">Homme</option>
                    <option value="f" selected>Femme</option>
                    <option value="a">Autre</option>
                <?php else : ?>
                    <option value="m">Homme</option>
                    <option value="f">Femme</option>
                    <option value="a" selected>Autre</option>
                <?php endif; ?>
            </select>
        </div>

        <div class="text-center">
            <input type="submit" value="Modifier" class="btn btn-primary mt-3">
        </div>

    </form>

</main>

<?php
require '../inc/footer.inc.php';
?>