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

        // Connextion à la BDD
        $link = mysqli_connect("localhost", "acdcuser", "acdc2021", "acdc");
        
        // Test de connextion
        if($link === false){
            die("ERROR: Could not connect. " . mysqli_connect_error());
        }

        // Création de la 1e ligne
        $list[] = array(
            "Temps",
            "Init-agent",
            "Init diff-suscite",
            "Long",
            "Force",
            "Decision",
            "Id. Event",
            "Texte Event",
            "Q",
            "I",
            "C",
            "RPP",
            "RNP",
            "RPT",
            "RNT",
            "Coupe",
            "Q",
            "I",
            "C",
            "RPP",
            "RNP",
            "RPT",
            "RNT",
            "Coupe",
        );
        
        // Creation du fichier CSV
        $fp = fopen("../data.csv", 'w');
        //Write the header
        fputcsv($fp, array_keys($list));
        //Write fields
        foreach ($list as $fields) {
            fputcsv($fp, $fields);
        }


        // Pour chaque échange
        
        $sql = "SELECT * FROM matrice 
        LEFT JOIN echange ON matrice.id_mat = echange.id_mat
        WHERE matrice.id_mat = " . $_POST["id"] . " ORDER BY temp_ech ;";

        $result = $link->query($sql);     

        // Si la matrice est non nulle
        if ($result->num_rows > 0) {
        
            // Pour chaque échange
            while($row = $result->fetch_assoc()) {

                
                echo implode(',',$row);

                // Si l'échange existe
                if($row['id_ech'] != null){

                    $handle = fopen('../data.csv',"a");
                    $line = array(
                        $row["temp_ech"],
                        "P" . $row["agent_init"],
                        $row["diff_init"],
                        $row["long"],
                        $row["force_ech"],
                        $row["decision"],
                        "",
                        "",
                    );
                    
                    $id = $row["id_ech"];
                    $i = 1;
                    $inters = ["questionne","informe","controle","positif2","negatif2","positif","negatif","coupure"];

                    // Pour chaque participant
                    while($i <= 2){

                        // Pour chaque interaction
                        foreach($inters as $inter){
                            if($inter == 'coupure'){
                                $sql2="SELECT COUNT(*) as NbInter 
                                FROM interaction 
                                JOIN echange ON echange.id_ech = interaction.id_ech
                                WHERE echange.id_ech = $id 
                                AND (( echange.agent_init != $i AND interaction.temp_inter % 2 = 0 ) OR ( echange.agent_init = $i AND interaction.temp_inter % 2 != 0 ))
                                AND interaction.type_inter = '$inter'
                                ORDER BY temp_ech ;";
                            }
                            else{
                                $sql2="SELECT COUNT(*) as NbInter 
                                FROM interaction 
                                JOIN echange ON echange.id_ech = interaction.id_ech
                                WHERE echange.id_ech = $id 
                                AND (( echange.agent_init = $i AND interaction.temp_inter % 2 = 0 ) OR ( echange.agent_init != $i AND interaction.temp_inter % 2 != 0 ))
                                AND interaction.type_inter = '$inter'
                                ORDER BY temp_ech ;";
                            }
                            
                            $result2 = $link->query($sql2);
                        
                            while($row2 = $result2->fetch_assoc()){

                                array_push($line, $row2['NbInter']);

                            }
                        }

                        $i += 1;
                    }

                    // On écrit dans le CSV
                    fputcsv($handle, $line);

                    fclose($handle);
                }
            }
        }
    

        fclose($fp);
        
        echo "<script>alert('Vos données ont été exportées')</script>";
        
        $link->close();

        header('Location: main.php');
        exit();
    ?>

</body>