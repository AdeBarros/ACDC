<!DOCTYPE php>
<html>
<head>
    <title>ACDC Retranscription tool</title>
    <link rel="stylesheet" href="mystyle.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="functions.js"></script>
</head>
<body>

    <?php
        $link = mysqli_connect("localhost", "acdcuser", "acdc2021", "acdc");
     
        // Test de connextion
        if($link === false){
            die("ERROR: Could not connect. " . mysqli_connect_error());
        }

        $sql = "SELECT audio_name FROM matrice WHERE id_mat = " . $_SESSION["matrice_id"]. ";";
        
        $result = $mysqli->query($sql);

        if ($result != null) {
            while($row = $result->fetch_assoc()) {
                if(!empty($row["audio_name"])){
                    $pathtoaudio = $row["audio_name"];

                    echo "<audio id='playingaudio' ontimeupdate='trackingLine()' controls>";
                    echo    "<source src='" . $pathtoaudio . "' type='audio/mpeg'>";
                    echo    "Your browser does not support the audio element.";
                    echo '</audio>';
                }
            }
        }

    ?>


</body>