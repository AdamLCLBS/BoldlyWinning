<?php
require '../inc/init.inc.php';

$title = "BoldlyWinning";
$h1 = "Show off, fight the odds, all in the hope of Boldly Winning !";
require '../inc/header.inc.php';

if (!estAdmin()) {
    header("location:accueil.php");
    exit();
}
if (isset($_GET['action']) && $_GET['action'] == 'suppression' && isset($_GET['id_user'])) { // jé vérifie que toutes les infos ci-dessus (action, action qui correspond à suppression et id_user) sont bien présentes dans l'url
    $deleteU = $pdoTournoi->prepare("DELETE FROM users WHERE id_user = :id_user");

    $deleteU->execute(array(
        ':id_user' => $_GET['id_user'],
    ));

    if ($deleteU->rowCount() == 0) { // Si ça nous renvoit 0 c'est que le résultat est vide : il n'y a pas user avec cet id à supprimer
        $contenu .= "<div class=\"alert alert-danger\">Erreur de suppression de user n° $_GET[id_user] </div>";
    } else { // la suppression s'exécute
        $contenu .= "<div class=\"alert alert-success\">user n° $_GET[id_user] a bien été supprimé</div>";
    }
}

if (isset($_GET['action']) && $_GET['action'] == 'suppression' && isset($_GET['id_tournoi'])) { // jé vérifie que toutes les infos ci-dessus (action, action qui correspond à suppression et id_tournoi) sont bien présentes dans l'url
    $deleteTO = $pdoTournoi->prepare("DELETE FROM tournoi WHERE id_tournoi = :id_tournoi");

    $deleteTO->execute(array(
        ':id_tournoi' => $_GET['id_tournoi'],
    ));

    if ($deleteTO->rowCount() == 0) { // Si ça nous renvoit 0 c'est que le résultat est vide : il n'y a pas tournoi avec cet id à supprimer
        $contenu .= "<div class=\"alert alert-danger\">Erreur de suppression de tournoi n° $_GET[id_tournoi] </div>";
    } else { // la suppression s'exécute
        $contenu .= "<div class=\"alert alert-success\">tournoi n° $_GET[id_tournoi] a bien été supprimé</div>";
    }
}
if (isset($_GET['action']) && $_GET['action'] == 'suppression' && isset($_GET['id_contact'])) { // jé vérifie que toutes les infos ci-dessus (action, action qui correspond à suppression et id_tournoi) sont bien présentes dans l'url
    $deleteContact = $pdoTournoi->prepare("DELETE FROM contact WHERE id_contact = :id_contact");

    $deleteContact->execute(array(
        ':id_contact' => $_GET['id_contact'],
    ));

    if ($deleteContact->rowCount() == 0) { // Si ça nous renvoit 0 c'est que le résultat est vide : il n'y a pas tournoi avec cet id à supprimer
        $contenu .= "<div class=\"alert alert-danger\">Erreur de suppression de la suggestions n° $_GET[id_contact] </div>";
    } else { // la suppression s'exécute
        $contenu .= "<div class=\"alert alert-success\">La suggestions n° $_GET[id_contact] a bien été supprimé</div>";
    }
}



$user = $pdoTournoi->query("SELECT * from users WHERE statut ='0'");
$tournoi = $pdoTournoi->query("SELECT * from tournoi ");
$contact = $pdoTournoi->query("SELECT * from contact");

?>


