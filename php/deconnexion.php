<?php
require '../inc/init.inc.php';
// Démarrez la session


// Détruisez la session
session_destroy();

// Redirigez l'utilisateur vers une page appropriée
header("Location: Accueil.php"); // Remplacez "Accueil.php" par l'URL de la page vers laquelle vous souhaitez rediriger l'utilisateur après la déconnexion
exit();
?>