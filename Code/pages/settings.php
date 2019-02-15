<?php
    require_once("./code/helper.php");
?>
<div>
    <div class="w3-row-padding">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.4.3/cropper.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.4.3/cropper.css" />
        <div class="w3-col m12">
            <div class="w3-card w3-round w3-white">
                <script src="./static/js/tabSwitch.js"></script>
                <div class="tab">
                    <button class="tablinks" onclick="tabSwitch(event, 'userSettings')">Ajustes Generales</button>
                    <button class="tablinks" onclick="tabSwitch(event, 'avatar')">Avatar</button>
                    <button class="tablinks" onclick="tabSwitch(event, 'cuentas')">Cuentas</button>
                    <button class="tablinks" onclick="tabSwitch(event, 'danger')">Privacidad</button>
                    <?php if($_SESSION["isCAT"] == 1){?>
                            <button class="tablinks" onclick="tabSwitch(event, 'QAT')">QAT Settings</button>
                    <?php } ?>
                </div>
            </div>
            <br />
            <!-- User Settings -->
            <div id="userSettings" class="w3-card w3-round w3-white tabcontent">
                <div class="w3-container w3-padding">
                    <h3 class="w3-opacity">Ajustes Generales:</h3>
                    <form action="./code/settings.php" id="myForm" method="post" class="w3-container w3-padding w3-centered">
                        <input name="func" id="func" type="text" class="w3-border w3-padding" value="editUser" hidden/>
                        <h4 class="inline-block w3-padding">Nombre:</h4><input name="nombre" id="nombre" type="text" class="w3-border w3-padding" value=<?php echo('"'.$_SESSION["nombre"].'"');?> /><br /><br />
                        <h4 class="inline-block w3-padding">Apellido:</h4><input name="apellido" id="apellido" type="text" class="w3-border w3-padding" value=<?php echo('"'.$_SESSION["apellido"].'"');?> /><br /><br />
                        <h4 class="inline-block w3-padding">Domicilio:</h4><input name="domicilio" id="domicilio" type="text" class="w3-border w3-padding" value=<?php echo('"'.$_SESSION["domicilio"].'"');?> /><br /><br />
                        <h4 class="inline-block w3-padding">Fecha Nacimiento:</h4><input name="fecha_nac" id="fecha_nac" type="date" class="w3-border w3-padding" value="<?php echo(formatDateSettings($_SESSION["fecha_nac"])); ?>" /><br /><br />
                        <h4 class="inline-block w3-padding">Telefono:</h4><input name="telefono" id="telefono" type="text" class="w3-border w3-padding" value=<?php echo('"'.$_SESSION["telefono"].'"');?> /><br /><br />
                        <h4 class="inline-block w3-padding">Movil:</h4> <input name="movil" id="movil" type="text" class="w3-border w3-padding" value=<?php echo('"'.$_SESSION["movil"].'"');?> /><br /><br />
                        <h4 class="inline-block w3-padding">DNI:</h4><input name="dni" id="dni" type="text" class="w3-border w3-padding" value=<?php echo('"'.$_SESSION["dni"].'"');?> /><br /><br />
                        <div class="full w3-padding">
                            <button type="submit" id="submitFormData" class="w3-button w3-theme"><i class="fas fa-user-edit"></i> &nbsp;Enviar</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- User Settings End -->
            <!--Image crop -->
            <div id="avatar" class="w3-card w3-round w3-white tabcontent">
                <div class="w3-container w3-padding">
                    <h3 class="w3-opacity">Avatar:</h3>
                    <?php require_once("./pages/settings/avatar.php");?>
                </div>
            </div>
            <!--Image crop end-->
            <!-- Cuentas -->
            <div id="cuentas" class="w3-card w3-round w3-white tabcontent">
                <div class="w3-container w3-padding" id="addAccount">
                    <h3 class="w3-opacity">Añadir cuenta:</h3>
                    <form method="post" class="w3-container w3-padding w3-centered" onsubmit="event.preventDefault();addAcount();">
                        <button type="submit" class="w3-button w3-theme"> &nbsp;Añadir Cuenta</button>
                    </form>
                </div>
                <div class="w3-container w3-padding">
                    <h3 class="w3-opacity">Tus cuentas: 
                        <button class="w3-button w3-theme" onclick="refreshAcounts();">Refresh</button>
                        <button class="w3-button w3-theme" onclick="HideAccounts();">Hide</button>
                    </h3>
                    <div id="tusCuentas">
                    </div>
                </div>
            </div>
            <!-- Cuentas End -->
            <!-- DangerZone -->
            <div id="danger" class="w3-card w3-round w3-white tabcontent">
                <div class="w3-container w3-padding">
                    <h3 class="w3-opacity">Desactivar cuenta:</h3>
                    <form action="./code/settings.php" id="DeactivateForm" method="post" class="w3-container w3-padding w3-centered">
                        <h6>Por favor, introduzca su contraseña antes de continuar</h6>
                        <input name="func" id="func" type="text" class="w3-border w3-padding" value="unsuscribe" hidden/>
                        <h4 class="inline-block w3-padding">Contraseña:</h4><input name="password" id="password" type="password" class="w3-border w3-padding"/><br /><br />
                        <div class="full w3-padding">
                            <button type="submit" id="submitFormDataDeactivate" class="w3-button isa_error"><i class="fas fa-heart-broken"></i> &nbsp;Desactivar</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- DangerZone End -->
            <!-- QAT -->
            <?php if($_SESSION["isCAT"]){?>
                <div id="QAT" class="w3-card w3-round w3-white tabcontent">
                <div class="w3-container w3-padding">
                    <h3 class="w3-opacity">QAT:</h3>
                    <script src="./static/js/qat.js"></script>
                    <div id="editUSER">
                        <form id="SearchData" method="post" class="w3-container w3-padding w3-centered" onsubmit="event.preventDefault();loadUSER();">
                            <h6>Editar Usuario</h6>
                            <h4 class="inline-block w3-padding">ID:</h4><h4 class="inline-block w3-border quarter">&nbsp;</h4><br /><br />
                            <h4 class="inline-block w3-padding">Username:</h4><input name="EditUser" id="EditUser" type="text" class="w3-border w3-padding"/><br /><br />
                        </form>
                    </div>
                </div>
            </div>  
            <?php }?>
            <!-- QAT End -->
        </div>
    </div>
<!--Fin Columna Enmedio-->
</div>