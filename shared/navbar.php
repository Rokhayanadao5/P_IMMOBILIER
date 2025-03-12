<?php
include("database.php");


?>


    <style>
        
        .navbar-nav .nav-link:hover {
            color: rgb(0, 47, 157);
            transform: scale(1.1);
        }
        .navbar-dark .navbar-nav .nav-link {
            color: white;
        }
        .navbar-dark .navbar-nav .nav-link:hover {
            color: rgb(0, 47, 157);
        }
       
        .navbar-toggler-icon {
            background-color: white;
        }
    </style>


<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark justify-content-between">
    <a class="navbar-brand" href="#">Mon Agence Immobilière</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav mx-auto">
            <?php
            if (isset($_SESSION['id_r'])) {
                if ($_SESSION['id_r'] == 'Gestionnaire') {
                    echo '<li class="nav-item">
                              <a class="nav-link active" aria-current="page" href="?action=listUser">
                                <i class="fas fa-users"></i> Liste des Utilisateurs
                              </a>
                          </li>
                          <li class="nav-item">
                              <a class="nav-link active" aria-current="page" href="?action=listRole">
                                <i class="fas fa-user-shield"></i> Liste des Rôles
                              </a>
                          </li>
                          <li class="nav-item">
                              <a class="nav-link" aria-current="page" href="?action=listLog">
                                <i class="fas fa-building"></i> Logements
                              </a>
                          </li>
                          <li class="nav-item">
                              <a class="nav-link" href="#">
                                <i class="fas fa-handshake"></i> Contrats
                              </a>
                          </li>
                          <li class="nav-item">
                              <a class="nav-link" aria-current="page" href="?action=listPro">
                                <i class="fas fa-users"></i> Propriétaires
                              </a>
                          </li>';
                }

                if ($_SESSION['id_r'] == 'Proprietaire') {
                    echo '<li class="nav-item">
                              <a class="nav-link" href="#">
                                <i class="fas fa-building aria-current="page" href="?action=listLog"></i> Logements
                              </a>
                          </li>
                          <li class="nav-item">
                              <a class="nav-link" href="#">
                                <i class="fas fa-handshake"></i> Contrats
                              </a>
                          </li>';
                }

                if ($_SESSION['id_r'] == 'Client') {
                    echo '<li class="nav-item">
                              <a class="nav-link" href="#">
                                <i class="fas fa-building"></i> Logements
                              </a>
                          </li>';
                }
            }
            ?>
        </ul>

        <div class="navbar-text ms-auto d-flex align-items-center justify-content=speace-betwen">
            <?php if (isset($_SESSION['nom']) && isset($_SESSION['prenom'])): ?>
                <ul class="navbar-nav">
                <li class="nav-item d-flex align-items-center ">
                    <?php if (isset($_SESSION['user_image'])): ?>
                        <img src="<?= $_SESSION['user_image']; ?>" alt="Profil" class="rounded-circle" width="40" height="40">
                    <?php endif; ?>                <span class="me-3">
                        
                    <?= $_SESSION['prenom'] . " " . $_SESSION['nom']; ?>
                </span>
                <a href="?action=deconnexion" class="btn btn-sm btn-danger">
                    <i class="fa-solid fa-sign-out-alt"></i> Déconnexion
                </a>
            <?php else: ?>
                <a href="login.php" class="btn btn-sm btn-primary">
                    <i class="fa-solid fa-sign-in-alt"></i> Connexion
                </a>
            <?php endif; ?>
        </div>
    </div>
</nav>


