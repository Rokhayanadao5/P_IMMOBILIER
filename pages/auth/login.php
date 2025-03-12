<?php
include("database.php");

if (isset($_POST['seConnecter'])) {
    $email = mysqli_real_escape_string($connexion, $_POST['email']);
    $password = $_POST['password']; 
    
    $sql = "SELECT u.*, r.libelle FROM user u JOIN role r ON u.id_r = r.id WHERE u.email='$email'";
    $resultat = mysqli_query($connexion, $sql);
    $user = mysqli_fetch_assoc($resultat);

    if ($user && password_verify($password, $user['password'])) {
        // Stocker l'ID et d'autres informations dans la session
        $_SESSION['id'] = $user['id'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['nom'] = $user['nom'];
        $_SESSION['prenom'] = $user['prenom'];
        $_SESSION['image']=$user['image'];
        $_SESSION['id_r']=$user['libelle'];

        if ($user['etat'] == 0) {
            // Rediriger vers la page de changement de mot de passe
            header("location:index.php?action=changerPassword"); 
            exit();
        } else {
            // Rediriger vers la page d'accueil
            header("location:index.php?action=listUser"); 
            exit();
        }
    } else {
        $erreur = "Login ou mot de passe incorrect.";
    }
}


?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page de Connexion</title>

    <!-- Google Fonts and Boxicons -->
    <link rel='stylesheet' href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css'>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins&display=swap">

    <!-- Custom CSS for Styling -->
    <style>
        /* Centrage de la page */
        body {
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
            background-color: #f2f2f2;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        /* Formulaire */
        .login_box {
            background-color: white;
            padding: 50px; /* Augmenté pour un plus grand formulaire */
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 600px; /* Taille encore augmentée */
        }

        .login-header {
            text-align: center;
            font-size: 28px;
            color: #2575fc;
            margin-bottom: 20px;
        }

        .input_box {
            position: relative;
            margin-bottom: 25px;
        }

        .input-field {
            width: 100%;
            padding: 18px; /* Augmenté pour un plus grand champ */
            border: none;
            border-radius: 10px;
            background: #f1f1f1;
            font-size: 18px; /* Taille de police augmentée */
            transition: all 0.3s ease;
        }

        .input-field:focus {
            background: #e0e0e0;
            outline: none;
        }

        .label {
            position: absolute;
            top: 10px;
            left: 15px;
            font-size: 16px;
            color: #aaa;
            pointer-events: none;
            transition: 0.3s ease;
        }

        .input-field:focus + .label,
        .input-field:not(:focus):valid + .label {
            top: -10px;
            left: 10px;
            font-size: 14px;
            color: #2575fc;
        }

        .icon {
            position: absolute;
            top: 50%;
            right: 15px;
            transform: translateY(-50%);
            color: #aaa;
            font-size: 22px;
        }

        .remember-forgot {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .remember-me {
            font-size: 16px;
        }

        .forgot a {
            font-size: 16px;
            color: #2575fc;
            text-decoration: none;
        }

        .forgot a:hover {
            text-decoration: underline;
        }

        .input-submit {
            width: 100%;
            padding: 18px; /* Augmenté pour un plus grand bouton */
            background: #2575fc;
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 18px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .input-submit:hover {
            background: #6a11cb;
        }

        .register {
            text-align: center;
            font-size: 16px;
        }

        .register a {
            color: #2575fc;
            text-decoration: none;
        }

        .register a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="login_box">
        <div class="login-header">
            <span>Connexion</span>
        </div>

        <div class="input_box">
            <form action="" method="POST">
                <?php if (!empty($erreur)): ?>
                    <div class="alert alert-danger"><?= $erreur ?></div>
                <?php endif; ?>
                
                <div class="mb-3">
                    <input type="text" name="email" class="input-field" required>
                    <label for="email" class="label">Email</label>
                    <i class="bx bx-user icon"></i>
                </div>

                <div class="mb-3">
                    <input type="password" name="password" class="input-field" required>
                    <label for="password" class="label">Mot de passe</label>
                    <i class="bx bx-lock-alt icon"></i>
                </div>

                <div class="d-grid gap-2 mt-4">
                    <button type="submit" class="btn btn-primary input-submit" name="seConnecter">Se connecter</button>
                </div>
            </form>

            <div class="register">
                <span>Pas encore de compte ? <a href="#">S'inscrire</a></span>
            </div>
        </div>
    </div>

</body>
</html>
