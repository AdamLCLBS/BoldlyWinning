<?php 
require '../inc/init.inc.php';
require '../inc/header.inc.php';
if (isset($_POST['id_tournoi']) && ($_POST['id_bracket'])) {
    // Récupérer l'ID du tournoi depuis les données postées
    $id_tournoi = $_POST['id_tournoi'];
    $id_bracket = $_POST['id_bracket'];
    var_dump($id_bracket);
    var_dump($id_tournoi);
    $requete_id_joueurs = $pdoTournoi->prepare("SELECT * FROM joueur WHERE id_bracket = :id_bracket");
    $requete_id_joueurs->execute([':id_bracket' => $id_bracket]);
    $joueurs_bracket = $requete_id_joueurs->fetchAll(PDO::FETCH_ASSOC);
    $schedule = scheduler($joueurs_bracket);

    $requete_insert_match = $pdoTournoi->prepare("INSERT INTO match_bracket (id_bracket, id_joueur1, id_joueur2,p1,p2) VALUES (:id_bracket, :id_joueur1, :id_joueur2, :p1,:p2)");
        foreach ($schedule as $round => $games) {
            foreach ($games as $play) {
                if ($play['p1']['id_joueur'] !== null && $play['p2']['id_joueur'] !== null) {
                   $requete_insert_match->execute([
                    ':id_bracket' => $id_bracket,
                    ':id_joueur1' => $play['p1']['id_joueur'],
                    ':id_joueur2' => $play['p2']['id_joueur'],
                    ':p1' => $play['p1']['nom_joueur'],
                    ':p2' => $play['p2']['nom_joueur'],
                ]); }
            }
        }

       $commencerTournoi = $pdoTournoi->prepare("UPDATE  tournoi SET tournoi_statut = 1 WHERE id_tournoi = :id_tournoi");
$commencerTournoi->execute([
    ':id_tournoi' => $id_tournoi,
]);
if($requete_insert_match){
    header("location:voirTournoi.php?id_tournoi=" . $id_tournoi . "");
    exit();
} 
}

?>