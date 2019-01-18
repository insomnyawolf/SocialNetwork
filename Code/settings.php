<?php
    session_start();
    if(!!!isset($_SESSION["user_id"])){
        header("Location: ./login.php");
    }
    require_once("./code/template.php");
    template("./pages/settings.php");
?>