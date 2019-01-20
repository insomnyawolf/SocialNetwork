<?php
session_start();
if(!!!isset($_SESSION["user_id"])){
    header("Location: ./../login.php");
}else{
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        require_once("./config.php");
        require_once("./helper.php");
        if(isset($_FILES["avatar"]["name"])){
            require_once('./avatar.php');
        }else{
            $date = strtotime($_REQUEST["fecha_nac"]);
            $sql = "UPDATE users SET nombre=?, apellido=?, domicilio=?, fecha_nac=?, telefono=?, movil=?, dni=? WHERE user_id=?";
            $stmt= $pdo->prepare($sql);
            $stmt->execute([$_REQUEST["nombre"], 
                            $_REQUEST["apellido"], 
                            $_REQUEST["domicilio"], 
                            $date, 
                            $_REQUEST["telefono"],
                            $_REQUEST["movil"],
                            $_REQUEST["dni"], 
                            $_SESSION["user_id"]]
                        );
            if ($stmt->rowCount()){
                $_SESSION["nombre"] = $_REQUEST["nombre"];
                $_SESSION["apellido"] = $_REQUEST["apellido"];
                $_SESSION["domicilio"] = $_REQUEST["domicilio"];
                $_SESSION["fecha_nac"] = formatDate($date);
                $_SESSION["telefono"] = $_REQUEST["telefono"];
                $_SESSION["movil"] = $_REQUEST["movil"];
                $_SESSION["dni"] = $_REQUEST["dni"];
                header("Location: ./../settings.php");
            }
        }
    }
}
?>