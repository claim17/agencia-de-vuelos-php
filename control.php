<?php
    //inicio de sesion
    session_start();
    $usuario = $_POST["usuario"];
    //echo $usuario;

    $password = $_POST["password"];
    //echo $password;



    if($usuario == "admin" && $password == "1234"){
        $_SESSION["validado"] = "SI";
        header("Location: menu.php");
    }else{
        header("Location: login.html");
    }

?>