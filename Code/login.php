<?php 
    session_start();
    require_once('./code/helper.php');
    require_once("./code/template.php");
    if(isset($_SESSION["user_id"])){
        header("Location: ./index.php");
    }
    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        if (login()){
            header("Location: ./index.php");
        }else{
            $notLoggedIn = true;
        }
    }
    template("./pages/sesion/login.php");
?>