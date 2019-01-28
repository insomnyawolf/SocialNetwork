<?php
if(isset($_SESSION["user_id"]) && $_SESSION["isCAT"])){
    if($_SESSION["isCAT"]==1){ 
        if($_SERVER['REQUEST_METHOD'] == 'POST'){

        }
    }
    header("Location: ./index.php");
}
function getuser(){
    $query =  "SELECT *
    FROM  users 
    WHERE user = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$username, $password]);
    //$result = $pdo->query($query) or die($con->error);
    while ($row = $stmt->fetch()){
    //`user_id`, `user`, `passwd`, `avatarID`, `nombre`, `apellido`, `domicilio`, `fecha_nac`, `telefono`, `movil`, `dni`, `isCAT`, `isActive`
    ?>
        <h6>Editar Usuario</h6>
        <h4 class="inline-block w3-padding">ID:</h4><h4 class="inline-block w3-border quarter" id="EditUserID"><?php echo('"'.$row["user_id"].'"');?> </h4><br /><br />
        <h4 class="inline-block w3-padding">Username:</h4><input name="EditUser" id="EditUser" type="text" class="w3-border w3-padding" value=<?php echo('"'.$row["user"].'"');?> /><br /><br />
        <h4 class="inline-block w3-padding">Nombre:</h4><input name="EditNombre" id="EditNombre" type="text" class="w3-border w3-padding" value=<?php echo('"'.$row["nombre"].'"');?> /><br /><br />
        <h4 class="inline-block w3-padding">Apellido:</h4><input name="EditApellido" id="EditApellido" type="text" class="w3-border w3-padding" value=<?php echo('"'.$row["apellido"].'"');?> /><br /><br />
        <h4 class="inline-block w3-padding">Domicilio:</h4><input name="EditDomicilio" id="EditDomicilio" type="text" class="w3-border w3-padding" value=<?php echo('"'.$row["domicilio"].'"');?> /><br /><br />
        <h4 class="inline-block w3-padding">Fecha Nacimiento:</h4><input name="EditFecha_nac" id="EditFecha_nac" type="date" class="w3-border w3-padding" value="<?php echo(formatDateSettings($row["fecha_nac"])); ?>" /><br /><br />
        <h4 class="inline-block w3-padding">Telefono:</h4><input name="EditTelefono" id="EditTelefono" type="text" class="w3-border w3-padding" value=<?php echo('"'.$row["telefono"].'"');?> /><br /><br />
        <h4 class="inline-block w3-padding">Movil:</h4> <input name="EditMovil" id="EditMovil" type="text" class="w3-border w3-padding" value=<?php echo('"'.$row["movil"].'"');?> /><br /><br />
        <h4 class="inline-block w3-padding">DNI:</h4><input name="EditDNI" id="EditDNI" type="text" class="w3-border w3-padding" value=<?php echo('"'.$row["dni"].'"');?> /><br /><br />
        <h4 class="inline-block w3-padding">Is Active:</h4><input name="EditIsActive" id="EditIsActive" type="checkbox" class="w3-border w3-padding" <?php echo(isActive($row["isActive"])) ?> /><br /><br />
        <div class="full w3-padding">
            <button type="submit" id="submitFormData" class="w3-button isa_error"><i class="fa fa-pencil"></i> &nbsp;Confirmar Cambios</button>
        </div>
<?php 
} 
function isActive($val){
    if($val == 1){
        return "checked";
    }
    return "";
}
?>