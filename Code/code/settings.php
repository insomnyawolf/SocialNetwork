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
        }else if($_REQUEST["func"] == "unsuscribe"){ //Si el usuario elije darse de baja te carga el código
            if(unsuscribe()){
                if(session_destroy()) { 
                    header("Location: ./../login.php");
                }
            }else{
                header("Location: ./../settings.php");
            }
        }else if($_REQUEST["func"] == "addAccount"){ //Si el usuario elije añadir cuenta te carga el código
            if(addAccount()){
                echo("<h3>Se Añadio correctamente la cuenta</h3>");
            }else{
                echo("<h3>Ha ocurrido un error</h3>");
            }
        }else if($_REQUEST["func"] == "deleteAccount"){ //Si el usuario elije borrar cuenta te carga el código
            if(DeleteAccount()){
                echo("<h3>Se Borró correctamente la cuenta</h3>");
            }else{
                echo("<h3>Ha ocurrido un error</h3>");
            }
        }else if($_REQUEST["func"] == "refreshAcounts"){
            //func es el nombre que estamos utilizando para poder elegir que funcion utilizar
            //Aqui el usuario ha pulsado refresh por lo que se mostrarán tantas cuentas como hayamos añadido
            getAccounts();
        }else if($_REQUEST["func"] == "addMoney"){ //Si el usuario elije darse de baja te carga el código
            addMoney();
        }else if($_REQUEST["func"] == "takeMoney"){ //Si el usuario elije darse de baja te carga el código
            takeMoney();
        }else if($_REQUEST["func"] == "comprarAccion"){ //Si el usuario elije darse de baja te carga el código
            comprarAccion();
        }else if($_REQUEST["func"] == "venderAccion"){ //Si el usuario elije darse de baja te carga el código
            venderAccion();
        }else if($_REQUEST["func"] == "editUser"){
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
        }else{
            echo("<h1>ERROR!</h1>");
        }
    }
}
?>