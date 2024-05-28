<?php 
require '../inc/init.inc.php';
if (isset($_POST['id_tournoi'])){
    $id_tournoi = $_POST['id_tournoi'];
    

    $trouverbracket = $pdoTournoi->prepare("select id_bracket from bracket where id_tournoi = :id_tournoi");
    $trouverbracket->execute([
        'id_tournoi' => $id_tournoi,
    ]);
    $temp = $trouverbracket->fetch(PDO::FETCH_ASSOC);
   
    $id_bracket = $temp['id_bracket'];
    $deletematch = $pdoTournoi->prepare("DELETE  from match_bracket where id_bracket = :id_bracket");
    $deletematch->execute([
        'id_bracket' => $id_bracket,
    ]);
    
    $resetjoueur = $pdoTournoi->prepare("UPDATE joueur SET nombre_point = 0, win = 0, loses = 0 WHERE id_bracket = :id_bracket");
    $resetjoueur->execute([
        'id_bracket' => $id_bracket,
    ]);
    
    $reset = $pdoTournoi->prepare("UPDATE tournoi SET tournoi_statut = 0 WHERE id_tournoi = :id_tournoi");
    $reset->execute([
        'id_tournoi' => $id_tournoi,
    ]);

   header("location:voirTournoi.php?id_tournoi=" . $id_tournoi . "");
}else{
    header("location:accueil.php");
} 

?>