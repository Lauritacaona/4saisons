<?php
require_once("autoload.php");
session_start();
$dirSession = "";
$dirPrincipal = "../";
require_once("codes/daoMembre.php");
//Si le membre n'est pas de type admin, il doit retourner à l'index
if(!isset($_SESSION['membre'])){
  header("Location:../index.php");
}else{
  if($_SESSION['membre']->droit != 1){
    header("Location:../index.php");
  }
}
$liste = getAllMembres();//C'est une liste d'objets Membre
require_once("../header.php");
?>

<h2>Logs, logs, logs...</h2>
<div class="col-md-4">
  <h3>Dernieres connexions :</h3>
  <div class="afficheLastConnex"></div>
</div>

<div class="col-md-7">
  <h3>Dernieres paginations:</h3>
  <div class="afficheLastPagi"></div>
</div>

<div class="col-sm-12">
  <h3>Dernieres insertions de fonds :</h3>
  <div class="afficheLastBg"></div>
</div>



<script>
function ajaxMoiCeci(demande, idMembre, nbRes, divRep){
  $.ajax({
    type: "POST",
    data: {demande:demande, idMembre:idMembre, nbRes:nbRes},
    url: "codes/daoLogs.php",
    error: function(req, statut, err){
      console.log("Error : " + statut + " - req :" +req + "erreur :" +err);
    },
    success: function(data, statut){
      $(divRep)[0].innerHTML = data;
      if(demande == "afficheLastPagi"){
        $('.tablePagi').DataTable({
          'order': []
        });
      }
      if(demande == "afficheLastBg"){
        $('.tableBg').DataTable({
          'order': []
        });
      }
    }
  });
}
$(document).ready(function(){
  ajaxMoiCeci('afficheLastConnex', false, 10, '.afficheLastConnex');
  ajaxMoiCeci('afficheLastPagi', false, 0, '.afficheLastPagi');
  ajaxMoiCeci('afficheLastBg', false, 0, '.afficheLastBg');
});
</script>

<?php require_once('../footer.php');
