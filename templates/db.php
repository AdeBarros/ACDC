<!DOCTYPE php>
<?php

    // ALTER TABLE tablename AUTO_INCREMENT = 1 -> ca aide tjrs

    // Connextion à la BDD
    $link = mysqli_connect("localhost", "acdcuser", "acdc2021", "acdc");
     
    // Test de connextion
    if($link === false){
        die("ERROR: Could not connect. " . mysqli_connect_error());
    }
    
    // Initialisation de toutes les variables

    $force = null;
    $decision = null;
    $initiateur = null;
    $diffini = null;
    $ordre = null;
    $instruction = null;
    $proposition = null;
    $nonverbal = null;
    $soliloque = null;
    $commentaire = null;
    $acceptation = null;
    $accord = null;
    $autorisation = null;
    $refus = null;
    $concession = null;
    $indetermine = null;
    $longueur = null;
    $timestamp = null;
    $p1 = null;
    $p2 = null;
    $di = null;

    // Null si vide, true si seclectionné

    $ordre = !empty($_POST['ordre']) ? $_POST['ordre'] : null;
    $instruction = !empty($_POST['instruction']) ? $_POST['instruction'] : null;
    $proposition = !empty($_POST['proposition']) ? $_POST['proposition'] : null;
    $nonverbal = !empty($_POST['nonverbal']) ? $_POST['nonverbal'] : null;
    $soliloque = !empty($_POST['soliloque']) ? $_POST['soliloque'] : null;
    $commentaire = !empty($_POST['commentaire']) ? $_POST['commentaire'] : null;
    $acceptation = !empty($_POST['acceptation']) ? $_POST['acceptation'] : null;
    $accord = !empty($_POST['accord']) ? $_POST['accord'] : null;
    $autorisation = !empty($_POST['autorisation']) ? $_POST['autorisation'] : null;
    $refus = !empty($_POST['refus']) ? $_POST['refus'] : null;
    $concession = !empty($_POST['concession']) ? $_POST['concession'] : null;
    $indetermine = !empty($_POST['indetermine']) ? $_POST['indetermine'] : null;
    $longueur = (int)$_POST['Longueur'];
    $timestamp = $_POST['timestamp'];
    $p1 = !empty($_POST['participant1']) ? $_POST['participant1'] : null;
    $p2 = !empty($_POST['participant2']) ? $_POST['participant2'] : null;
    $di = !empty($_POST['diffini']) ? $_POST['diffini'] : null;


    // Sélection de la matrice
    if(!empty($_POST["matrice_id"])){
        $matrice = $_POST["matrice_id"];
    }
    else{
        header('Location: ' . dirname($_SERVER["SCRIPT_NAME"]).'/main.php'); // Retour à l'interface
    }

    // Sélection de la force

    if($ordre == true){ $force = 'ordre' ;}
    elseif($instruction == true){ $force = 'instruction' ;}
    elseif($proposition == true){ $force = 'proposition' ;}
    elseif($nonverbal == true){ $force = 'nonverbal' ;}
    elseif($soliloque == true){ $force = 'soliloque' ;}
    elseif($commentaire == true){ $force = 'commentaire' ;}

    // Sélection de la décision

    if($acceptation == true){ $decision = 'acceptation' ;}
    elseif($accord == true){ $decision = 'accord' ;}
    elseif($autorisation == true){ $decision = 'autorisation' ;}
    elseif($refus == true){ $decision = 'refus' ;}
    elseif($concession == true){ $decision = 'concession' ;}
    elseif($indetermine == true){ $decision = 'indetermine' ;}

    // Sélection de l'initiateur

    if($p2 == true){ $initiateur = 2 ;}
    else{ $initiateur = 1 ;}

    // Cas de l'initiateur différent
    if($di == true){$diffini = 1;}
    else{$diffini = 0;}

/*    // Escape !TODO!
    $first_name = mysqli_real_escape_string($link, $_REQUEST['first_name']);
    $last_name = mysqli_real_escape_string($link, $_REQUEST['last_name']);
    $email = mysqli_real_escape_string($link, $_REQUEST['email']);
*/  

    // CAS UPDATE
    $sql = "SELECT id_ech FROM `echange` WHERE id_mat = '". $matrice ."' temp_ech = '". $timestamp ."' AND agent_init = ". $initiateur;
    echo $sql;
    $result0 = $link->query($sql);
    // Si l'échange existe déjà, on le supprime avant de le ré-ajouter
    if($result0->num_rows > 0){
        while($row = $result0->fetch_assoc()){
            $iddelete = $row["id_ech"];
        }
        $sql = "DELETE FROM `echange` WHERE id_ech = ". $iddelete;
        if(mysqli_query($link, $sql)){
            echo "Records added successfully.";
        } else{
            echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
        }
        $sql = "DELETE FROM `interaction` WHERE id_ech = ". $iddelete;
        if(mysqli_query($link, $sql)){
            echo "Records removed successfully.";
        } else{
            echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
        }
    }

    // Insertion de l'échange
    $sql = "INSERT INTO `echange` (`id_ech`, `id_mat`,`temp_ech`, `agent_init`, `diff_init`, `long`, `force_ech`, `decision`) VALUES (0, $matrice, '$timestamp', $initiateur, $diffini, $longueur, '$force', '$decision')";
    if(mysqli_query($link, $sql)){
        echo "Records added successfully.";
    } else{
        echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
    }

    $sql = "SELECT * FROM `echange` ORDER BY `id_ech` DESC LIMIT 1";
    $result1 = $link->query($sql);
  
    if ($result1->num_rows > 0) {
        // output data of each row
        while($row = $result1->fetch_assoc()) {
          //echo "id: " . $row["id_ech"];
          $maxid = $row["id_ech"];
        }
    }

    // Test
    //$maxid = $row['id_ech'];
    //var_dump("Max id_ech = " . strval($maxid));

    // Insertion des interactions
    $i = 0;
    $j = 0;
    $previs = "";
    $list = [];
    $inter = "";
    while($longueur >= $i){
        $j = 0;
        $previs = !empty($_POST['previs' . strval($i)]) ? $_POST['previs' . strval($i)] : null;
        //var_dump("previs = " . $previs);
        if($previs != null && $previs != [""]){
            $list = explode(";", $previs, 12);
            //var_dump("count(list) = " . count($list));
            while(count($list) > $j + 1){
                print($list);
                $inter = $list[$j];
                $sql = "INSERT INTO `interaction` (`id_inter`, `id_ech`, `temp_inter`, `type_inter`) VALUES (0, $maxid, $i, '$inter')"; // Ajouter l'id réel à la place du 2e "0"
                if(mysqli_query($link, $sql)){
                    echo "Records added successfully.";
                } else{
                    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
                }
                $j += 1;
            }
        }
        $i += 1;
    }

    // Fermeture de connexion à la BDD
    mysqli_close($link);

    // Retour à l'interface
    echo '<script src="function.js">  datavisRefresh(); </script>';
    header('Location: ' . dirname($_SERVER["SCRIPT_NAME"]).'/main.php'); // Retour à l'interface
    exit();
?>
