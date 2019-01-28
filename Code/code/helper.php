<?php
if (!defined('ROOT')) {
    define('ROOT', dirname(__FILE__, 2)."/");
}
function getAvatar($id){
    $filename = './upload/'.$id;
    foreach (glob($filename.".{jpg,jpeg,png,gif}", GLOB_BRACE) as $filename) {
    return $filename;
    }
    return "./upload/-1.png";
}
function formatDate($timestamp){
    //La @ Suprime las alertas generadas por esta funcion
    return date('d-m-Y', $timestamp);
    //return $timestamp;
}
function formatDateSettings($timestamp){
    //La @ Suprime las alertas generadas por esta funcion
    return date('Y-m-d', $timestamp);
    //return $timestamp;
}
function secured_hash($input){
    //128Char in DB
    return hash('sha512', $input);
}
function login(){
    require(ROOT .'code/config.php');
    //Evitar injeccion de sql
    $username = $_REQUEST['username'];
    //Contraseña
    //$contrasena = md5($contrasena); Reemplazado por otro metodo mas seguro a traves de bcrypt
    $password = secured_hash($_REQUEST['password']);
    
    //Check si el user existe en la DB
    //Realizamos la consulta para recibir los datos del usuario cuyo email coincida
    $query =  "SELECT *
              FROM  users 
              WHERE user = ?
              AND passwd = ?
              AND isActive = 1
                ";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$username, $password]);
    //$result = $pdo->query($query) or die($con->error);
    while ($row = $stmt->fetch()){
        //`user_id`, `user`, `passwd`, `avatarID`, `nombre`, `apellido`, `domicilio`, `fecha_nac`, `telefono`, `movil`, `dni`, `isCAT`
        $_SESSION["user_id"] = $row["user_id"];
        $_SESSION["user"] = $row["user"];
        $_SESSION["nombre"] = $row["nombre"];
        $_SESSION["apellido"] = $row["apellido"];
        $_SESSION["domicilio"] = $row["domicilio"];
        $_SESSION["fecha_nac"] = $row["fecha_nac"];
        $_SESSION["telefono"] = $row["telefono"];
        $_SESSION["movil"] = $row["movil"];
        $_SESSION["dni"] = $row["dni"];
        $_SESSION["isCAT"] = $row["isCAT"];
        //El usuario existe en la base de datos
        return true;
    }
    //El usuario no existe en la base de datos
    return false;
}

function register(){
    require(ROOT .'code/config.php');
    //Comprueba que ambas claves introducidas sean iguales
    $password = $_REQUEST['password'];
    if(($password == $_REQUEST['ConfirmPassword']) && (strlen($password) > 0)){
        //Evitar injeccion de sql
        $username = $_REQUEST['username'];
        //Contraseña
        //$contrasena = md5($contrasena); Reemplazado por otro metodo mas seguro a traves de bcrypt
        $password = secured_hash($password);
        //Check si el user existe en la DB
        //Realizamos la consulta para recibir los datos del usuario cuyo email coincida
        $query =  "SELECT *
                FROM  users 
                WHERE user = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$username]);
        if ($stmt->rowCount()){
            //El usuario existe en la base de datos
            return false;
        }
        //El usuario no existe en la base de datos
        $insertQuery = "INSERT INTO `users` (`user` ,`passwd`)
                        VALUES (?,  ?);";
        $stmt = $pdo->prepare($insertQuery);
        $stmt->execute([$username, $password]);
        if ($stmt->rowCount()){
            return true;
        }
    }
    return false;
}
function unsuscribe(){ 
    //Check si el user existe en la DB
    //Realizamos la consulta para recibir los datos del usuario cuyo email coincida
    $query =  'UPDATE users   
               SET isActive = 0 
               WHERE user_id = ? 
               AND passwd = ?';
    require(ROOT .'code/config.php');  
    $stmt = $pdo->prepare($query); //Prepared Statement con la query 
    $password = secured_hash($_REQUEST['password']);
    $stmt->execute([$_SESSION['user_id'], $password]);
    if ($stmt->rowCount()){ //Si algo ha cambiado
        return true; //devuelve verdadero
    }
    return false; //sino devuelve falso
}

?>