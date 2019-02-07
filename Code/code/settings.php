<?php
session_start();
if(!!!isset($_SESSION["user_id"])){
    header("Location: ./../login.php");
    //Header te redirige de una página a otra
    //require te carga el codigo especificado
}else{
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        require_once("./config.php");
        require_once("./helper.php");
        if(isset($_FILES["avatar"]["name"])){ //Si el avatar tiene nombre
            require_once('./avatar.php');
        }else if($_REQUEST["what"] == "unsuscribe"){ //Si el usuario elije darse de baja te carga el código
            if(unsuscribe()){
                if(session_destroy()) { 
                    header("Location: ./../login.php");
                }
            }else{
                header("Location: ./../settings.php");
            }
        }else{
            $date = strtotime($_REQUEST["fecha_nac"]);
            $sql = "UPDATE users SET nombre=?, apellido=?, domicilio=?, fecha_nac=?, telefono=?, movil=?, dni=? WHERE user_id=?";
            $stmt= $pdo->prepare($sql); //prepared statement para actualizar el usuario
            $stmt->execute([$_REQUEST["nombre"], 
                            $_REQUEST["apellido"], 
                            $_REQUEST["domicilio"], 
                            $date, 
                            $_REQUEST["telefono"],
                            $_REQUEST["movil"],
                            $_REQUEST["dni"], 
                            $_SESSION["user_id"]]
                        );
            if ($stmt->rowCount()){ //Para ver cuantas lineas se han modificado
                $_SESSION["nombre"] = $_REQUEST["nombre"];
                $_SESSION["apellido"] = $_REQUEST["apellido"];
                $_SESSION["domicilio"] = $_REQUEST["domicilio"];
                $_SESSION["fecha_nac"] = $date;
                $_SESSION["telefono"] = $_REQUEST["telefono"];
                $_SESSION["movil"] = $_REQUEST["movil"];
                $_SESSION["dni"] = $_REQUEST["dni"];
                header("Location: ./../settings.php");
            }
        }
    }
}
?>