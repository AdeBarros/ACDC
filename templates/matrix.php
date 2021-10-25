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

        // Cas Nouvelle Matrice
        if(!empty($_POST["newmatrix"])){
            $matrixlabel = $_POST["newmatrix"];
            $sql = "INSERT INTO matrice (`label_mat`, `audio_name`) VALUES ('$matrixlabel', '');";

            if ($link->query($sql) === TRUE) {
                echo "New record created successfully";
              } else {
                echo "Error: " . $sql . "<br>" . $link->error;
              }
        }

        // Cas d'une matrice importée
        if(!empty($_FILES["importedmatrix"])){

            // Cas du SQL
            if($_FILES["importedmastrix"]["type"] == "sql"){
                $sql = file_get_contents($_FILES["importedmatrix"]["tmp_name"]);
    
                if ($link->query($sql) === TRUE) {
                    echo "New record created successfully";
                  } else {
                    echo "Error: " . $sql . "<br>" . $link->error;
                  }
            }

            // TODO : Autres cas
        }
        

        
          $link->close();
    ?>
    
    <div class="matrix">
        <h1 style="color: white">Bienvenue sur l'outil de Retranscription ACDC</h1>
        <h4 style="color: white ; margin-top: 5vh;" >Afin de continuer, veuillez sélectionner une matrice sur laquelle vous voulez travailler :</h4>
        <br/>
        <div class="mainMatrix">
            <div class="matrixForm"> 
                <form action="main.php" method="post" enctype="multipart/form-data"> 
                    <h3>Ouvrir une matrice existante</h3>
                    <label for="matrice">Matrice :</label>
                    <select name="matrix" id="matrice" required>
                        <option value="">Veuillez Choisir une matrice</option>

                        <?php

                            // Connexion à la BDD
                            $mysqli = new mysqli("localhost", "acdcuser", "acdc2021", "acdc");
                            // Test de connexion
                            if($mysqli->connect_error) {
                                exit('Could not connect');
                            }

                            // Message SQL de récupération des données des échanges associées à leurs interactions
                            $sql = "SELECT * FROM matrice";
                            $result = $mysqli->query($sql);

                            # Si il y a des donées
                            if ($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                                    echo "<option value=" . $row["id_mat"] . " id='" . $row["id_mat"] . "' label=" . $row["label_mat"] . "  >" . $row["label_mat"] . "</option>";
                                }
                            }

                        ?>

                    </select>
                    <br/>
                    <br/>
                    <label for="newaudio" class="matrixlabel">Importer un fichier Audio (optionnel) :</label>
                    <input id="newaudio" name="newaudio" type="file" accept=".mp3,.m4a" class="matriximport" />
                    <br/>
                    <br/>
                    <button type="submit" class="matrixsubmit" >Ouvrir</button>
                </form>
            </div>
            <div class="matrixForm">
                <form action="matrix.php" method="POST">
                    <h3>Créer une nouvelle matrice :</h3>
                    <label for="newmatrix">Nom de la nouvelle Matrice :</label>
                    <input placeholder="Nouvelle Matrice" id="newMatrix" name="newmatrix" required/> 
                    <br/>
                    <br/>
                    <button type="submit" class="matrixsubmit" >Créer</button>

                </form>
            </div>
            <div class="matrixForm">
                <form action="matrix.php" method="POST" enctype="multipart/form-data">
                    <h3>Importer une matrice :</h3>
                    <label for="importedmatrix" class="matrixlabel">Nouvelle Matrice :</label>
                    <input type=file accept=".sql" name="importedmatrix" id="importedmatrix" class="matriximport" required/>
                    <br/>
                    <br/>
                    <button type=submit class="matrixsubmit" >Importer</button> 

                </form>
            </div>
        </div>
    </div>



</body>