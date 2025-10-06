<?php
    session_start();

    if($_SESSION["validado"] != "SI"){
        header("Location: login.html");
    }
?>