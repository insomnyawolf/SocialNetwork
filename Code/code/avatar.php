<?php
if(!!!isset($_SESSION["user_id"])){
    header("Location: ./login.php");
}
$imageFileType = strtolower(pathinfo($_FILES["avatar"]["name"],PATHINFO_EXTENSION));
$target_dir = ROOT . "upload/";
$avatarName = basename($_SESSION["user_id"].".".$imageFileType);
$target_file = $target_dir . $avatarName;
$uploadOk = 1;
// Check if image file is a actual image or fake image
if(isset($_REQUEST["submit"])) {
    $check = getimagesize($_FILES["avatar"]["tmp_name"]);
    if($check !== false) {
        //echo("File is an image - " . $check["mime"] . ".");
        $uploadOk = 1;
    } else {
        echo("File is not an image.");
        $uploadOk = 0;
    }
}
// Check file size
/*if($_FILES["avatar"]["size"] > 500000) {
    echo("Sorry, your file is too large.");
    $uploadOk = 0;
}*/
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "jpeg" && $imageFileType != "png"
&& $imageFileType != "gif" ) {
    echo("Sorry, only JPG, JPEG, PNG & GIF files are allowed.\n");
    echo("The image was $imageFileType");
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if($uploadOk == 0) {
    echo("Sorry, your file was not uploaded.");
// if everything is ok, try to upload file
} else {
    $files = glob("$target_dir".$_SESSION['user_id'].".*"); // Will find 2.txt, 2.php, 2.gif

    // Process through each file in the list
    // and output its extension
    if (count($files) > 0){
        foreach ($files as $file){
            unlink($file);
        }
    }
    //echo($target_file);
    $filename = ROOT . 'upload/'.$id;
    foreach (glob($filename.".{jpg,jpeg,png,gif}", GLOB_BRACE) as $filename) {
        unlink($filename);
    }
    $result = move_uploaded_file($_FILES["avatar"]["tmp_name"], $target_file);
    if ($result) {
        echo($target_file);
    } else {
        die("Sorry, there was an error uploading your file.\nError: ".$_FILES["avatar"]["error"]);
    }
}
?>