<?php 
require '../inc/init.inc.php';
if (isset($_POST['id_tournoi'])){
    $id_tournoi = $_POST['id_tournoi'];
    $finirTournoi = $pdoTournoi->prepare("UPDATE tournoi SET tournoi_statut = 2 WHERE id_tournoi = :id_tournoi");
    $finirTournoi->execute([
        'id_tournoi' => $id_tournoi,
    ]);
    header("location:voirTournoi.php?id_tournoi=" . $id_tournoi . "");
}else{
    header("location:accueil.php");
}

?>