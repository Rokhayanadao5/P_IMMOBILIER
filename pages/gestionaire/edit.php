<div class="container">
    <form action="?action=updateUser" method="POST">
        <input type="text" name="id" value="<?=  $user['id']  ?>" hidden>
        
        <label for="">Nom</label>
        <input type="text" name="nom" class="form-control" value="<?=  $user['nom']  ?>">
        
        <label for="">Prénom</label>
        <input type="text" name="prenom" class="form-control" value="<?=  $user['prenom']  ?>">
        
        <label for="">Email</label>
        <input type="text" name="email" class="form-control" value="<?=  $user['email']  ?>">
        
        <label for="">Role</label>
        <select name="id_r" id="role" class="form-control">
            <?php while ($row = mysqli_fetch_assoc($roles)) { ?>
                <option value="<?= $row['id'] ?>" <?= ($row['id'] == $user['id_r']) ? 'selected' : '' ?>>
                    <?= $row['libelle'] ?>
                </option>
            <?php } ?>
        </select>
        
        <div class="mt-5">
            <button type="submit" class="btn btn-primary">Modifier</button>
            <button type="reset" class="btn btn-danger">Annuler</button>
        </div>
    </form>
</div>
