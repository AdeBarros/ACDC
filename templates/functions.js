    // Ol' reliable
    var i = 0;
    var modAnalyse = true;

    // Activation des Tooltips
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();   
    });

    // Permet de toujours choisir 1 seule Force
    function uncheckForce(elm) {
        var ord = document.getElementById('ordre');
        var ins = document.getElementById('instruction');
        var pro = document.getElementById('proposition');
        var non = document.getElementById('nonverbal');
        var sol = document.getElementById('soliloque');
        var com = document.getElementById('commentaire');
        if(ord.checked == true && elm != ord){
        ord.click();
        }
        if(ins.checked == true && elm != ins){
        ins.click();
        }
        if(pro.checked == true && elm != pro){
        pro.click();
        }
        if(non.checked == true && elm != non){
        non.click();
        }
        if(sol.checked == true && elm != sol){
        sol.click();
        }
        if(com.checked == true && elm != com){
        com.click();
        }
    }

    // Permet de toujours choisir 1 seule Décision
    function uncheckDecision(elm) {
        var act = document.getElementById('acceptation');
        var aco = document.getElementById('accord');
        var aut = document.getElementById('autorisation');
        var ref = document.getElementById('refus');
        var con = document.getElementById('concession');
        var ind = document.getElementById('indetermine');
        if(act.checked == true && elm != act){
        act.click();
        }
        if(aco.checked == true && elm != aco){
        aco.click();
        }
        if(aut.checked == true && elm != aut){
        aut.click();
        }
        if(ref.checked == true && elm != ref){
        ref.click();
        }
        if(con.checked == true && elm != con){
        con.click();
        }
        if(ind.checked == true && elm != ind){
        ind.click();
        }
    }

    // Permet de réinitialiser les intéractions (avec le dblclick)
    function uncheckInteraction(elm) {
        var que = document.getElementById('questionne');
        var inf = document.getElementById('informe');
        var con = document.getElementById('controle');
        var pos = document.getElementById('positif');
        var neg = document.getElementById('negatif');
        var po2 = document.getElementById('positif2');
        var ne2 = document.getElementById('negatif2');
        if(que.checked == true && elm != que){
        que.click();
        }
        if(inf.checked == true && elm != inf){
        inf.click();
        }
        if(con.checked == true && elm != con){
        con.click();
        }
        if(pos.checked == true && elm != pos){
        pos.click();
        }
        if(neg.checked == true && elm != neg){
        neg.click();
        }
        if(po2.checked == true && elm != po2){
        po2.click();
        }
        if(ne2.checked == true && elm != ne2){
        ne2.click();
        }
    }

    // Permet de ramener le timestamp à sa valeur initiale
    function resetTimestamp() {
        var elm = document.getElementById('timestamp');
        elm.value = "";
    }

    // Permet de ramener P1 et P2 sur leur valeur initiale
    function resetParticipants(elm) {
        var p1 = document.getElementById('participant1');
        var p2 = document.getElementById('participant2');
        if(p1.checked == true && elm != p1) {
            p1.click();
        }
        if(p2.checked == true && elm != p2) {
            p2.click();
        }
    }

    // Permet de ramener la longueur à sa valeur initiale
    function resetLongueur() {
        var elm = document.getElementById('Longueur');
        elm.value = "";
    }

    function resetevenement() {
        var evt = document.getElementById('evenement');
        evt.value = "";
    }

    // Permet de remettre le Form entier à sa valeur initiale
    function resetForm(elm) {
        resetTimestamp();
        resetParticipants(elm);
        resetLongueur();
        resetevenement();
        uncheckForce(elm);
        uncheckDecision(elm);
        uncheckInteraction(elm);
        refresh();
    }

    // Autorise le drag&drop
    function allowDrop(ev) {
        ev.preventDefault();
    }

    // Récupération des données de l'objet "drag"
    function drag(ev) {
        ev.dataTransfer.setData("text", ev.target.id);
    }

    // Ecriture des données de l'objet "drag" dans l'objet "drop"
    function drop(ev) {
        ev.preventDefault();
        var data = ev.dataTransfer.getData("text");
        ev.target.appendChild(document.getElementById(data).cloneNode(true));
    }

    // Permet de supprimer un enfant d'un parent choisi :^)
    function supprChild(parent) {
        a = null;
        while (parent.firstChild) {
            if(parent.firstChild.innerHTML == undefined){
                a = parent.firstChild;
            }
            parent.removeChild(parent.firstChild);
        }
        if(a != null){
            parent.appendChild(a);
        }
    }

    // Permet de revenir à la prévis initiale
    function refresh(){
        var l = document.getElementById("Longueur");
        var s = document.getElementById("ScrollPrevis");
        var n = parseInt(l.value);
        if(n > i){
            while(n > i){
                s.innerHTML += '<div id="Zone' + (i+1) + '" class="zone" ondrop="drop(event)" ondragover="allowDrop(event)" ondblclick="supprChild(this)">' + (i+1) + '</div>';
                i+=1;
            }
        }
        else{
            while(i > n){
                s.removeChild(s.lastChild);
                i-=1;
            }
        }
        
        l.value = i
    }

    //Permet d'avoir toujours la longueur à la même taille que la prévis
    function addtolength(val){
        let long = parseInt(document.getElementById("Longueur").value);
        if(long + val >= 0){
            document.getElementById("Longueur").value = long + val;
        }
    }


    // Test de la prévis...
    function testPrevis(){
        var previs = document.getElementById("ScrollPrevis");
        var child = null;
        n = previs.childElementCount;
        i = 0;
        m = null;
        // alert("n = " + n)
        while(n > i){
            child = document.getElementById("Zone" + i);
            j = 1;
            m = child.childElementCount;
            // alert("m = " + m);
            while(m >= j){
                elem = child.childNodes[j];
                alert(i + " : " +elem.id);
                j += 1;
            }
            i += 1;
        }
    }

    // Ajoute/retire des cases à la prévis (lorsqu'on appuie sur les boutons "+" ou "-", ou que l'on change la valeur de longueur)
    function insertPrevis(){
        var origin = document.getElementById("PrevisDiv");
        var previs = document.getElementById("ScrollPrevis");
        var child = null;
        n = previs.childElementCount;
        i = 0;
        m = null;
        // alert("n = " + n)
        while(n > i){
            child = document.getElementById("Zone" + i);
            j = 1;
            entree = "";
            m = child.childElementCount;
            // alert("m = " + m);
            while(m >= j){
                elem = child.childNodes[j];
                entree += elem.id + ";";
                j += 1;
            }
            origin.innerHTML += '<input type="hidden" id="previs' + i + '" name="previs' + i + '" value="' + entree + '">';
            i += 1;
        }
        return true;
    }

    // Importe les données insérées dans les cases (depuis la BDD) et ajoute ces données dans le Form
    function importDataEch(div){

        resetevenement();

        var i = 1;
        var j = 0;

        document.getElementById("timestamp").value = div.getAttribute("tem");
        /*
        // the hard way
        if(div.getAttribute("agini") == 1){
            if(document.getElementById("participant1").checked == false){
                document.getElementById("participant1").click();
            }
        }
        if(div.getAttribute("agini") == 2){
            if(document.getElementById("participant2").checked == false){
                document.getElementById("participant2").click();
            }
        }
        */

        // the soft way
        if(document.getElementById("participant" + div.getAttribute("agini")).checked == false){
            document.getElementById("participant" + div.getAttribute("agini")).click();
        }

        if(div.getAttribute("dini") == 1){
            document.getElementById("diffini").checked = true;
        }
        else{
            document.getElementById("diffini").checked = false;
        }

        document.getElementById("Longueur").value = div.getAttribute("long");
        refresh();

        if(div.getAttribute("forc") == null || div.getAttribute("forc") == ""){
            uncheckForce();
        }
        else{
            if(document.getElementById(div.getAttribute("forc")).checked == false){
                document.getElementById(div.getAttribute("forc")).click();
            }
        }

        if(div.getAttribute("deci") == "sans"){
            uncheckDecision();
        }
        else if(document.getElementById(div.getAttribute("deci")).checked == false){
            document.getElementById(div.getAttribute("deci")).click();
        }

        var longueur = div.getAttribute("long");
        while(longueur >= j){
            supprChild(document.getElementById("Zone" + j))
            j += 1;
        }

        while(div.childElementCount >= i){
            var child = div.childNodes[i];
            if(child.id.slice(0, 5) == "Inter"){
                document.getElementById("Zone" + div.childNodes[i].getAttribute("tem")).appendChild(document.getElementById(child.getAttribute("typ")).cloneNode(true));
            }
            if(child.id.slice(0, 5) == "Event"){
                document.getElementById("evenement").value = child.getAttribute("desc");
            }
            i += 1;
        }

        
    }
    
    // Met à jour la Datavis avec le code Python (! lancer Flask avant)
    function datavisRefresh(){
        // Send form data to the server with an aynchronous POST request

        //DB to JSON
        var finalData = {};
        var echData = {};
        var interData = {};
        const dataset = document.getElementById("LeftDiv");
        const numEch = dataset.childElementCount - 1;
        var echange = null;
        var numInter = null;
        var interaction = null;

        var i = 0;
        var j = 0;
        var stringI = "0";
        var stringJ = "0";

        while(i < numEch){
            echange = dataset.children[i+1];
            numInter = echange.childElementCount - 2;
            j = 0;
            echData = {};
            echData["temp"] = echange.getAttribute("tem");
            echData["agini"] = echange.getAttribute("agini");
            echData["long"] = echange.getAttribute("long");
            echData["force"] = echange.getAttribute("forc");
            echData["deci"] = echange.getAttribute("deci");
            echData["dini"] = echange.getAttribute("dini");
            echData["evt"] = null;

            while(j < numInter){
                interaction = echange.children[j];
                if(interaction.getAttribute("id").slice(0, 5) == "Inter"){
                    interData = {}
                    interData["temp"] = interaction.getAttribute("tem");
                    interData["type"] = interaction.getAttribute("typ");
                    stringJ = String(j);
                    echData[stringJ] = interData;

                }
                else if(interaction.getAttribute("id").slice(0, 5) == "Event"){
                    echData["evt"] = interaction.getAttribute("desc");
                }
                j++;
            }
            stringI = String(i);
            finalData[stringI] = echData;
            i++;
        }

        finalDataJSON = JSON.stringify(finalData);

        sentData = {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: finalDataJSON
        };

        fetch("http://127.0.0.1:5000/postmethod", sentData)
            .then(() => location.reload());
        
    }

    function timeToStr(time){
        var min = Math.floor(time/60);
        var sec = Math.floor(time % 60);
        var strMin = min.toString();
        var strSec = sec.toString();
        if(min < 10){
            strMin = "0" + strMin;
        }
        if(sec < 10){
            strSec = "0" + strSec;
        }
        return strMin + ":" + strSec
    }

    function tstotime(ts){
        return parseInt(ts.slice(0, 2)) * 60 + parseInt(-2);
    }

    function copyTimeStamp(){
        var audio = document.getElementById("playingaudio");
        var time = audio.currentTime;
        var newTime = timeToStr(time);
        document.getElementById("timestamp").setAttribute("value", newTime);

        
    }

    function setAudioFromPointer(event){
        var x = event.clientX;
        var y = event.clientY;
        var wx = window.innerWidth;
        var wy = window.innerHeight;
        var px = 100*x/wx;
        var py = 100*y/wy;

        var audio =  document.getElementById("playingaudio");
        var duration = audio.duration;
        
        if(px > 14.5 && px < 85.5) {
            var curTime = ((px - 14.5) / 0.713)  * duration / 100;
        }

        var coords = "X coords: " + x + ", Y coords: " + y + "; X prc: " + px + "%, Y prc: " + py + "%, Durée : " + timeToStr(curTime) ;
        document.getElementById("demo").innerHTML = coords;
        document.getElementById("timestamp").setAttribute("value", timeToStr(curTime));

    }
    /*
    function setTime(timestamp){
        ts = timestamp.value;
        audio = document.getElementById("playingaudio");
        
        audio.oncanplay = function() {
            audio.setAttribute("currentTime", 10);
        };
        document.getElementById("demo").innerHTML = audio.currentTime;
    }
    */

    function trackingLine(){
        var audio = document.getElementById("playingaudio");
        var time = audio.currentTime;
        var duration = audio.duration;

        var cv = document.getElementById("canvas");
        var ctx = cv.getContext("2d");

        var minX = cv.width * 0.055;
        var maxX = cv. width * 0.951;
        length = maxX - minX;
        var minY = cv.height * 0.21;
        var maxY = cv.height * 0.83;
        height = maxY - minY;

        ctx.clearRect(0, 0, cv.width, cv.height);

        var curX = minX + Math.floor(time * length / duration);

        ctx.beginPath();
        ctx.moveTo(curX, minY);
        ctx.lineTo(curX, maxY);
        ctx.strokeStyle= "black";
        ctx.lineWidth= 0.5;
        ctx.stroke();

        // copyTimeStamp()
    }

    function changeMode(){
        if(modAnalyse == true){
            document.getElementById("canvas").style.zIndex = 0;
            document.getElementById("changemode").innerHTML = "Mode Analyse";
            modAnalyse = false;
        }
        else{
            document.getElementById("canvas").style.zIndex = 5000;
            document.getElementById("changemode").innerHTML = "Mode Suivi";
            modAnalyse = true;
        }
    }

    function returnToMatrix(){
        if(confirm("Voulez-vous quitter et retourner sur la page d'accueil ? Les données non sauvegardées seront perdues")){
            document.location.href='matrix.php';
        }
    }

    
    // Permet de ne lancer le Form que lorsqu'on a au moins rentré les paramètres minimaux (Force, Timestamp, P1/P2, Longueur)
    function valForm(form){ //J'arrive pas à le faire marcher...
        var ordre = document.getElementById("ordre");
        var instruction = document.getElementById("instruction");
        var proposition = document.getElementById("proposition");
        var nonverbal = document.getElementById("nonverbal");
        var soliloque = document.getElementById("soliloque");
        var commentaire = document.getElementById("commentaire");
        var evenement = document.getElementById("evenement");
        if(ordre.checked || instruction.checked || proposition.checked || nonverbal.checked || soliloque.checked || commentaire.checked || (evenement.value != "" && evenement.value != null)){
            insertPrevis();
            form.submit();
        }
        else{
            alert("Veuillez entrer une force pour cet échange");
        }
    }

    
    function confSubmit(form) {
        if (confirm("Voulez-vous vraiment supprimer cet échange ?")) {
          form.submit();
        }
        else{
          returnToPreviousPage();
          return false;
        }
      }

    
      function changeTS(form) {
        let newtimestamp = prompt("Veuillez choisir le nouveau 'Temps début' :", form.childNodes[1].getAttribute("value"));
        let newAgentInit = prompt("Veuillez choisir l'agent initiateur :", form.childNodes[2].getAttribute("value"));
        let change = false;
        if (newtimestamp != null && newtimestamp != "" && newtimestamp != form.childNodes[1].getAttribute("value")) {
          form.childNodes[1].setAttribute("value", newtimestamp);
          change = true;
        }
        if (newAgentInit != null && newAgentInit != "" && newAgentInit != form.childNodes[2].getAttribute("value")) {
            form.childNodes[2].setAttribute("value", newAgentInit);
            change = true;
        }
        if (change){
            form.submit();
        }

      }

    /*
    function dump(obj) {
        var out = '';
        for (var i in obj) {
            out += i + ": " + obj[i] + "\n";
        }
        alert(out);
    }
    */
