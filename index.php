<!doctype html>
<html lang="en">
    <head>
        <title>Title</title>
        <!-- Required meta tags -->
        <meta charset="utf-8" />
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1, shrink-to-fit=no"
        />

        <!-- Bootstrap CSS v5.2.1 -->
        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
            crossorigin="anonymous"
        />
    </head>

    <body>
    <?php
    session_start();
    require_once './database.php';

    if (isset($_GET['action'])) {
        require_once './shared/navbar.php';

        if ($_GET['action'] == "listUser") {
            require_once './pages/gestionaire/liste.php';
        }
        if($_GET['action']=="deleteUser"){
            $id =$_GET['id'];
            $sql="DELETE FROM user WHERE id=$id";
            mysqli_query($connexion,$sql);
            header('location:index.php?action=listUser');
            exit();
        }
        if ($_GET['action'] == "listPro") {
            require_once './pages/propietaire/liste.php';
        }
        if($_GET['action']=="deletePro"){
            $id =$_GET['id'];
            $sql="DELETE FROM propritaire WHERE id=$id";
            mysqli_query($connexion,$sql);
            header('location:index.php?action=listPro');
            exit();
        }
        if ($_GET['action'] == "listLog") {
            require_once './pages/logement/liste.php';
        }
        if($_GET['action']=="deleteLog"){
            $id =$_GET['id'];
            $sql="DELETE FROM logement WHERE id=$id";
            mysqli_query($connexion,$sql);
            header('location:index.php?action=listLog');
            exit();
        }

        if ($_GET['action'] == "addPro") {
            require_once './pages/propietaire/add.php';
        }

        if ($_GET['action'] == "addUser") {
            require_once './pages/gestionaire/add.php';
        }

        if ($_GET['action'] == "listRole") {
            require_once './pages/role/liste.php';
        }

        if ($_GET['action'] == "addRole") {
            require_once './pages/role/add.php';
        }

        if ($_GET['action'] == "deconnexion") {
            session_destroy();
            header("location:index.php");
        }
        if ($_GET['action'] == "changerPassword") {
            require_once './pages/auth/mod.php';
        }
        
    } else {
       
            require_once './pages/auth/login.php';
        
       
    }
?>
        <!-- Bootstrap JavaScript Libraries -->
        <script
            src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
            integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
            crossorigin="anonymous"
        ></script>

        <script
            src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
            integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
            crossorigin="anonymous"
        ></script>
    </body>
</html>
