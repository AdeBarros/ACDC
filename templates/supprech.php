<!DOCTYPE php>
<?php

    // Connextion à la BDD
    $link = mysqli_connect("localhost", "acdcuser", "acdc2021", "acdc");
     
    // Test de connextion
    if($link === false){
        die("ERROR: Could not connect. " . mysqli_connect_error());
    }

    // Si l'id reçu existe
    if(!empty($_POST['id_ech'])){

        // On supprime l'échange dans la BDD
        $sql = "DELETE FROM `echange` WHERE id_ech = ". $_POST['id_ech'];
        if(mysqli_query($link, $sql)){
            echo "Records added successfully.";
        } else{
            echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
        }

    }

    mysqli_close($link);

    echo '<script src="function.js">  datavisRefresh(); </script>';
    header('Location: ' . dirname($_SERVER["SCRIPT_NAME"]).'/main.php'); // Retour à l'interface
    exit();

?>