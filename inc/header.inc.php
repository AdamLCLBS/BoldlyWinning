<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="icon" type="image/png" href="../assets/img/logosite.png">
   <!--  <link href="../assets/css/sidebar.css" rel="stylesheet"> -->
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg  bg-gris  ">
            <div class="container-fluid m-0 ">
                <div>
                    <a class="navbar-brand" href="accueil.php"><img src="../assets/img/logosite.png" width="150" height="150" alt="LogoDuSite"></a>
                </div>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse flex-grow-0 mx-5" id="navbarNav">
                    <ul class="navbar-nav">
                        <?php if (!estConnecte()) {  ?>
                            <li class="nav-item">
                                <a class="nav-link active text-white" aria-current="page" href="Inscription.php">Inscription</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white" href="Connexion.php">Connexion</a>
                            </li>
                        <?php } ?>
                        <?php if (estConnecte()) { ?>
                            <li class="nav-item">
                                <a class="nav-link text-white" href="ajouterTournoi.php">Crée un event</a>
                            </li>
                        <?php }; ?>
                        <?php if (estConnecte()) { ?>
                            <li class="nav-item">
                                <a class="nav-link text-white" href="profil.php?id_user=<?php echo $_SESSION['users']['id_user']; ?>">Profile</a>
                            </li>
                        <?php } ?>
                        <?php if (estAdmin()) { ?>
                            <li class="nav-item">
                                <a class="nav-link text-white" href="admin.php">Admin</a>
                            </li>
                        <?php }; ?>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="galerieTournoi.php">Voir tout les events</a>
                        </li>
                        <?php
                        if (estConnecte()) { ?>
                            <li class="nav-item">
                            <a class="nav-link text-white" href="deconnexion.php">Deconnexion</a>
                        </li>
                      <?php  } ?>

                    </ul>
                </div>
            </div>
        </nav>
    </header>