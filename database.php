<?php
    $serveur="localhost";
    $user="root";
    $pwd="";
    $dbname="p_immo";
    $connexion=mysqli_connect($serveur,$user,$pwd,$dbname);
    if(!$connexion){
       // echo"connexion reussi";
    }else{
        //echo"pas de connexion";
    }



?>