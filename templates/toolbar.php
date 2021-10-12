<!DOCTYPE php>
<html>
    
<div id="Toolbar" class="toolbar">
        <a class="title">ACDC<a>


<?php

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

?>

        <input class="close" type="button" onclick="document.location.href='matrix.php'" value="x"/>

</div> 