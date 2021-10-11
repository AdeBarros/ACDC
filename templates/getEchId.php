<!DOCTYPE php>
<?php

    // Connexion à la BDD
    $mysqli = new mysqli("localhost", "acdcuser", "acdc2021", "acdc");
    // Test de connexion
    if($mysqli->connect_error) {
        exit('Could not connect');
    }

    // Message SQL de récupération des données des échanges associées à leurs interactions
    $sql = "SELECT * FROM matrice 
    LEFT JOIN echange ON matrice.id_mat = echange.id_mat
    LEFT JOIN interaction ON echange.id_ech = interaction.id_ech 
    WHERE matrice.id_mat = " . $_SESSION["matrice_id"] . " ORDER BY temp_ech ;";
    $result = $mysqli->query($sql);


    $i = -1;
    $j = 0;

    # Si il y a des donées
    if ($result->num_rows > 0) {
      // Ecriture d'une case pour ajouter un nouvel échange
      echo "<div id='EchSavesPlus' class='echsaves' type='button' onclick='location.reload()' value=><label for='EchSavesPlus' data-toggle='tooltip' data-placement='bottom' title='Ajouter un échange' ><img class='plus' id='plus' src='Images/plus.png' /></label>";
      while($row = $result->fetch_assoc()) {

        # Récupération des échanges
        if($row['id_ech'] != $i and $row['id_ech'] != null){
            $i = $row['id_ech'];
            // Ecriture d'une case pour chaque échange
            echo "</div><div type='button' class='echsaves' id='EchSaves" . $i . "' tem='" . $row['temp_ech'] . "' agini = '" . $row['agent_init'] . "' dini = '" . $row['diff_init'] . "' long='" . $row['long'] . "' forc='" . $row['force_ech'] . "' deci='" . $row['decision'] . "' onclick='importDataEch(this)'>" . $row["temp_ech"];
          }

        # Récupération des échanges
        if($row['id_inter'] != null){
          # Ecriture d'un petit carré bleu pour chaque interaction
          echo "<div class='intersaves' id='InterSaves" . $j . "' tem='" . $row['temp_inter'] . "' typ='" . $row['type_inter'] . "' ></div>";
        }

        $j += 1;
      }
      echo "</div>";
    }
?>
