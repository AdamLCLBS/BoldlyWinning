<?php
require '../inc/init.inc.php';
$title = 'BoldlyWinning';
require '../inc/header.inc.php';


if (!empty($_POST)) {


    foreach ($_POST as $cle => $valeur) {
        if (!empty($valeur)) {
            $_POST[$cle] = htmlspecialchars($valeur);
        }
    }


    if (!isset($_POST['nom']) || strlen($_POST['nom']) < 2 || strlen($_POST['nom']) > 20) {
        $contenu .= "<div class=\"alert alert-danger\">Votre nom doit avoir entre 2 et 20 caractères</div>";
    }

    if (!isset($_POST['mail']) || !filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)) {
        $contenu .= "<div class=\"alert alert-danger\">Votre mail n'est pas conforme</div>";
    }
    if (empty($contenu)) {
        $insertcontact = $pdoTournoi->prepare('INSERT INTO contact ( nom, mail,sujet, message) VALUES (:nom, :mail,:sujet, :message)');

        $insertcontact->execute([
            ':nom' => $_POST['nom'],
            ':mail' => $_POST['mail'],
            ':sujet' => $_POST['sujet'],
            ':message' => $_POST['message'],
        ]);

        if ($insertcontact) {
            $contenu .= "<div class=\"alert alert-success\">Votre message à été envoyer, merci de votre retour !</div>";
        }
    }
}





?>

<main class=" container  ">
    <?php echo $contenu; ?>
<div class="col-md-9 col-12  mx-auto pt-5">
    
        <form action="#" method="POST" class="bg-transparent text-white">
            <h2 class="text-center text-white mb-4">Faites-nous part de votre ressenti !</h2>
            <div>
                <label for="nom">Nom</label>
                <input type="text" name="nom" id="nom"  class="col-12 bg-gris text-white rounded" required>
            </div>
    
    
            <div>
                <label for="mail">Mail</label>
                <input type="mail" name="mail" id="mail"  class="col-12 bg-gris text-white rounded" required>
            </div>
    
            <div>
                <label for="sujet">Sujet</label>
                <input type="text" name="sujet" id="sujet" class="col-12 bg-gris text-white rounded" required>
            </div>
    
            <div >
                <label for="message">Message</label>
                <textarea  class="col-12 bg-gris text-white rounded" type="text" name="message" col="30" rows="10" id="message"  required></textarea>
            </div>
    
    
            <input type="submit" value="Envoyer" class="btn btn-primary mt-2 ">
        </form>
</div>
</main>





<?php
require '../inc/footer.inc.php';
?>