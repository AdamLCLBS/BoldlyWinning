<?php
require '../inc/init.inc.php';
if (isset($_POST['id_tournoi'])) {
    // Récupérer l'ID du tournoi depuis les données postées
    $id_tournoi = $_POST['id_tournoi'];

    // Maintenant vous pouvez utiliser $id_tournoi comme vous le souhaitez
    // Par exemple, vous pouvez l'utiliser pour inscrire le joueur au tournoi
} else {
    // Gérer le cas où l'ID du tournoi n'a pas été envoyé
    echo "Erreur : ID du tournoi non spécifié.";
    // Rediriger l'utilisateur vers une autre page ou afficher un message d'erreur, selon votre logique de gestion des erreurs.
}

$infobracket = $pdoTournoi->prepare("SELECT * from  bracket,tournoi WHERE tournoi.id_tournoi = bracket.id_tournoi  and tournoi.id_tournoi = :id_tournoi ");
$infobracket->execute([

    ':id_tournoi' => $id_tournoi,
]);
while ($bracket = $infobracket->fetch(PDO::FETCH_ASSOC)) {
    $id_bracket = $bracket['id_bracket'];


   $verifPseudo = $pdoTournoi->prepare("SELECT * FROM joueur WHERE id_user =:id_user and id_bracket = :id_bracket");
    $verifPseudo->execute([
        ':id_user' => $_SESSION['users']['id_user'],
        ':id_bracket'=> $id_bracket
    ]);
  
    if ($verifPseudo->rowCount() > 0) {
        header("location:voirTournoi.php?id_tournoi=" . $id_tournoi . "");
        exit();
    } 
    $joueur = $pdoTournoi->prepare("INSERT INTO  joueur (id_bracket,id_user,nom_joueur) VALUES (:id_bracket,:id_user,:nom_joueur)");
    $joueur->execute([
        ':id_user' => $_SESSION['users']['id_user'],
        ':id_bracket' => $id_bracket,
        ':nom_joueur' => $_SESSION['users']['pseudo']
    ]);
    header("location:voirTournoi.php?id_tournoi=" . $id_tournoi . "");
    exit();
}
?>