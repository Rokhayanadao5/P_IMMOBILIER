<?php
// Récupération des propriétaires
$sql = "SELECT * FROM propritaire";
$pro = mysqli_query($connexion, $sql);

// Récupération des logements
$sql_logements = "SELECT logement.*, propritaire.nom, propritaire.prenom FROM logement 
                  JOIN propritaire ON logement.id_p = propritaire.id";
$logements = mysqli_query($connexion, $sql_logements);

// Gestion de l'ajout d'un logement
if (!empty($_POST)) {
    $reference = $_POST['reference'];
    $type = $_POST['type'];
    $adresse = $_POST['adress'];
    $surface = $_POST['surface'];
    $id_p = $_POST['id_p'];

    // Gestion du téléversement de l'image
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['image']['tmp_name'];
        $fileName = $_FILES['image']['name'];
        $fileSize = $_FILES['image']['size'];
        $fileType = $_FILES['image']['type'];

        // Vérifier si le fichier est une image
        $imageInfo = getimagesize($fileTmpPath);
        if ($imageInfo === false) {
            echo "<p class='text-danger'>Le fichier téléversé n'est pas une image valide.</p>";
        } else {
            // Dossier de destination
            $uploadDir = 'uploads/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true); // Créer le dossier s'il n'existe pas
            }

            // Créer un nom de fichier unique
            $newFileName = uniqid() . '_' . $fileName;
            $destPath = $uploadDir . $newFileName;

            // Déplacer le fichier téléversé
            if (move_uploaded_file($fileTmpPath, $destPath)) {
                // Stocker le chemin de l'image dans la base de données
                $image = $destPath;

                // Insérer le logement dans la base de données
                if ($reference && $type && $adresse && $surface && $id_p) {
                    $sql_insert = "INSERT INTO logement (reference, type, adress, surface, image, id_p) 
                                   VALUES ('$reference', '$type', '$adresse', '$surface', '$image', '$id_p')";
                    if (mysqli_query($connexion, $sql_insert)) {
                        header('Location: index.php?action=listLog');
                        exit();
                    } else {
                        echo "Erreur SQL : " . mysqli_error($connexion);
                    }
                } else {
                    echo "<p class='text-danger'>Tous les champs obligatoires doivent être remplis.</p>";
                }
            } else {
                echo "<p class='text-danger'>Erreur lors du téléversement du fichier.</p>";
            }
        }
    } else {
        echo "<p class='text-danger'>Aucun fichier téléversé ou erreur lors du téléversement.</p>";
    }
}
?>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Ajouter un logement</div>
                <div class="card-body">
                    <form method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label class="form-label">Référence</label>
                            <input type="text" class="form-control" name="reference" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Type</label>
                            <select class="form-select" name="type" required>
                                <option value="">Sélectionner un type</option>
                                <option value="Appartement">Appartement</option>
                                <option value="Maison">Maison</option>
                                <option value="Studio">Studio</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Adresse</label>
                            <select class="form-select" name="adress" required>
                                <option value="">Sélectionner une adresse</option>
                                <option value="Rue 1">Rue 1</option>
                                <option value="Rue 2">Rue 2</option>
                                <option value="Rue 3">Rue 3</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Surface</label>
                            <select class="form-select" name="surface" required>
                                <option value="">Sélectionner</option>
                                <option value="50m²">50m²</option>
                                <option value="75m²">75m²</option>
                                <option value="100m²">100m²</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Image</label>
                            <input type="file" class="form-control" name="image" accept="image/*" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Propriétaire</label>
                            <select name="id_p" class="form-select" required>
                                <option value="" disabled selected>-- Sélectionnez un propriétaire --</option>
                                <?php while ($row = mysqli_fetch_assoc($pro)) { ?>
                                    <option value="<?= $row['id'] ?>"><?= $row['nom'] . " " . $row['prenom'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Ajouter</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Liste des logements</div>
                <div class="card-body">
                    <div class="mb-3">
                        <input type="text" id="searchInput" class="form-control" placeholder="Rechercher un logement...">
                    </div>
                    <table class="table table-bordered" id="logementsTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Référence</th>
                                <th>Type</th>
                                <th>Adresse</th>
                                <th>Surface</th>
                                <th>Propriétaire</th>
                                <th>Image</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($logement = mysqli_fetch_assoc($logements)) { ?>
                                <tr>
                                    <td><?= $logement['id'] ?></td>
                                    <td><?= $logement['reference'] ?></td>
                                    <td><?= $logement['type'] ?></td>
                                    <td><?= $logement['adress'] ?></td>
                                    <td><?= $logement['surface'] ?></td>
                                    <td><?= $logement['nom'] . " " . $logement['prenom'] ?></td>
                                    <td>
                                        <img src="<?= $logement['image'] ?>" alt="Image du logement" width="100">
                                    </td>
                                    <td>
                                        <a href="edit.php?id=<?= $logement['id'] ?>" class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="?action=deleteLog&&id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" >
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Script pour la recherche -->
<script>
    document.getElementById("searchInput").addEventListener("keyup", function() {
        let filter = this.value.toLowerCase();
        let rows = document.querySelectorAll("#logementsTable tbody tr");

        rows.forEach(row => {
            let text = row.innerText.toLowerCase();
            row.style.display = text.includes(filter) ? "" : "none";
        });
    });
</script>

<!-- Styles et icônes -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">