<?php
    $sql="SELECT u.id,u.nom,u.prenom,u.Email,u.password,r.libelle FROM user u ,role r where r.id =u.id_r";
    $users = mysqli_query($connexion,$sql);


?>
<!-- Ajout de Font Awesome pour les icônes -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="fw-bold text-primary"><i class="fa-solid fa-users"></i> Gestion des Utilisateurs</h2>
        <a class="btn btn-success" href="?action=addUser">
            <i class="fa-solid fa-user-plus"></i> Nouveau
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <thead class="table-dark text-center">
                <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Nom</th>
                    <th scope="col">Prénom</th>
                    <th scope="col">Email</th>
                    <th scope="col">Rôle</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody class="text-center align-middle">
                <?php while($row = mysqli_fetch_assoc($users)) { ?> 
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= $row['nom'] ?></td>
                        <td><?= $row['prenom'] ?></td>
                        <td><?= $row['Email'] ?></td>
                        <td><span class="badge bg-info text-dark"><?= $row['libelle'] ?></span></td>
                        <td>
                            <a class="btn btn-sm btn-primary me-2" href="?action=editUser&&id=<?= $row['id'] ?>">
                                <i class="fa-solid fa-edit"></i> Modifier
                            </a>
                            <a class="btn btn-sm btn-danger" href="?action=deleteUser&&id=<?= $row['id'] ?>"> 
                                <i class="fa-solid fa-trash"></i> Supprimer
                            </a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
