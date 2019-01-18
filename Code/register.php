<?php 
  session_start();
  require_once('./code/helper.php');
  require_once("./code/template.php");
  if(isset($_SESSION["user_id"])){
        header("Location: ./index.php");
  }
  if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    if (register()){
      header("Location: ./index.php");
    }else{
      $notRegistered = true;
    }
  }
  template("./pages/sesion/register.php");
?>