<?php 
require '../inc/init.inc.php';
$title = "BoldlyWinning";
require '../inc/header.inc.php';




if (!estAdmin()) {
    header('location:accueil.php');
    exit();
}

if (!isset($_GET['id_contact'])) {
    header('location:admin.php');
    exit();
}
$requete = $pdoTournoi->prepare("SELECT * FROM contact WHERE id_contact =:id_contact ");
$requete->execute([
    ':id_contact' => $_GET['id_contact'],
]);
$Message = $requete->fetch();



?>

<main class="container">

    <div class=" col-lg-3 col-md-5 col-9 m-auto py-5">
    <div class="card   bg-gris text-white">
        <div class="card-body">
            <h2>Nom :<?php echo " $Message[nom]" ?></h2>
            <p>Mail : <?php echo "$Message[mail]" ?></p>
            <p>Sujet : <?php echo "$Message[sujet]" ?></p>
            <p>Message : <?php echo "$Message[message]" ?></p>
    </div>
</div>

</main>

<?php
require '../inc/footer.inc.php';
?>