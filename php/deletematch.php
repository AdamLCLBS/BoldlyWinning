<?php 
require '../inc/init.inc.php';
if (isset($_POST['id_bracket']) && isset($_POST['id_tournoi'])) {
$id_tournoi = $_POST['id_tournoi'];
$id_bracket = $_POST['id_bracket'];
var_dump($id_bracket);
$deletematch = $pdoTournoi->prepare("DELETE from   match_bracket where id_bracket = :id_bracket");
$deletematch->execute([
    'id_bracket' => $id_bracket,
]);
var_dump($id_bracket);
if($deletematch){
$resetjoueur = $pdoTournoi->prepare("UPDATE joueur SET nombre_point = 0, win = 0, loses = 0 WHERE id_bracket = :id_bracket");
$resetjoueur->execute([
    'id_bracket' => $id_bracket,
]);
header("location:voirTournoi.php?id_tournoi=" . $id_tournoi . "");


}

}
?>