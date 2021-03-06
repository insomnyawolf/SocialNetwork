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

function addAccount(){ //Añade una cuenta de un cliente a la base de datos 
    require(ROOT .'code/config.php');
    $query = 'INSERT INTO accounts(user_id, balance) VALUES (?,?)';
    $stmt = $pdo->prepare($query); //Prepared Statement con la query
    $stmt->execute([$_SESSION['user_id'], 0]);
    if ($stmt->rowCount()){ //Si algo ha cambiado
        return true; //devuelve verdadero
    }
    return false; //sino devuelve falso
}
function DeleteAccount(){ //Borra una cuenta de un cliente de la base de datos 
    require(ROOT .'code/config.php');
    $query = 'DELETE FROM accounts WHERE user_id = ? AND accounts_id = ?;';
    $stmt = $pdo->prepare($query); //Prepared Statement con la query
    $stmt->execute([$_SESSION['user_id'], $_REQUEST['accounts_id']]);
    if ($stmt->rowCount()){ //Si algo ha cambiado
        return true; //devuelve verdadero
    }
    return false; //sino devuelve falso
}
function addMoney(){
    require(ROOT .'code/config.php');
    $query = 'SELECT balance FROM accounts WHERE user_id = ? AND accounts_id = ?';
    $stmt = $pdo->prepare($query); //Prepared Statement con la query
    $stmt->execute([$_SESSION['user_id'], $_REQUEST['accounts_id']]);
    if($stmt->rowCount()){
        if($_REQUEST['amount'] > 0){
            $row = $stmt->fetch();
            $balance = $row["balance"] + $_REQUEST['amount'];
            $row = $stmt->fetch(); //Cursor stmt y row son las filas de la query
            $query2 = 'UPDATE accounts   
                       SET balance = ?
                       WHERE accounts_id = ?';
            $stmt2 = $pdo->prepare($query2); //Prepared Statement con la query
            $stmt2->execute([$balance, $_REQUEST['accounts_id']]);
            if ($stmt2->rowCount()){ //Si algo ha cambiado
                echo("Se ha ingresado su dinero satisfactoriamente."); 
            }else{
                echo("Ha ocurrido un error al añadir su dinero"); 
                print_r($stmt2->errorInfo());
            }
        }else{
            echo("Por favor, al ingresar saldo añada una cantidad superior a 0");    
        }
    }else{
        echo("Esta cuenta no existe para este cliente");
    }
}
function takeMoney(){
    require(ROOT .'code/config.php');
    $query = 'SELECT balance FROM accounts WHERE user_id = ? AND accounts_id = ?';
    $stmt = $pdo->prepare($query); //Prepared Statement con la query
    $stmt->execute([$_SESSION['user_id'], $_REQUEST['accounts_id']]);
    if($stmt->rowCount()){
        if($_REQUEST['amount'] > 0){
            $row = $stmt->fetch();
            $balance = $row["balance"] - $_REQUEST['amount'];
            if($balance > 0){
                $row = $stmt->fetch(); //Cursor stmt y row son las filas de la query
                $query2 =   'UPDATE accounts   
                        SET balance = ?
                        WHERE accounts_id = ?';
                $stmt2 = $pdo->prepare($query2); //Prepared Statement con la query
                $stmt2->execute([$balance, $_REQUEST['accounts_id']]);
                if ($stmt2->rowCount()){ //Si algo ha cambiado
                    echo("Se ha retirado su dinero satisfactoriamente."); 
                }else{
                    echo("Ha ocurrido un error al retirar su dinero"); 
                }
            }else{
                echo("No puede retirar mas dinero del que dispone"); 
            }
        }else{
            echo("Por favor, al retirar saldo seleccione una cantidad superior a 0");    
        }
    }else{
        echo("Esta cuenta no existe para este cliente");
    }
}
function getAccounts(){
    require(ROOT .'code/config.php');
    $query = 'SELECT * FROM accounts WHERE user_id = ?';
    $stmt = $pdo->prepare($query); //Prepared Statement con la query
    $stmt->execute([$_SESSION['user_id']]);
    while ($row = $stmt->fetch()){
        $cantidad = "cantidad" . $row['accounts_id'];
        $form = "form" . $row['accounts_id'];
        ?>
        <form method="post" class="w3-container w3-padding w3-centered" id="<?php echo($form); ?>" onsubmit="event.preventDefault();">
            <h4 class="inline-block w3-padding">Balance:</h4><input type="text" class="w3-border w3-padding" value=<?php echo($row["balance"]);?>  readonly /><br /><br />
            <h4 class="inline-block w3-padding">Cantidad:</h4><input name="nombre" id="<?php echo($cantidad); ?>" type="text" class="w3-border w3-padding"/><br /><br />
            <button type="submit" class="w3-button w3-theme" onclick="addMoney(<?php echo($row['accounts_id']); ?>);"> &nbsp;Ingresar</button>
            <button type="submit" class="w3-button w3-theme" onclick="takeMoney(<?php echo($row['accounts_id']); ?>);"> &nbsp;Retirar</button>
            <button type="submit" class="w3-button w3-theme" onclick="DeleteAcount(<?php echo($row['accounts_id']); ?>);"> &nbsp;Borrar Cuenta</button>
        </form>
        <?php
    }
}
function getIndices(){
    require(ROOT .'code/config.php');
    $queryref = 'SELECT * FROM indices';
    $stmtref = $pdo->prepare($queryref); //Prepared Statement con la query
    $stmtref->execute();
    $time = time();
    while ($rowref = $stmtref->fetch()){
        $diff = $time - $rowref["last_refresh"];
        if ($diff > 150){
            $queryup = 'UPDATE indices SET `value` = ?, last_refresh = ? WHERE indices_id = ?';
            $stmtup = $pdo->prepare($queryup); //Prepared Statement con la query
            $stmtup->execute([rand(0, 100), $time, $rowref["indices_id"]]);
        }
    }
    $query = 'SELECT * FROM indices';
    $stmt = $pdo->prepare($query); //Prepared Statement con la query
    $stmt->execute();
    while ($row = $stmt->fetch()){
        $query2 = 'SELECT * FROM `indices_compra` where user_id = ? AND indices_id = ?';
        $stmt2 = $pdo->prepare($query2); //Prepared Statement con la query
        $stmt2->execute([$_SESSION['user_id'], $row['indices_id']]);
        $row2 = $stmt2->fetch();
        $form = "form" . $row['indices_id'];
        $cantidadid = "cantidad".$row['indices_id'];
        $valorid = "valor".$row['indices_id'];
        $precioid = "precio".$row['indices_id'];
        $cuentaid = "cuenta".$row['indices_id'];
        $id = $row['indices_id'];
        ?>
        <form method="post" class="w3-container w3-padding w3-centered" id="<?php echo($form); ?>" onsubmit="event.preventDefault();">
            <h4 class="inline-block w3-padding">Nombre:</h4><input type="text" class="w3-border w3-padding" value="<?php echo($row["name"]);?>"  readonly /><br /><br />
            <h4 class="inline-block w3-padding">Valor:</h4><input type="text" id="<?php echo($valorid);?>" class="w3-border w3-padding" value="<?php echo($row["value"]);?>"  readonly />
            <h4 class="inline-block w3-padding">Disponibles:</h4><input type="text" class="w3-border w3-padding" value="<?php echo($row2["amount"]);?>" readonly/><br /><br />
            <h4 class="inline-block w3-padding">Cantidad:</h4><input type="number" id="<?php echo($cantidadid);?>" class="w3-border w3-padding" min="0" value="0" onkeypress="updatePrecio(<?php echo($id);?>);" oninput="updatePrecio(<?php echo($id);?>);" onchange="updatePrecio(<?php echo($id);?>);"/>
            <h4 class="inline-block w3-padding">Precio:</h4><input type="text" id="<?php echo($precioid);?>" class="w3-border w3-padding" value="0" readonly/><br /><br />
            <button type="button" class="w3-button w3-theme-d1 w3-margin-bottom" onclick="venderAccion(<?php echo($id); ?>);"><i class="fas fa-comment-dollar"></i>&nbsp;Vender</button>
            <button type="button" class="w3-button w3-theme-d2 w3-margin-bottom" onclick="comprarAccion(<?php echo($id); ?>);"><i class="fas fa-comment-dollar"></i>&nbsp;Comprar</button> 
            <select name="cuenta" id="<?php echo($cuentaid);?>" class="w3-button w3-theme-d1 w3-margin-bottom">
                <?php getIndicesCuentas(); ?>
            </select>
        </form>
        <?php
    }
}
function getIndicesCuentas(){
    require(ROOT .'code/config.php');
    $query = 'SELECT * FROM accounts WHERE user_id = ?';
    $stmt = $pdo->prepare($query); //Prepared Statement con la query
    $stmt->execute([$_SESSION['user_id']]);
    while ($row = $stmt->fetch()){
    ?>
    <option value="<?php echo($row["accounts_id"]);?>"><?php echo($row["balance"]);?></option>
    <?php }
}
function comprarAccion(){
    require(ROOT .'code/config.php');
    //Valor De La Tansaccion
    $queryValue = 'SELECT `value` FROM indices where indices_id = ?';
    $stmtValue = $pdo->prepare($queryValue); //Prepared Statement con la query
    $stmtValue->execute([$_REQUEST['indice']]);
    $rowValue = $stmtValue->fetch();
    //Dinero en la cuenta
    $query = 'SELECT balance FROM accounts WHERE user_id = ? AND accounts_id = ?';
    $stmt = $pdo->prepare($query); //Prepared Statement con la query
    $stmt->execute([$_SESSION['user_id'], $_REQUEST['accounts_id']]);
    if($stmt->rowCount()){
        if($_REQUEST['amount'] > 0){
            $row = $stmt->fetch();
            $valorTrans = $_REQUEST['amount']*$rowValue['value'];
            $balance = $row["balance"] - $valorTrans;
            if($balance >= 0){
                //Comprobar Si existe Para actualizarlo y si no crear registro nuevo
                $queryUserAccion = 'SELECT * FROM indices_compra where indices_id = ? AND user_id = ?';
                $stmtUserAccion = $pdo->prepare($queryUserAccion); //Prepared Statement con la query
                $stmtUserAccion->execute([$_REQUEST['indice'], $_SESSION['user_id']]);
                if($stmtUserAccion->rowCount()){
                    $rowAccion = $stmtUserAccion->fetch();
                    $total = $_REQUEST['amount']+$rowAccion['amount'];
                    $query2 =   'UPDATE indices_compra SET amount = ? WHERE indices_compra_id = ?';
                    $stmt2 = $pdo->prepare($query2); //Prepared Statement con la query
                    $stmt2->execute([$total, $rowAccion['indices_compra_id']]);
                }else{
                    $queryInsert = 'INSERT INTO indices_compra(indices_id, user_id, amount) values(?, ?, ?)';
                    $stmtyInsert  = $pdo->prepare($queryInsert); //Prepared Statement con la query
                    $stmtyInsert ->execute([$_REQUEST['indice'], $_SESSION['user_id'], $_REQUEST['amount']]);
                }
                $query2 =   'UPDATE accounts SET balance = ? WHERE accounts_id = ?';
                $stmt2 = $pdo->prepare($query2); //Prepared Statement con la query
                $stmt2->execute([$balance, $_REQUEST['accounts_id']]);
                if ($stmt2->rowCount()){ //Si algo ha cambiado
                    echo("Se han comprado acciones satisfactoriamente."); 
                }else{
                    echo("Ha ocurrido un error al comprar acciones"); 
                }
            }else{
                echo("No puedes comprar acciones por un valor superior al dinero que dispones"); 
            }
        }else{
            echo("No se ha comprado ninguna accion."); 
        }
    }
}
function venderAccion(){
    require(ROOT .'code/config.php');
    //Ver Cantidad de acciones disponibles
    $queryUserAccion = 'SELECT * FROM indices_compra where indices_id = ? AND user_id = ?';
    $stmtUserAccion = $pdo->prepare($queryUserAccion); //Prepared Statement con la query
    $stmtUserAccion->execute([$_REQUEST['indice'], $_SESSION['user_id']]);
    if($stmtUserAccion->rowCount()){
        $rowAccion = $stmtUserAccion->fetch();
        if($rowAccion['amount'] >= $_REQUEST['amount']){
            $queryValue = 'SELECT `value` FROM indices where indices_id = ?';
            $stmtValue = $pdo->prepare($queryValue); //Prepared Statement con la query
            $stmtValue->execute([$_REQUEST['indice']]);
            $rowValue = $stmtValue->fetch();
            $valorTrans = $_REQUEST['amount']*$rowValue['value'];
            $total = $rowAccion['amount'] - $_REQUEST['amount'];
            $query2 = 'UPDATE indices_compra SET amount = ? WHERE indices_compra_id = ?';
            $stmt2 = $pdo->prepare($query2); //Prepared Statement con la query
            $stmt2->execute([$total, $rowAccion['indices_compra_id']]);
            //Calcular nuevo balance de la cuenta
            $query = 'SELECT balance FROM accounts WHERE user_id = ? AND accounts_id = ?';
            $stmt = $pdo->prepare($query); //Prepared Statement con la query
            $stmt->execute([$_SESSION['user_id'], $_REQUEST['accounts_id']]);
            $row = $stmt->fetch();
            $balance = $row['balance'] + $valorTrans;
            $query2 =   'UPDATE accounts SET balance = ? WHERE accounts_id = ?';
                $stmt2 = $pdo->prepare($query2); //Prepared Statement con la query
                $stmt2->execute([$balance, $_REQUEST['accounts_id']]);
                if ($stmt2->rowCount()){ //Si algo ha cambiado
                    echo("Se han vendido acciones satisfactoriamente."); 
                }else{
                    echo("Ha ocurrido un error al vender acciones"); 
                }
        }else{
            echo("No dispones de suficientes acciones para realizar esta operacion."); 
        }
        //Ver precio de una accion
    }else{
        echo("No dispones de acciones para este indice."); 
    }
}
?>