
<?php
/* 1 - connexion à la BDD */

$pdoTournoi = new PDO(
    'mysql:host=localhost;dbname=boldlywinning',
    'root', // utilisateur
    '', // mot de passe
    array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING, // La première ligne demande l'affichage des erreurs sql sous forme de warning
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8', // précise le jeu de caratère lorsque ces erreurs apparaissent
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO:: FETCH_ASSOC,
    )
);

session_start();

/* 2 - initialisation de la variable contenu qui va nous servir pour afficher des erreurs sur plusieurs pages */
$contenu = "";





require 'fonctions.inc.php'
 ?>