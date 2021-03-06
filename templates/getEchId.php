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
    WHERE matrice.id_mat = " . $_SESSION["matrice_id"] . " ORDER BY temp_ech ;";
    $result = $mysqli->query($sql);


    $i = -1;

    # Si il y a des donées
    if ($result->num_rows > 0) {
      // Ecriture d'une case pour ajouter un nouvel échange
      echo "<div id='EchSavesPlus' class='echsaves' type='button' onclick='location.reload()'><label for='EchSavesPlus' data-toggle='tooltip' data-placement='bottom' title='Ajouter un échange' ><img class='plus' id='plus' src='Images/plus.png' /></label></div>";
      while($row = $result->fetch_assoc()) {

        # Récupération des échanges
        if($row['id_ech'] != $i && $row['id_ech'] != null){

          $i = $row['id_ech'];
          // Ecriture d'une case pour chaque échange
          echo "<div type='button' class='echsaves' id='EchSaves" . $i . "' tem='" . $row['temp_ech'] . "' agini = '" . $row['agent_init'] . "' dini = '" . $row['diff_init'] . "' long='" . $row['long'] . "' forc='" . $row['force_ech'] . "' deci='" . $row['decision'] . "' onclick='importDataEch(this)'>";
          echo "<a>" . $row["temp_ech"] . "</a>";
          

          # Récupération des échanges

          $sql2 = "SELECT * FROM interaction 
          WHERE id_ech = $i ORDER BY temp_inter ;";

          $result2 = $mysqli->query($sql2);

          if ($result2->num_rows > 0) {

            while($row2 = $result2->fetch_assoc()) {
              if(!empty($row2['id_inter']))
              
              # Ecriture d'un petit carré bleu pour chaque interaction
              echo "<div class='intersaves' id='InterSaves" . $row2['id_inter'] . "' tem='" . $row2['temp_inter'] . "' typ='" . $row2['type_inter'] . "' ></div>";

            }
          }

          # Récupération de l'évènement
          $sql3 = "SELECT id_evt, desc_evt FROM evenement WHERE id_ech = $i ;";

          $result3 = $mysqli->query($sql3);

          if($result3->num_rows > 0) {
            while($row3 = $result3->fetch_assoc()) {
              if(!empty($row3["id_evt"])){
                # Ecriture d'un petit carré bleu pour l'évènement
                echo "<div class='evtsaves' id='EventSaves" . $row3['id_evt'] . "' desc='" . $row3['desc_evt'] . "' ></div>";
              }
            }
          }

          echo "<div class='echplusboxes'>";
          echo "<form onsubmit='event.preventDefault(); confSubmit(this);' action='supprech.php' method='POST'><input name='id_ech' value='$i' type='hidden'/><input type='image' src='Images/croix.png' class='delete'></input></form>";
          echo "<form onSubmit='event.preventDefault(); changeTS(this);' action='modify.php' method='POST'><input name='id_ech' value='$i' type='hidden'/><input id='newts' name='newTS' value='". $row['temp_ech'] ."' type='hidden'/><input id='newAI' name='newAI' value='". $row['agent_init'] ."' type='hidden'/><input type='image' src='Images/pen.png' class='modify'/></input></form>";
          echo "</div>";
          
          if(!empty($row["force_ech"])){
            if($row['agent_init'] == 1){
              echo "<div class='echimgboxes'>";
              echo "<img src='Images/" . $row['force_ech'] . ".png' class='imgprev'/>";
              echo "<img src='Images/" . $row['decision'] . ".png' class='imgprev'/>";
              echo "</div>";
            }
            else{
              echo "<div class='echimgboxes'>";
              echo "<img src='Images/" . $row['decision'] . "flip.png' class='imgprev'/>";
              echo "<img src='Images/" . $row['force_ech'] . ".png' class='imgprev'/>";
              echo "</div>";

            }
          }
          else{
            echo "<div class='echimgboxes'>";
            echo "<img src='Images/Evenement.png' class='imgprev'/>";
            echo "<a>Event<a/>";
            echo "</div>";
          }

          echo "</div>";
        }
      }
    }
?>