<main class="row col-12  ">

    <h2 class="text-center">Tableau des utilisateurs</h2>
    <div class="d-flex justify-content-around col-11 mx-auto">
        <div class="table-responsive ">
            <table class="table table-dark">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Pseudo</th>
                        <th>Prenom</th>
                        <th>Nom</th>
                        <th>Adresse mail</th>
                        <th>Civilité</th>
                        <th>Action</th>
                    </tr>
                </thead><!-- fin en-tête tableau -->
                <tbody>
                    <?php
                    while ($users = $user->fetch(PDO::FETCH_ASSOC)) {
                        //ouverture de la boucle while (ce n'est pas parce que je ne suis plus dans un passage PHP que ma boucle ne continue pas : tant qu'il n'y a pas d'accolade fermante, la boucle continue)
                    ?>
                        <tr>
                            <td><?php echo $users['id_user']; ?></td>
                            <td><?php echo $users['pseudo']; ?></td>
                            <td><?php echo $users['prenom']; ?></td>
                            <td><?php echo $users['nom'] ?> </td>
                            <td><?php echo "$users[mail] $users[ville]"; ?></td>
                            <td><?php
                                if ($users['civilite'] == 'f') {
                                    echo "Femme";
                                } elseif ($users['civilite'] == 'm') {
                                    echo "Homme";
                                } else {
                                    echo "Autre";
                                }
                                ?>
                            <td>
                                <div class="btn-group">
                                    <a href="profil.php?id_user=<?php echo $users['id_user']; ?>" class="btn btn-primary">Voir</a>

                                    <?php if (estAdmin()) { ?>
                                        <a href="admin.php?action=suppression&id_user=<?php echo $users['id_user'] ?>" onclick="return(confirm('Êtes vous sûr de vouloir supprimer cet user ?'))" class="btn btn-danger">Supprimer</a>
                                    <?php } ?>

                                </div>
                            </td>
                        </tr>
                    <?php } // fermeture de la boucle 
                    ?>
                </tbody><!-- Fermeture du body du tableau -->
            </table><!-- Fermeture du tableau -->
        </div>
    </div>



    <h2 class="text-center">Tableau des suggestions</h2>
    <div class="d-flex justify-content-around col-11 mx-auto">
        <div class="table-responsive ">
            <table class="table  table-dark">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Nom</th>
                        <th>mail</th>
                        <th>sujet</th>
                        <th>Action</th>
                    </tr>
                </thead><!-- fin en-tête tableau -->
                <tbody>
                    <?php
                    while ($contacts = $contact->fetch(PDO::FETCH_ASSOC)) {
                        //ouverture de la boucle while (ce n'est pas parce que je ne suis plus dans un passage PHP que ma boucle ne continue pas : tant qu'il n'y a pas d'accolade fermante, la boucle continue)
                    ?>
                        <tr>
                            <td><?php echo $contacts['id_contact']; ?></td>
                            <td><?php echo $contacts['nom']; ?></td>
                            <td><?php echo $contacts['mail']; ?></td>
                            <td><?php echo $contacts['sujet'] ?> </td>
                            <td>
                                <div class="btn-group">
                                    <a href="contact.php?id_contact=<?php echo $contacts['id_contact']; ?>" class="btn btn-primary">Voir</a>

                                    <?php if (estAdmin()) { ?>
                                        <a href="admin.php?action=suppression&id_contact=<?php echo $contacts['id_contact'] ?>" onclick="return(confirm('Êtes vous sûr de vouloir supprimer cet suggestions ?'))" class="btn btn-danger">Supprimer</a>
                                    <?php } ?>

                                </div>
                            </td>
                        </tr>
                    <?php } // fermeture de la boucle 
                    ?>
                </tbody><!-- Fermeture du body du tableau -->
            </table><!-- Fermeture du tableau -->
        </div>
    </div>


    <h2 class="text-center">Tableau des tournois</h2>
    <div class="d-flex justify-content-around col-11 mx-auto">
        <div class="table-responsive">
            <table class="table table-dark">
                <thead >
                    <tr>
                        <th>Id</th>
                        <th>image</th>
                        <th>Nom</th>
                        <th>mail</th>
                        <th>sujet</th>
                        <th>Date début</th>
                        <th>Action</th>
                    </tr>
                </thead><!-- fin en-tête tableau -->
                <tbody>
                    <?php
                 while ($tournois = $tournoi->fetch(PDO::FETCH_ASSOC)) { 
                        //ouverture de la boucle while (ce n'est pas parce que je ne suis plus dans un passage PHP que ma boucle ne continue pas : tant qu'il n'y a pas d'accolade fermante, la boucle continue)
                    ?>
                        <tr>
                            <td><?php echo $tournois['id_tournoi']; ?></td>
                            <td><img id="tableauimage" src="<?php echo $tournois['Image']; ?>" alt="image du tournoi"></td>
                            <td><?php echo  $tournois['nom_tournoi'] ?></td>
                            <td><?php echo substr($tournois['description'], 0, 30); ?></td>
                            <td><?php echo $tournois['jeux'] ?> </td>
                            <td>
                            <?php
                            $date = new DateTime($tournois['date_debut'], new DateTimeZone('Europe/Paris'));

                            $dateFormatee = IntlDateFormatter::formatObject(
                                $date,
                                'dd MMMM Y',
                                'fr'
                            );

                            echo "$dateFormatee";
                            ?></p>
                            </td>
                            <td>
                                <div class="btn-group">
                                <a href="voirTournoi.php?id_tournoi=<?php echo $tournois['id_tournoi']; ?>" class="btn btn-primary ">Voir</a>

                                    <?php if (estAdmin()) { ?>
                                        <a href="admin.php?action=suppression&id_tournoi=<?php echo $tournois['id_tournoi'] ?>" onclick="return(confirm('Êtes vous sûr de vouloir supprimer cet user ?'))" class="btn btn-danger">Supprimer</a>
                                    <?php } ?>

                                </div>
                            </td>
                        </tr>
                    <?php } // fermeture de la boucle 
                    ?>
                </tbody><!-- Fermeture du body du tableau -->
            </table><!-- Fermeture du tableau -->
        </div>
    </div>

            <!-- Fermeture de ma boucle while -->
        </div><!-- fermeture de la rangée -->
    </div><!-- fermeture du container -->



</main>

<?php
require  '../inc/footer.inc.php';

?>