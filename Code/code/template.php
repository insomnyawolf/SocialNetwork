<?php
function template($path){
?>
<!DOCTYPE html>
<html>
    <?php 
    require_once("./static/html/header.html");
    require_once("./code/helper.php");
    ?>
    <body>
    <!-- <body class="w3-theme-l5"> -->
    <!-- Navbar -->
    <?php require_once("./code/navbar.php");?>
    <script src="./static/js/user.js"></script>
    <!-- Page Container -->
    <div class="w3-container w3-content" style="max-width:1400px;margin-top:80px">    
    <!-- The Grid -->
    <div class="w3-row">
        <!-- Left Column -->
        <div class="w3-col m3">
        <?php
        if(isset($_SESSION["user_id"])){
            require_once("./code/columns/leftColumn.php");
        }
        ?>
        <!-- End Left Column -->
        </div>
        
        <!-- Middle Column -->
        <div class="w3-col m7" id="middle">
            <?php 
                require_once($path);
            ?>
        </div>
        <!-- End Middle Column -->
        
        
        <!-- Right Column -->
        <div class="w3-col m2">
        <?php
        if(isset($_SESSION["user_id"])){
            require_once("./code/columns/rightColumn.php");
        }
        ?>
        <!-- End Right Column -->
    </div>
        
    <!-- End Grid -->
    </div>
    
    <!-- End Page Container -->
    </div>
    <br>

    <!-- Footer -->
    <footer class="w3-container w3-theme-d3 w3-padding-16">
    <h5>Footer</h5>
    </footer>

    <footer class="w3-container w3-theme-d5">
    <!-- <p>Powered by <a href="https://www.w3schools.com/w3css/default.asp" target="_blank">w3.css</a></p> -->
    </footer>
</body>
</html> 
<?php }?>