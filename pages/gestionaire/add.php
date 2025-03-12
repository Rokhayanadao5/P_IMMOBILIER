<?php
require_once 'mailEnvoye.php';
$sql="SELECT * FROM role";
$rol=mysqli_query($connexion,$sql);

if(!empty($_POST)){
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $id_r = $_POST['id_r'];
    $p=$_POST['password'];

    if ($nom && $prenom && $email && $password && $id_r) {
        // Requête SQL
        $sql = "INSERT INTO user (nom, prenom, Email, password, id_r) VALUES ('$nom', '$prenom', '$email', '$password', '$id_r')";
        envoyerEmailInscription($email,$p);
        if (mysqli_query($connexion, $sql)) {

            header('Location: index.php?action=listUser');
            exit();
        } else {
            echo "Erreur SQL : " . mysqli_error($connexion);
        }
    } else {
        echo "Tous les champs obligatoires doivent être remplis.";
    }
}
?>

<div class="container d-flex justify-content-center align-items-center" style="min-height: 90vh;">
    <div class="card shadow-lg" style="width: 500px;">
        <div class="card-header bg-primary text-white text-center">
            <h4 class="mb-0">Ajouter un utilisateur</h4>
        </div>
        <div class="card-body">
            <form action="#" method="POST">
                <div class="mb-3">
                    <label for="nom" class="form-label">Nom</label>
                    <input type="text" id="nom" class="form-control" name="nom" placeholder="Entrez votre nom" required>
                </div>
                <div class="mb-3">
                    <label for="prenom" class="form-label">Prénom</label>
                    <input type="text" id="prenom" class="form-control" name="prenom" placeholder="Entrez votre prénom" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" id="email" class="form-control" name="email" placeholder="Entrez votre email" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" id="password" class="form-control" name="password" placeholder="Choisissez un mot de passe" required>
                </div>
                <div class="mb-3">
                    <label for="role" class="form-label">Rôle</label>
                    <select name="id_r" id="role" class="form-select" required>
                        <option value="" disabled selected>-- Sélectionnez un rôle --</option>
                        <?php while ($row = mysqli_fetch_assoc($rol)) { ?>
                            <option value="<?= $row['id'] ?>"><?= $row['libelle'] ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="d-flex justify-content-between">
                    <button type="reset" class="btn btn-secondary">Annuler</button>
                    <button type="submit" class="btn btn-success">Valider</button>
                </div>
            </form>
        </div>
    </div>
</div>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

