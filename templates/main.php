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






<div id="MainDiv" class="main">

    <div id="Toolbar" class="toolbar">
        <h1>ACDC</h1>
    </div>    

    <div id="CoreDiv" class="core">  

        <div id="LeftDiv" class="left">
            <?php include "getEchId.php";?>
        </div>

        <div id="RightDiv" class="right">

            <div id="TopDiv" class="top">

                <form action="db.php" method="post" onsubmit="insertPrevis();">

                    <div id="ForceDiv" class="force">
                        <div id="MiscDiv" class="misc">
                            <input id="timestamp" name="timestamp" type="datetime" placeholder="00:00" data-toggle="tooltip" data-placement="bottom" title="Instant de début de l'échange (! 2 chiffres minutes et secondes!)" required/>
                            <input type="checkbox"  id="participant1" name="participant1"  checked onclick="resetParticipants(this)"/>
                            <label for="participant1" data-toggle="tooltip" data-placement="bottom" title="P1 prend en 1er la parole"><a>P1</a></label>
                            <input type="checkbox" id="participant2" name="participant2" onclick="resetParticipants(this)" />
                            <label for="participant2" data-toggle="tooltip" data-placement="bottom" title="P2 prend en 1er la parole"><a>P2</a></label>
                            <input type=checkbox id="diffini" name="diffini"></input>
                            <label for="diffini" data-toggle="tooltip" data-placement="bottom" title="La personne prenant la parole n'est pas celle qui initie l'échange"><a>D.I.</a></label>
                            <input id="Longueur" type="number" value="0" name="Longueur" placeholder="Longueur" data-toggle="tooltip" data-placement="bottom" title="Longueur : Nombre d'aller-retours de la parole (La première prise de parole est notée à '0')" onchange="refresh()" required/>
                        </div>
                        <br/>
                        <div id="StringDiv" class="string">
                            <input type="checkbox" id="ordre" name="ordre" class="button" onclick="uncheckForce(this)" />
                            <label for="ordre" data-toggle="tooltip" data-placement="bottom" title="Ordre : affirmation à l'indicatif, injonction ou commande authoritaire, très confiante" ><img src="Images/ordre.png" /></label>
                            <input type="checkbox" id="instruction" name='instruction' class="button" onclick="uncheckForce(this)" />
                            <label for="instruction"  data-toggle="tooltip" data-placement="bottom" title="Instruction : affirmation ou indication au conditionnel ou à l'indicatif, neutre ou plutôt confiante, sans être autoritaire" ><img src="Images/instruction.png" /></label>
                            <input type="checkbox" id="proposition" name="proposition" class="button" onclick="uncheckForce(this)" />
                            <label for="proposition"  data-toggle="tooltip" data-placement="bottom" title="Proposition : affirmation au conditionnel, émission d'une idée moyennement confiante ou peu assurée" ><img src="Images/proposition.png" /></label>
                            <input type="checkbox" id="nonverbal" name="nonverbal" class="button" onclick="uncheckForce(this)" />
                            <label for="nonverbal" data-toggle="tooltip" data-placement="bottom" title="Non-Verbal : action non verbalisée, constatée par la réponse de l'autre participant" ><img src="Images/nonverbal.png" /></label>
                            <input type="checkbox" id="soliloque" name="soliloque" class="button" onclick="uncheckForce(this)" />
                            <label for="soliloque" data-toggle="tooltip" data-placement="bottom" title="Soliloque : tout type de syntaxe n'incluant pas l'autre participant, donne une directive pour soi, énonce ce qu'il va faire" ><img src="Images/soliloque.png" /></label>
                            <input type="checkbox" id="commentaire" name="commentaire" class="button" onclick="uncheckForce(this)" />
                            <label for="commentaire"  data-toggle="tooltip" data-placement="bottom" title="Commentaire : tout type de syntaxe non directive ni réponse, commentaire sur le jeu ou un sujet annexe" ><img src="Images/commentaire.png" /></label>
                        </div>
                        <hr/>
                        <div id="DecisionDiv" class="decision">
                            <input type="checkbox" id="acceptation" name="acceptation" class="button" onclick="uncheckDecision(this)" />
                            <label for="acceptation" data-toggle="tooltip" data-placement="bottom" title="Acceptation : ne s'oppose pas à l'idée de l'autre participant" ><img src="Images/acceptation.png" /></label>
                            <input type="checkbox" id="accord" name="accord" class="button" onclick="uncheckDecision(this)" />
                            <label for="accord" data-toggle="tooltip" data-placement="bottom" title="Accord : est du même avis que l'autre participant" ><img src="Images/accord.png"/></label>
                            <input type="checkbox" id="autorisation" name="autorisation" class="button" onclick="uncheckDecision(this)" />
                            <label for="autorisation" data-toggle="tooltip" data-placement="bottom" title="Autorisation : accepte une proposition d'action de l'autre (très dépendant du contexte)" ><img src="Images/autorisation.png"/></label>
                            <input type="checkbox" id="refus" name="refus" class="button" onclick="uncheckDecision(this)" />
                            <label for="refus" data-toggle="tooltip" data-placement="bottom" title="Refus : Verbalise son désaccord ou fait immédiatement une contre-proposition" ><img src="Images/refus.png"/></label>
                            <input type="checkbox" id="concession" name="concession" class="button" onclick="uncheckDecision(this)" />
                            <label for="concession" data-toggle="tooltip" data-placement="bottom" title="Concession : n'est pas d'accord mais accepte tout de même d'effectuer l'action" ><img src="Images/concession.png"/></label>
                            <input type="checkbox" id="indetermine" name="indetermine" class="button" onclick="uncheckDecision(this)" />
                            <label for="indetermine" data-toggle="tooltip" data-placement="bottom" title="Indéterminée : réponse machinale/automatique, inaudible ou trop difficile à interpréter" ><img src="Images/indetermine.png"/></label>                    
                        </div>

                    </div>
                    <div id="PrevisDiv" class="previs">
                        
                        <div id="ScrollPrevis" class="scroll">
                            <div id="Zone0" class="zone" ondrop="drop(event)" ondragover="allowDrop(event)" ondblclick="supprChild(this)">0</div>
                        </div>
                        <div id="PrevisOptions" class="options">
                            <input type="button" value="+" onclick="addtolength(1); refresh()"></input>
                            <input type="button" value="-" onclick="addtolength(-1); refresh()"></input>
                        </div>
                    </div>


                    <div id="SaveDiv1" class="save">
                        <button class="sav" type="submit" >Save</button>
                        <br/>
                        <button class="cancel" type="reset" onclick="location.reload();" >Cancel</button>
                    </div>
                    <div id="InterDiv" class="inter">
                        <input type="checkbox" id="questionnecheck" class="button" />
                        <label for="questionne" data-toggle="tooltip" data-placement="bottom" title="Questionne : question/affirmation sucitant la participation de l'autre participant ou son avis" ><img id="questionne" src="Images/questionne.png" draggable="true" ondragstart="drag(event)" /></label>
                        <input type="checkbox" id="informecheck" class="button" />
                        <label for="informe" data-toggle="tooltip" data-placement="bottom" title="Informe : explique une directive ou un choix, expose une stratégie ou anticipe la suite" ><img id="informe" src="Images/informe.png" draggable="true" ondragstart="drag(event)"/></label>
                        <input type="checkbox" id="controlecheck" class="button" />
                        <label for="controle" data-toggle="tooltip" data-placement="bottom" title="Contrôle : surveille l'action de l'autre, demande des justifications à l'action, cherche à comprendre ce que fait l'autre" ><img id="controle" src="Images/controle.png" draggable="true" ondragstart="drag(event)"/></label>
                        <br/>
                        <input type="checkbox" id="positifcheck" class="button" />
                        <label for="positif" data-toggle="tooltip" data-placement="bottom" title="Positif : compliment ou remarque positive sur le jeu ou une action" ><img id="positif" src="Images/positif.png" draggable="true" ondragstart="drag(event)"/></label>
                        <input type="checkbox" id="negatifcheck" class="button" />
                        <label for="negatif" data-toggle="tooltip" data-placement="bottom" title="Négatif : critique ou remarque négative sur le jeu ou une action" ><img id="negatif" src="Images/negatif.png" draggable="true" ondragstart="drag(event)"/></label>
                        <input type="checkbox" id="positif2check" class="button" />
                        <label for="positif2" data-toggle="tooltip" data-placement="bottom" title="Positif+ : compliment, remarque positive ou de satisfaction à son partenaire" ><img id="positif2" src="Images/positif2.png" draggable="true" ondragstart="drag(event)"/></label>
                        <input type="checkbox" id="negatif2check" class="button" />
                        <label for="negatif2" data-toggle="tooltip" data-placement="bottom" title="Négatif- : critique ou remarque négative envers son partenaire ou une action de celui-ci" ><img id="negatif2" src="Images/negatif2.png" draggable="true" ondragstart="drag(event)"/></label>
                        <br/>
                        <input type="checkbox" id="coupurecheck" class="button" />
                        <label for="coupurecheck" data-toggle="tooltip" data-placement="bottom" title="Coupure : un participant coupe la parole à un autre (à placer dans l'échange avant que la parole soit coupée)" ><img id="coupure" src="Images/coupure.png" draggable="true" ondragstart="drag(event)"/></label>
                    </div>

                </form>

            </div>
            
            <div id="BottomDiv" class="bottom">
                <div id="VisDiv" class="vis">
                    <?php include "../newdatavis.html"; ?>
                </div>
                <div id="SaveDiv2" class="save">
                    <button class="sav" type="submit" onclick="testPrevis();">Save</button>
                    <br/>
                    <button class="cancel" type="reset">Cancel</button>
                    <br/>
                    <button style="color: white; border-color: green; background-color: green" class="cancel"  onclick="datavisRefresh()">Refresh Datavis</button>
                </div>
            </div>

        </div>

    </div>

</div>
</body>
</html>
