<?php
if (!empty($_POST)) {
    $libelle = $_POST['libelle'];
    
    $sql = "INSERT INTO role (libelle) VALUES ('$libelle');";
    
    mysqli_query($connexion, $sql);
    header('location:index.php?action=listRole');
}
?>

<!-- Formulaire d'ajout de rôle -->
<div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="p-4 border rounded bg-white shadow" style="width: 600px;">
        <h3 class="text-center text-primary mb-4"><i class="fa-solid fa-shield-alt"></i> Ajouter un Rôle</h3>
        <form action="#" method="POST">

            <div class="mb-3">
                <label for="libelle" class="form-label">Libellé</label>
                <input type="text" id="libelle" class="form-control" placeholder="Entrez le libellé du rôle" name="libelle" required>
            </div>
          
            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-success">Valider</button>
                <button type="reset" class="btn btn-danger">Annuler</button>
            </div>
        </form>
    </div>
</div>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
