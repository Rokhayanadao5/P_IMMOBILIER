<?php
    $sql = "SELECT * FROM role";
    $roles = mysqli_query($connexion, $sql);
?>

<!-- Ajout de Font Awesome pour les icônes -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="fw-bold text-primary"><i class="fa-solid fa-briefcase"></i> Gestion des Rôles</h2>
        <a class="btn btn-success" href="?action=addRole">
            <i class="fa-solid fa-user-shield"></i> Nouveau
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <thead class="table-dark text-center">
                <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Libellé</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody class="text-center align-middle">
                <?php while($row = mysqli_fetch_assoc($roles)) { ?> 
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><span class="badge bg-info text-dark"><?= $row['libelle'] ?></span></td>
                        <td>
                            <a class="btn btn-sm btn-primary me-2" href="?action=editRole&&id=<?= $row['id'] ?>">
                                <i class="fa-solid fa-edit"></i> Modifier
                            </a>
                            <a class="btn btn-sm btn-danger" href="?action=deletRole&&id=<?= $row['id'] ?>" onclick="return confirm('Voulez-vous vraiment supprimer ce rôle ?');">
                                <i class="fa-solid fa-trash"></i> Supprimer
                            </a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
