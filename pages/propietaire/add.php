<?php
$sql="SELECT * FROM propritaire";
$pro=mysqli_query($connexion,$sql);

if(!empty($_POST)){
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $adresse = $_POST['adress'];
  

    if ($nom && $prenom && $adresse) {
        // Requête SQL
        $sql = "INSERT INTO propritaire (nom, prenom, adress) VALUES ('$nom', '$prenom', '$adresse')";
        if (mysqli_query($connexion, $sql)) {

            header('Location: index.php?action=listPro');
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
                    <label for="email" class="form-label">Adresse</label>
                    <input type="text" id="email" class="form-control" name="adress" placeholder="Entrez votre adresse" required>
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

