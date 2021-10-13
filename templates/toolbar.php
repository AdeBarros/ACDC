<!DOCTYPE php>
<html>
    
<div id="Toolbar" class="toolbar">
        <a class="title">ACDC<a>


<?php

// Connextion à la BDD
$link = mysqli_connect("localhost", "acdcuser", "acdc2021", "acdc");
        
// Test de connextion
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

$matriceid = !empty($_POST['ordre']) ? $_POST['ordre'] : null;

session_start();

if(!empty($_POST["matrix"])){
        $_SESSION["matrice_id"] = $_POST["matrix"];
}

if(empty($_SESSION["matrice_id"])){
    header('Location: ' . dirname($_SERVER["SCRIPT_NAME"]).'/matrix.php'); // Envoi à l'interface de choix de matrice
}

else{
        echo "<a>" . $_SESSION["matrice_id"] . "</a>";
}

// Cas ajout/modif de fichier audio
if(!empty($_FILES["newaudio"])){
        if($_FILES["newaudio"]["name"] != null){
                $path = $_FILES["newaudio"]["name"];
                $sql = "UPDATE matrice SET audio_name = './Audios/$path' WHERE id_mat = " . $_SESSION["matrice_id"];

                if ($link->query($sql) === TRUE) {
                } else {
                        echo "Error: " . $sql . "<br>" . $link->error;
                }
        }
}

mysqli_close($link);

?>

        <input class="close" type="button" onclick="document.location.href='matrix.php'" value="x"/>

</div> 