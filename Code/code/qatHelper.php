<?php
session_start();
require_once("./helper.php");
if(isset($_SESSION["user_id"]) && ($_SESSION["isCAT"])){
    if($_SESSION["isCAT"]==1){ 
        if($_SERVER['REQUEST_METHOD'] == 'POST' || $_SERVER['REQUEST_METHOD'] == 'GET' ){
            if($_REQUEST['func'] == "loadUser"){
                getuser();
            }else if($_REQUEST['func'] == "editUser"){
                editUser();
            }else{
                echo("You should not be here.". $_REQUEST);
            }
        }else{
            echo("You should not be here.". $_REQUEST);
        }
    }else{
        echo("You should not be here.". $_REQUEST);
    }
}
function isChecked($val){
    if($val == 1){
        return "checked";
    }
    return "";
}
function editUser(){
    require(ROOT .'code/config.php');
    $date = strtotime($_REQUEST["EditFecha_nac"]);
    $sql = "UPDATE users SET user=?, nombre=?, apellido=?, domicilio=?, fecha_nac=?, telefono=?, movil=?, dni=?, isActive=?, isCAT=? WHERE user_id=?";
    $stmt= $pdo->prepare($sql); //prepared statement para actualizar el usuario
    $stmt->execute([$_REQUEST["EditUser"], 
                    $_REQUEST["EditNombre"], 
                    $_REQUEST["EditApellido"], 
                    $_REQUEST["EditDomicilio"], 
                    $date, 
                    $_REQUEST["EditTelefono"],
                    $_REQUEST["EditMovil"],
                    $_REQUEST["EditDNI"], 
                    $_REQUEST["EditIsActive"],
                    $_REQUEST["EditIsCAT"],
                    $_REQUEST["EditUserID"]]
                    );
    if ($stmt->rowCount()){ //Para ver cuantas lineas se han modificado ?>
    <h3>Sucess!</h3>
    <form action="./code/settings.php" id="SearchData" method="post" class="w3-container w3-padding w3-centered" onsubmit="event.preventDefault();loadUSER();">
        <h6>Editar Usuario</h6>
        <h4 class="inline-block w3-padding">ID:</h4><h4 class="inline-block w3-border quarter">&nbsp;</h4><br /><br />
        <h4 class="inline-block w3-padding">Username:</h4><input name="EditUser" id="EditUser" type="text" class="w3-border w3-padding"/><br /><br />
    </form>
    <?php }else{ ?>
            <h3>Error D:</h3>
    <?php }
    
}
function getuser(){
    require(ROOT .'code/config.php');
    $query =  "SELECT *
    FROM  users 
    WHERE user = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$_REQUEST['user']]);
    //$result = $pdo->query($query) or die($con->error);
    while ($row = $stmt->fetch()){
    //`user_id`, `user`, `passwd`, `avatarID`, `nombre`, `apellido`, `domicilio`, `fecha_nac`, `telefono`, `movil`, `dni`, `isCAT`, `isActive`
    ?>
    <form id="LoadedData" method="post" class="w3-container w3-padding w3-centered" onsubmit="event.preventDefault();editUSER();">
        <h6>Editar Usuario</h6>
        <h4 class="inline-block w3-padding">ID:</h4><input name="EditUserID" id="EditUserID" type="text" class="w3-border w3-padding" value=<?php echo($row["user_id"]);?>  readonly /><br /><br />
        <h4 class="inline-block w3-padding">Username:</h4><input name="EditUser" id="EditUser" type="text" class="w3-border w3-padding" value=<?php echo('"'.$row["user"].'"');?> /><br /><br />
        <h4 class="inline-block w3-padding">Nombre:</h4><input name="EditNombre" id="EditNombre" type="text" class="w3-border w3-padding" value=<?php echo('"'.$row["nombre"].'"');?> /><br /><br />
        <h4 class="inline-block w3-padding">Apellido:</h4><input name="EditApellido" id="EditApellido" type="text" class="w3-border w3-padding" value=<?php echo('"'.$row["apellido"].'"');?> /><br /><br />
        <h4 class="inline-block w3-padding">Domicilio:</h4><input name="EditDomicilio" id="EditDomicilio" type="text" class="w3-border w3-padding" value=<?php echo('"'.$row["domicilio"].'"');?> /><br /><br />
        <h4 class="inline-block w3-padding">Fecha Nacimiento:</h4><input name="EditFecha_nac" id="EditFecha_nac" type="date" class="w3-border w3-padding" value="<?php echo(formatDateSettings($row["fecha_nac"])); ?>" /><br /><br />
        <h4 class="inline-block w3-padding">Telefono:</h4><input name="EditTelefono" id="EditTelefono" type="text" class="w3-border w3-padding" value=<?php echo('"'.$row["telefono"].'"');?> /><br /><br />
        <h4 class="inline-block w3-padding">Movil:</h4> <input name="EditMovil" id="EditMovil" type="text" class="w3-border w3-padding" value=<?php echo('"'.$row["movil"].'"');?> /><br /><br />
        <h4 class="inline-block w3-padding">DNI:</h4><input name="EditDNI" id="EditDNI" type="text" class="w3-border w3-padding" value=<?php echo('"'.$row["dni"].'"');?> /><br /><br />
        <h4 class="inline-block w3-padding">Is Active:</h4><input name="EditIsActive" id="EditIsActive" type="checkbox" class="w3-border w3-padding" <?php echo(isChecked($row["isActive"])) ?> /><br /><br />
        <h4 class="inline-block w3-padding">Is CAT:</h4><input name="EditIsCAT" id="EditIsCAT" type="checkbox" class="w3-border w3-padding" <?php echo(isChecked($row["isCAT"])) ?> /><br /><br />
        <div class="full w3-padding">
            <button type="submit" id="submitFormData" class="w3-button isa_error"><i class="fa fa-pencil"></i> &nbsp;Confirmar Cambios</button>
        </div>
    </form>
<?php }
    } ?>