<?php


/* Création de la fonction pour verifier qu'un utilisateur est connecté */
function estConnecte(){
    if(isset($_SESSION['users'])){
        return true; // la personne est connectée
    } else {
        return false; // la personne n'est pas connectée
    }
}



function estAdmin(){
    if(isset($_SESSION['users']) && ($_SESSION['users']['statut']==2)){
        return true; 
    } else {
        return false; 
    }
}


 function TournoiTableOrderEtLimite($table, $OrderVar, $LimitVar){
    return ("SELECT * FROM $table ORDER BY $OrderVar LIMIT $LimitVar");
}

function scheduler($joueurs_bracket)
{
    // Vérifie si le nombre de joueurs est impair, ajoutant un joueur "bye" si nécessaire
    if (count($joueurs_bracket) % 2 != 0) {
        $joueurs_bracket[] = ["id_joueur" => null, "nom_joueur" => "bye"]; // Ajoute un joueur "bye"
    }
    
    // Divise le tableau de joueurs en deux moitiés
    $p2 = array_splice($joueurs_bracket, (count($joueurs_bracket) / 2)); // Sépare la deuxième moitié des joueurs
    $p1 = $joueurs_bracket; // La première moitié reste dans $joueurs_bracket
    
    // Initialise le tableau de tours de jeu
    $round = []; // Initialise un tableau vide pour stocker les rounds
    
    // Crée les tours de jeu en faisant correspondre les joueurs de chaque moitié
    for ($i = 0; $i < count($p1) + count($p2) - 1; $i++) { // Boucle sur le nombre total de tours nécessaires
        // Initialise le tableau pour chaque tour
        $round[$i] = []; // Initialise un tableau vide pour chaque tour
        
        // Associe les joueurs de chaque moitié à chaque tour
        for ($j = 0; $j < count($p1); $j++) { // Boucle sur le nombre de joueurs dans la première moitié
            $round[$i][$j]["p1"] = $p1[$j]; // Associe un joueur de la première moitié au tour actuel
            $round[$i][$j]["p2"] = $p2[$j]; // Associe un joueur de la deuxième moitié au tour actuel
        }
        
        // Si le nombre de joueurs est supérieur à 2, réorganise les joueurs pour les tours suivants
        if (count($p1) + count($p2) - 1 > 2) { // Vérifie s'il reste plus de deux joueurs pour les tours suivants
            $temp = array_splice($p1, 1, 1); // Supprime et récupère le deuxième joueur de la première moitié
            array_unshift($p2, array_shift($temp)); // Déplace le joueur récupéré de la première moitié vers la deuxième moitié
            array_push($p1, array_pop($p2)); // Déplace le dernier joueur de la deuxième moitié vers la première moitié
        }
    }
    
    // Retourne les tours de jeu
    return $round; // Renvoie le tableau contenant les tours de jeu organisés
}
?>

