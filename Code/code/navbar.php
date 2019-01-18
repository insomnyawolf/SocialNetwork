<div class="w3-top">
    <div class="w3-bar w3-theme-d2 w3-left-align w3-large">
        <a href="./" class="w3-bar-item w3-button w3-padding-large w3-theme-d4"><i class="fa fa-home w3-margin-right"></i>Logo</a>
        <?php 
            //Hide part of the navBar if not logged in
            if(isset($_SESSION["user_id"])){ 
        ?>
        <a class="w3-bar-item w3-button w3-hide-medium w3-hide-large w3-right w3-padding-large w3-hover-white w3-large w3-theme-d2"
            href="javascript:void(0);" onclick="openNav()"><i class="fa fa-bars"></i></a>
        <!--
        <a href="./" class="w3-bar-item w3-button w3-hide-small w3-padding-large w3-hover-white" title="News"><i
                class="fa fa-globe"></i></a>
        <a href="#" class="w3-bar-item w3-button w3-hide-small w3-padding-large w3-hover-white" title="Messages"><i
                class="fa fa-envelope"></i></a>
        -->
        <div class="w3-dropdown-hover w3-hide-small w3-right fixed">
            <button class="w3-button w3-padding-large" title="Notifications"><i class="fa fa-user"></i><span class="w3-badge w3-right w3-small w3-green"></span></button>
            <div class="w3-dropdown-content w3-card-4 w3-bar-block" style="width:150px; margin-left: -10px;">
                <a href="./settings.php" class="w3-bar-item w3-button">Settings</a>
                <a href="./logout.php" class="w3-bar-item w3-button">Logout</a>
            </div>
        </div>
        <!--<a href="#" class="   w3-hover-white" title="My Account">
            <img src="/w3images/avatar2.png" class="w3-circle" style="height:23px;width:23px" alt="Avatar">
        </a>-->
        <?php 
            } 
        ?>
    </div>
</div>

<!-- Navbar on small screens -->
<div id="navDemo" class="w3-bar-block w3-theme-d2 w3-hide w3-hide-large w3-hide-medium w3-large">
    <a href="#" class="w3-bar-item w3-button w3-padding-large"></a>
    <a href="#" class="w3-bar-item w3-button w3-padding-large"></a>
    <?php 
        //Hide part of the navBar if not logged in
        if(isset($_SESSION["user_id"])){ 
    ?>
    <a href="./" class="w3-bar-item w3-button w3-padding-large">Main</a>
    <a href="./settings.php" class="w3-bar-item w3-button w3-padding-large">Settings</a>
    <a href="./logout.php" class="w3-bar-item w3-button w3-padding-large">Logout</a>
    <?php 
        } 
    ?>
</div>