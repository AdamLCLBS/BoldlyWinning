<?php
require '../inc/init.inc.php';
$title = "BoldlyWinning";
$h1 = "Show off, fight the odds, all in the hope of Boldly Winning !";
require '../inc/header.inc.php';

?>
<main>
<h1 class=" text-center text-white py-5"><?php echo $h1 ?></h1>
<!-- Contenu principal -->
<main class="container">
    <div class="col-md-12 col-12 row d-flex justify-content-around  ">
    
        <?php
        $requete = $pdoTournoi->query(TournoiTableOrderEtLimite('tournoi', 'id_tournoi', 6));
    
        while ($card = $requete->fetch(PDO::FETCH_ASSOC)) {
        ?>
    
            <div class="card  col-lg-3 col-md-5 col-9 bg-gris text-white mx-2 mb-4 p-0 h-25">
                <a href="voirTournoi.php?id_tournoi=<?php echo $card['id_tournoi'] ?>"><img src="<?php echo $card['Image']; ?>" class="mh-100 mw-100 image-accueil"  alt="..."></a>
                <div class="card-body ">
                    <h5 class="card-title"><?php echo strtoupper(substr($card['nom_tournoi'], 0, 15)); ?></h5>
                    <h6 class="card-subtitle mb-2 ">Créateur :<?php echo substr($card['nom_createur'], 0, 200); ?></h6>
                    <p style="height: 60px;" class="card-text h- "><?php echo substr($card['description'], 0, 100); ?> </p>
                </div>
            </div>
    
    
        <?php } ?>
    
    </div>
</main>
</main>
<?php
require  '../inc/footer.inc.php';

?>