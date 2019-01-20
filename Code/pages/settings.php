<?php
    require_once("./code/helper.php");
?>
<div>
    <div class="w3-row-padding">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.4.3/cropper.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.4.3/cropper.css" />
        <div class="w3-col m12">
            <div class="w3-card w3-round w3-white">
                <!--Image crop Start-->
                <div class="w3-container w3-padding">
                    <h3 class="w3-opacity">Avatar:</h3>
                    <?php require_once("./pages/settings/avatar.php");?>
                </div>
                
                <!--Image crop end-->
            </div>
            <br />
            <div class="w3-card w3-round w3-white">
                <div class="w3-container w3-padding">
                    <h3 class="w3-opacity">Ajustes Generales</h3>
                    <form action="./code/settings.php" id="myForm" method="post" class="w3-container w3-padding w3-centered">
                        <h4 class="inline-block w3-padding">Nombre:</h4><input name="nombre" id="nombre" type="text" class="w3-border w3-padding" value=<?php echo('"'.$_SESSION["nombre"].'"');?> /><br /><br />
                        <h4 class="inline-block w3-padding">Apellido:</h4><input name="apellido" id="apellido" type="text" class="w3-border w3-padding" value=<?php echo('"'.$_SESSION["apellido"].'"');?> /><br /><br />
                        <h4 class="inline-block w3-padding">Domicilio:</h4><input name="domicilio" id="domicilio" type="text" class="w3-border w3-padding" value=<?php echo('"'.$_SESSION["domicilio"].'"');?> /><br /><br />
                        <h4 class="inline-block w3-padding">Fecha Nacimiento:</h4><input name="fecha_nac" id="fecha_nac" type="date" class="w3-border w3-padding" value="<?php echo(formatDateSettings($_SESSION["fecha_nac"])); ?>" /><br /><br />
                        <h4 class="inline-block w3-padding">Telefono:</h4><input name="telefono" id="telefono" type="text" class="w3-border w3-padding" value=<?php echo('"'.$_SESSION["telefono"].'"');?> /><br /><br />
                        <h4 class="inline-block w3-padding">Movil:</h4> <input name="movil" id="movil" type="text" class="w3-border w3-padding" value=<?php echo('"'.$_SESSION["movil"].'"');?> /><br /><br />
                        <h4 class="inline-block w3-padding">DNI:</h4><input name="dni" id="dni" type="text" class="w3-border w3-padding" value=<?php echo('"'.$_SESSION["dni"].'"');?> /><br /><br />
                        <div class="full w3-padding">
                            <button type="submit" id="submitFormData" class="w3-button w3-theme"><i class="fa fa-pencil"></i> &nbsp;Enviar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<!--Fin Columna Enmedio-->
</div>