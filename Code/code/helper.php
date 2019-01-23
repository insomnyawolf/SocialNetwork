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
function getuser(){
   /* <h6>Editar Usuario</h6>
                        <h4 class="inline-block w3-padding">ID:</h4><h4 class="w3-border w3-padding"></h4><br /><br />
                        <h4 class="inline-block w3-padding">Username:</h4><input name="nombre" id="nombre" type="text" class="w3-border w3-padding" value=<?php echo('"'.$_SESSION["user"].'"');?> /><br /><br />
                        <h4 class="inline-block w3-padding">Nombre:</h4><input name="nombre" id="nombre" type="text" class="w3-border w3-padding" value=<?php echo('"'.$_SESSION["nombre"].'"');?> /><br /><br />
                        <h4 class="inline-block w3-padding">Apellido:</h4><input name="apellido" id="apellido" type="text" class="w3-border w3-padding" value=<?php echo('"'.$_SESSION["apellido"].'"');?> /><br /><br />
                        <h4 class="inline-block w3-padding">Domicilio:</h4><input name="domicilio" id="domicilio" type="text" class="w3-border w3-padding" value=<?php echo('"'.$_SESSION["domicilio"].'"');?> /><br /><br />
                        <h4 class="inline-block w3-padding">Fecha Nacimiento:</h4><input name="fecha_nac" id="fecha_nac" type="date" class="w3-border w3-padding" value="<?php echo(formatDateSettings($_SESSION["fecha_nac"])); ?>" /><br /><br />
                        <h4 class="inline-block w3-padding">Telefono:</h4><input name="telefono" id="telefono" type="text" class="w3-border w3-padding" value=<?php echo('"'.$_SESSION["telefono"].'"');?> /><br /><br />
                        <h4 class="inline-block w3-padding">Movil:</h4> <input name="movil" id="movil" type="text" class="w3-border w3-padding" value=<?php echo('"'.$_SESSION["movil"].'"');?> /><br /><br />
                        <h4 class="inline-block w3-padding">DNI:</h4><input name="dni" id="dni" type="text" class="w3-border w3-padding" value=<?php echo('"'.$_SESSION["dni"].'"');?> /><br /><br />
                        <div class="full w3-padding">
                            <button type="submit" id="submitFormData" class="w3-button isa_error"><i class="fa fa-pencil"></i> &nbsp;Desactivar</button>
                        </div>
                    </form>*/
}
?>