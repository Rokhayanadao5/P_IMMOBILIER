<?php
include('database.php'); 

$erreur = ''; 

if (!isset($_SESSION['id'])) {
    die("Erreur : Utilisateur non connecté ou session invalide.");
}

// Récupérer l'état de l'utilisateur
$userId = $_SESSION['id'];
$sql = "SELECT etat FROM user WHERE id = '$userId'";
$result = mysqli_query($connexion, $sql);
$user = mysqli_fetch_assoc($result);

if ($user['etat'] == 1) {
    header("location:index.php?action=listUser"); 
    exit;
}

if (isset($_POST['soumettre'])) {
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmer'];

    if ($password !== $confirmPassword) {
        $erreur = "Les mots de passe ne correspondent pas.";
    } else {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $fileTmpPath = $_FILES['image']['tmp_name']; 
            $fileName = $_FILES['image']['name']; 
            $fileSize = $_FILES['image']['size']; 
            $fileType = $_FILES['image']['type']; 

            $imageInfo = getimagesize($fileTmpPath);
            if ($imageInfo === false) {
                $erreur = "Le fichier téléversé n'est pas une image valide.";
            } else {
                $uploadDir = 'uploads/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true); 
                }

                $newFileName = uniqid() . '_' . $fileName;
                $destPath = $uploadDir . $newFileName;

                if (move_uploaded_file($fileTmpPath, $destPath)) {
                    $_SESSION['user_image'] = $destPath; 

                    $sql = "UPDATE user SET password = '$hashedPassword', etat = 1, image = '$destPath' WHERE id = '$userId'";

                    if (mysqli_query($connexion, $sql)) {
                        $_SESSION['success'] = "Mot de passe et image mis à jour avec succès.";
                        header("location:index.php?action=listUser"); 
                        exit;
                    } else {
                        $erreur = "Erreur lors de la mise à jour du mot de passe et de l'image : " . mysqli_error($connexion);
                    }
                } else {
                    $erreur = "Erreur lors du téléversement du fichier.";
                }
            }
        } else {
            $erreur = "Aucun fichier téléversé ou erreur lors du téléversement.";
        }
    }
}
?>

<div class="container mt-5">
    <div class="border p-4 rounded">
        <h2 class="mb-4">Changer votre mot de passe</h2>
        <?php if (!empty($erreur)): ?>
            <div class="alert alert-danger"><?php echo $erreur; ?></div>
        <?php endif; ?>
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="password" class="form-label">Nouveau mot de passe :</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>

            <div class="mb-3">
                <label for="confirmPassword" class="form-label">Confirmer le mot de passe :</label>
                <input type="password" class="form-control" id="confirmPassword" name="confirmer" required>
            </div>

            <div class="mb-3">
                <label for="image">Choisir une image :</label>
                <input type="file" name="image" id="image" accept="image/*" required>
            </div>

            <button type="submit" class="btn btn-primary" name="soumettre">Soumettre</button>
        </form>
    </div>
</div>