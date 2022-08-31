<!DOCTYPE html>
<html>
<head>

  <!--lien pour les fonctions et le design pour affichage et utilisation de l'image de la signature-->
  <meta charset="utf-8"/>
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.js"></script>
  <script type='text/javascript'>

    /*fonction pour generer la page pour la signature*/

    window.addEventListener('load', function () {
      // get the canvas element and its context
      var canvas = document.getElementById('sketchpad');
      var context = canvas.getContext('2d');
      var isIdle = true;
      function drawstart(event) {
        context.beginPath();
        context.moveTo(event.pageX - canvas.offsetLeft, event.pageY - canvas.offsetTop);
        isIdle = false;
      }
      function drawmove(event) {
        if (isIdle) return;
        context.lineTo(event.pageX - canvas.offsetLeft, event.pageY - canvas.offsetTop);
        context.stroke();
      }
      function drawend(event) {
        if (isIdle) return;
        drawmove(event);
        isIdle = true;
      }
      function touchstart(event) { drawstart(event.touches[0]) }
      function touchmove(event) { drawmove(event.touches[0]); event.preventDefault(); }
      function touchend(event) { drawend(event.changedTouches[0]) }

      canvas.addEventListener('touchstart', touchstart, false);
      canvas.addEventListener('touchmove', touchmove, false);
      canvas.addEventListener('touchend', touchend, false);

      canvas.addEventListener('mousedown', drawstart, false);
      canvas.addEventListener('mousemove', drawmove, false);
      canvas.addEventListener('mouseup', drawend, false);

    }, false); // end window.onLoad

    </script>
    <script>
    /*fonction pour envoyer l'image de la signature dans le dossier 'image' du repertoire*/

     $(function(){
       $("#gimg").click(function(){
         html2canvas($("#generateImg"), {
          onrendered: function(canvas) {
            var imgsrc = canvas.toDataURL("image/png");
            console.log(imgsrc);
            $("#newimg").attr('src',imgsrc);
            $("#img").show();
             var dataURL = canvas.toDataURL();
                $.ajax({
               type: "POST",
               url: "script.php",
               data: {
                 clientId: "<?php echo explode(" ", $_GET['clientid'])[0]; ?>",
                 imgBase64: dataURL
               }
             }).done(function(o) {
               console.log('saved');
             });
           }
         });
       });
     });
  </script>
  <script>
     $(function(){
       $("#clear").click(function(){
        var canvas = document.getElementById("sketchpad");
        var context = canvas.getContext('2d');
        context.clearRect(0, 0, canvas.width, canvas.height);
       });
     });
  </script>
</head>
<body encoding='utf8'>
  <!--affichage de la page de signature-->
  <div class="centerformsignature">
    <h3 class="h3form">Signature</h3>
    <div id="generateImg" class="imgSignature">
      <canvas class ="signature" id='sketchpad' width='800' height='800'/>
      <br/>
    </div>
    <div id="buttons">
      <input type="button" id="clear" value="supprimer signature" class="clear">
    </div>
    <!--enregistrement de la signature liée à l'id du client avec toutes les valeurs enregistrer vers le traitement_formulaire_etat_materiel.php-->
    <form action="Signature.php" method="GET" id="gimg" type="button" >
      <input type="submit" value="Validation signature" class="valider">
    </form>
  </div>
</body>
</html>