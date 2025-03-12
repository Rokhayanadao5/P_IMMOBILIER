<?php

//session_start();
include('database.php'); // Inclusion de la connexion à la base de données

if (isset($_POST['modifier'])) {
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    if ($password !== $confirmPassword) {
        $erreur = "Les mots de passe ne correspondent pas.";
    } else {
        // Vérifier et téléverser l'image
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $fileTmpPath = $_FILES['image']['tmp_name']; 
            $fileName = $_FILES['image']['name']; 
            $fileSize = $_FILES['image']['size']; 
            $fileType = $_FILES['image']['type']; 

            // Dossier de destination
            $uploadDir = 'uploads/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true); // Créer le dossier s'il n'existe pas
            }

            // Créer un nom de fichier unique
            $newFileName = uniqid() . '_' . $fileName;
            $destPath = $uploadDir . $newFileName;

            if (move_uploaded_file($fileTmpPath, $destPath)) {
                $_SESSION['user_image'] = $destPath; // Stocker le chemin de l'image dans la session
            } else {
                $erreur = "Erreur lors du téléversement du fichier.";
            }
        } else {
            $erreur = "Aucun fichier téléversé ou erreur lors du téléversement.";
        }

        // Mettre à jour le mot de passe
        // Mettre à jour le mot de passe sans hachage
// Mettre à jour le mot de passe sans hachage
if (empty($erreur)) {
    $password = $_POST['password']; // On prend directement le mot de passe saisi sans le hacher.

    $userId = $_SESSION['id']; // Récupérer l'ID de l'utilisateur connecté
    $sql = "UPDATE users SET password = '$password', password_changed = 1 WHERE id = '$userId'";

    if (mysqli_query($connexion, $sql)) {
        $_SESSION['success'] = "Mot de passe mis à jour avec succès.";
        
        header("location:index.php?action=listUser"); // Rediriger vers la liste des logements après la mise à jour
        exit;
    } else {
        $erreur = "Erreur lors de la mise à jour du mot de passe.";
    }
}

}
        }
    

?>

<!doctype html>
<html lang="fr">
<head>
    <title>Modifier le mot de passe</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container col-md-4">
        <div class="card">
            <div class="card-header"><h3>Modifier le mot de passe</h3></div>
            <div class="card-body">
                <?php if (!empty($erreur)) { ?>
                    <div class="alert alert-danger"><?= $erreur ?></div>
                <?php } ?>
                <form action="" method="POST" enctype="multipart/form-data" class="rounded shadow bg-light p-3">
                    <label for="password">Mot de passe</label>
                    <input type="password" name="password" class="form-control" required>

                    <label for="confirmPassword">Confirmer le mot de passe</label>
                    <input type="password" name="confirmPassword" class="form-control" required>

                    <label for="image">Choisir une image</label>
                    <input type="file" name="image" id="image" class="form-control" accept="image/*">

                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary w-100" name="modifier">Modifier</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>



include("database.php");

if (!isset($_SESSION['id'])) {
    die("Erreur : Utilisateur non connecté ou session invalide.");
}

if (isset($_POST['soumettre'])) {
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmer'];

    // Vérification que les mots de passe correspondent
    if ($password === $confirmPassword) {
        // Hachage du mot de passe
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Récupération de l'ID de l'utilisateur
        $userId = $_SESSION['id'];

        // Gestion de l'image téléchargée
        $imageFile = $_FILES['image']['name'];          // Nom de l'image téléchargée
        $temp_name = $_FILES['image']['tmp_name'];      // Nom temporaire du fichier
        $folder = "uploads/";                            // Dossier où stocker les images

        // Vérifier si un fichier a été téléchargé et est une image
        if ($imageFile) {
            $imageFileType = strtolower(pathinfo($imageFile, PATHINFO_EXTENSION));
            
            // Vérifier que le fichier est une image
            if (in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
                // Générer un nom unique pour l'image basé sur l'ID utilisateur
                $newImageName = "user_" . $userId . "." . $imageFileType;

                // Déplacer le fichier téléchargé vers le dossier "uploads"
                if (move_uploaded_file($temp_name, $folder . $newImageName)) {
                    // Mise à jour du mot de passe et de l'image dans la base de données
                    $sql = "UPDATE user SET password = '$hashedPassword', etat = 1, image = '$newImageName' WHERE id = $userId";

                    if (mysqli_query($connexion, $sql)) {
                        // Redirection vers la page de liste des utilisateurs
                        header("Location: index.php?action=listUser");
                        exit();
                    } else {
                        echo "Erreur lors de la mise à jour du mot de passe et de l'image.";
                    }
                } else {
                    echo "Erreur lors du téléchargement de l'image.";
                }
            } else {
                echo "Seules les images JPG, JPEG, PNG ou GIF sont autorisées.";
            }
        } else {
            echo "Aucune image téléchargée.";
        }
    } else {
        echo "Les mots de passe ne correspondent pas.";
    }
}