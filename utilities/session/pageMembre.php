<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
require_once("autoload.php");
session_start();

$dirSession = "";
$dirPrincipal = "../";
require_once("codes/daoMembre.php");

if(!isset($_SESSION['membre'])){
  header("Location:../index.php");
}
$membre = getMembre($_GET["id"]);
?>
<?php require_once("../header.php"); ?>
<!--C'est ici que la page commence-->

<h1><?= $membre->pseudo; ?></h1>
<?php require("adminMembre.php"); ?>
<p>Dernière connexion le : <?= $membre->getDate(); ?></p>
<div class="droits col-sm-7">
  <h2><?= $membre->getDroit(); ?></h2>
  <ul>
    <?= $membre->afficheDroits($_SESSION['membre']->droit); ?>
  </ul>
</div>

<?php
if($_GET['id'] == $_SESSION['membre']->id){
?>
<div class="infosComp col-sm-5">
  <h2>Infos personnelles</h2>
  <div>
    <b>Nom : </b><?= $_SESSION['membre']->fullName;?>
    <span class="changeInfo modifNom">modifier...</span>
    <form class="formModifNom formCache" method="POST" action="traitement.php">
      <input type="hidden" name="typeForm" value="modifTexte" />
      <input type="hidden" name="aModifier" value="fullName" />
      <input type="text" name="newText" />
      <input type="submit" />
    </form>

  </div>
  <div>
    <b>Adresse e-mail : </b><?= $_SESSION['membre']->email;?>
    <span class="changeInfo modifMail">modifier...</span>
    <form class="formModifMail formCache" method="POST" action="traitement.php">
      <input type="hidden" name="typeForm" value="modifTexte" />
      <input type="hidden" name="aModifier" value="email" />
      <input type="text" name="newText" id="newMail" />
      <input type="submit" />
    </form>
  </div>
  <div>
    <b>Mot de passe : </b>*c*o*u*c*o*u*
    <span class="changeInfo modifMdp">modifier...</span>
    <form class="formModifMdp formCache" method="POST" action="traitement.php" onsubmit="return verifMdp();">
      <input type="hidden" name="typeForm" value="modifMdp" />
      Mot de passe actuel : <input type="password" name="oldMdp" /><br />
      Nouveau mot de passe : <input type="password" name="newMdp1" id="newMdp1" /><br />
      Confirmer le mdp: <input type="password" name="newMdp2" id="newMdp2" /><br />
      <p id="mdpDiff" class="message"></p>
      <input type="submit" />
    </form>
  </div>
</div>
<!-- Special factures  -->
<?php
if($_SESSION['membre']->statut == 3){ //C'est un freelance
  $mois = array('Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre');
  ?>
  <div class="row"></div>
  <div class="facture">
    <h2>Tableau horaire pour factures</h2>

    <form method="GET" action="../horairator/exports/index.php">
      <input type="hidden" name="type" value="facture" />
      <p>
        <label for="factMois">Mois :</label>
        <select name="mois" id="factMois">
          <?php
          for($i=0; $i<count($mois); $i++){
            ?>
            <option value="<?=$i+1;?>"><?=$mois[$i];?></option>
            <?php
          }
          ?>
        </select>

        <label for="factAnnee"> Année :</label>
        <input type="number" name="annee" placeholder="ex : 2020" size="4" />

        <label for="factTaux"> Taux horaire :</label>
        <input type="number" name="taux" placeholder="78" />€

        <input type="submit" value="Récupérer le tableau" />
      </p>
    </form>
  </div>
  <?php
}
?>
<!-- fin des factures  -->
<?php
}
/**
 * Visible uniquement par les administrateurs... LES LOGS
 */
 if($_SESSION['membre']->droit == 1){
   //on liste les options disponibles
   ?>
   <div class="row"></div>
  <div class="logsAdmin">
    <!-- Logs des connexions -->
    <div>
      <h3>Détail des connexions</h3>
      <p>Afficher les...
        <button class="logCon" value="5"> 5 </button>
        <button class="logCon" value="20"> 20 </button>
        <button class="logCon" value="0">toutes</button> dernières connexions
      </p>
      <div class="connexIci"><!--C'est ici qu'on met les infos--></div>
    </div>

    <!-- Logs du paginator -->
    <div>
      <h3>Action de pagination</h3>
      <p>Afficher les...
        <button class="logPagi" value="5"> 5 </button>
        <button class="logPagi" value="20"> 20 </button>
        <button class="logPagi" value="45"> 45 </button>
        <button class="logPagi" value="0">toutes</button> dernières actions sur le paginator
      </p>
      <div class="pagiIci"><!--C'est ici qu'on met les infos--></div>
    </div>

    <!-- Logs du backgroundator -->
    <div>
      <h3>Insertions de fonds</h3>
      <p>Afficher les...
        <button class="logBg" value="5"> 5 </button>
        <button class="logBg" value="20"> 20 </button>
        <button class="logBg" value="45"> 45 </button>
        <button class="logBg" value="0">toutes</button> dernières insertions de fonds
      </p>
      <div class="bgIci"><!--C'est ici qu'on met les infos--></div>
    </div>
  </div>
   <?php
 }
?>

<script>
var idMembre = <?= $membre->id;?>;
//Fonction qui envoie et recupere via ajax les trucs qu'on lui demande
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
    }
  });
}
//verification du double mot de passe
function verifMdp(){
  if($("#newMdp1").val() === $("#newMdp2").val()){
    return true;
  }else{
    $("#mdpDiff").html("Les deux mots de passe doivent être identique");
    return false;
  }
}

$(document).ready(function(){
  //$('.matable').tablesorter();
  $('.logCon').on('click', function(){
    var nb = $(this)[0].value;
    ajaxMoiCeci('lectureConnexMembre', idMembre, nb, '.connexIci');
  });

  $('.logPagi').on('click', function(){
    var nb = $(this)[0].value;
    ajaxMoiCeci('lecturePagiMembre', idMembre, nb, '.pagiIci');
  });

  $('.logBg').on('click', function(){
    var nb = $(this)[0].value;
    ajaxMoiCeci('lectureBgMembre', idMembre, nb, '.bgIci');
  });

  //affichage des trucs pour changer de mot mail ou de mot de passe
  $('.modifNom').on('click', function(){
    $('.formModifNom').css('display', 'block');
  });
  $('.modifMail').on('click', function(){
    $('.formModifMail').css('display', 'block');
  });
  $('.modifMdp').on('click', function(){
    $('.formModifMdp').css('display', 'block');
  });

});
</script>

<?php require_once('../footer.php');
