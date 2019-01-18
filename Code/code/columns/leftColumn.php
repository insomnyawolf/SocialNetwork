<!-- Profile -->
<div class="w3-card w3-round w3-white">
    <div class="w3-container">
        <h4 class="w3-center">
            <?php 
                echo($_SESSION["user"]); 
                if($_SESSION["isCAT"]==1){ ?>
                    <i class="fa fa-check fa-fw w3-margin-right w3-text-theme"></i>
                <?php } ?>
        </h4>
        <p class="w3-center">
            <img src=<?php echo('"'.getAvatar($_SESSION["user_id"]).'"');?> class="w3-circle" style="height:106px;width:106px" alt="Avatar" id="av">
        </p>
        <hr>
        <!--<p><i class="fa fa-pencil fa-fw w3-margin-right w3-text-theme"></i> Designer, UI</p>-->
        <!-- Accordion -->
        <div class="w3-card w3-round">
            <div class="w3-white">
                <button onclick="showToggle('Phone')" class="w3-button w3-block w3-theme-l1 w3-left-align"><i class="fa fa-circle-o-notch fa-fw w3-margin-right"></i>Datos</button>
                <div id="Phone" class="w3-hide w3-container">
                    <p><i class="fa fa-address-card fa-fw w3-margin-right w3-text-theme"></i><?php echo($_SESSION["nombre"]);?></p>
                    <p><i class="fa fa-address-card fa-fw w3-margin-right w3-text-theme"></i><?php echo($_SESSION["apellido"]);?></p>
                    <p><i class="fa fa-home fa-fw w3-margin-right w3-text-theme"></i><?php echo($_SESSION["domicilio"]);?></p>
                    <p><i class="fa fa-birthday-cake fa-fw w3-margin-right w3-text-theme"></i><?php echo($_SESSION["fecha_nac"]);?></p>
                    <p><i class="fa fa-phone w3-margin-right w3-text-theme"></i><?php echo($_SESSION["telefono"]);?></p>
                    <p><i class="fa fa-mobile w3-margin-right w3-text-theme"></i><?php echo($_SESSION["movil"]);?></p>
                </div>
            </div>      
        </div>
        <br>            
    </div>
</div>
<br>
        