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
<h2>Ajouter un membre</h2>

<form method="POST" action="traitement.php" onsubmit="return verifConnex();">
  <input type="hidden" name="typeForm" value="ajouterMembre" />
  <fieldset class="col-md-6">
    <legend>Informations générales :</legend>
    <?php afficheMess('infogen'); ?>
    <p>
      <label for="nomMembre">Pseudo : </label>
      <input type="text" name="pseudo" id="nomMembre" />
      <span class="message" id="nomMembreMess"></span>
    </p>
    <p>
      <label for="mdp1">Mot de passe :</label>
      <input type="password" name="mdp1" id="mdp1" />
      <span class="message" id="mdp1Mess"></span>
    </p>
    <p>
      <label for="mdp2">Confirmation du mot de passe : </label>
      <input type="password" name="mdp2" id="mdp2" />
      <span class="message" id="mdp2Mess"></span>
    </p>
    <p id="mdpDiff" class="message"></p>
  </fieldset>
  <!-- Infos concernant la creation -->
  <fieldset class="col-md-6">
    <legend>Droits d'accès :</legend>
    <?php afficheMess('droits'); ?>
    <p id="listeNonCheck" class="message"></p>
    <table>
      <tr>
        <td>DEVELOPPEUR ?</td>
        <td><input type="radio" name="dev"  value="1" /> oui</td>
        <td><input type="radio" name="dev"  value="0" checked="checked" /> non</td>
      </tr>
    <tr>
      <td>PAGINATOR</td>
      <td><input type="radio" name="creation[paginator]" class="pg" value="1" /> oui</td>
      <td><input type="radio" name="creation[paginator]" class="pg" value="0" checked="checked" /> non</td>
    </tr>
    <tr>
      <td>DATACREATOR</td>
      <td><input type="radio" name="creation[datacreator]" class="dc" value="1" /> oui</td>
      <td><input type="radio" name="creation[datacreator]" class="dc" value="0" checked="checked" /> non</td>
    </tr>
    <tr>
      <td>BACKGROUND SELECTOR</td>
      <td><input type="radio" name="creation[backgrounator]" class="bg" value="1" /> oui</td>
      <td><input type="radio" name="creation[backgrounator]" class="bg" value="0" checked="checked" /> non</td>
    </tr>
  </table>
  </fieldset>
  <!-- Infos pour l'horairator et autre -->
  <fieldset class="col-md-12">
    <legend>Infos complémentaires :</legend>
    <p class="gris">C'est surtout pour l'HORAIRATOR...</p>
    <p>
      <label for="emailMemebre">Adresse e-mail : </label>
      <input type="text" name="email" id="emailMemebre" />
      <span class="message" id="mailMembreMess"></span>
    </p>
    <p>
      <label for="fullName">Nom et prénom : </label>
      <input type="text" name="fullName" id="fullName" />
      <p class="gris">(Promis ça restera entre nous)</p>
    </p>
  </fieldset>
  <input type="submit" value="Ajouter un membre" />
  </form>

  <div class="row"></div>
  <h2>Déja membres :</h2>
  <p id="touslesmembres" class="col-sm-4">Voir la liste</p>
  <div class="col-sm-8">
    <p>Ou rechercher :
      <input list="dataMembres" name="inputMembres" id="inputMembres"/>

      <button class="goToPage">Ok</button>
      <datalist id="dataMembres">
        <?php
        for($i=0; $i<count($liste); $i++){
          ?>
          <option value="<?= $liste[$i]->pseudo;?>(<?= $liste[$i]->id; ?>)">

          </option>
          <?php
        }
        ?>
      </datalist>

    </p>
  </div>
  <table class="table-responsive table-bordered table-hover matable" id="listemembres">
      <thead>
        <tr>
          <th>Nom</th>
          <th>Droit</th>
          <th>Dernière connexion</th>
          <th>Paginator</th>
          <th>Datacreator</th>
          <th>backgroundSelector</th>
        </tr>
      </thead>
      <tbody>
    <?php
    for($i=0; $i<count($liste); $i++){
      ?>
      <tr>
          <td><?= $liste[$i]->getLien(); ?></td>
          <td><?= $liste[$i]->getDroit(); ?></td>
          <td><?= $liste[$i]->getDate(); ?></td>
          <td><?= $liste[$i]->pagiToString(); ?></td>
          <td><?= $liste[$i]->dataToString(); ?></td>
          <td><?= $liste[$i]->backToString(); ?></td>
      </tr>
      <?php
    }
    ?>
  </tbody>
  </table>



<script>
function caseNonvide(id){
  if($(id).val() == ""){
    $(id + "Mess").html("Veuillez renseigner ce champ");
    return false;
  }else{
    return true;
  }
}
function verifMdp(){
  if($("#mdp1").val() === $("#mdp2").val()){
    return true;
  }else{
    $("#mdpDiff").html("Les deux mots de passe doivent être identique");
    return false;
  }
}
function verifConnex(){
  var nom = caseNonvide("#nomMembre");
  var mdp1 = caseNonvide("#mdp1");
  var mdp2 = caseNonvide("#mdp2");
  var mdp = verifMdp();

  return nom && mdp1 && mdp2 && mdp;
}
  $(document).ready(function(){
    $('.matable').tablesorter();

      $("#touslesmembres").on("click", function(){
        if($("#touslesmembres").html() == "Voir la liste"){
          $("#listemembres").show();
          $("#touslesmembres").html("Cacher la liste");
        }else{
          $("#listemembres").hide();
          $("#touslesmembres").html("Voir la liste");
        }
      });

      //aller directement à la page d'une personne après l'avir recherhcée dans la dataliste
      $('.goToPage').on('click', function(){
        var reg = /\(\d+\)/;
        var value = $('#inputMembres')[0].value.match(reg);
        var id = value[0].match(/\d+/);
        window.location = "https://www.comptoirdeslangues.fr/test/NEW_elearning/4saisons/utilities/session/pageMembre.php?id=" + id[0];
      });
  });
</script>

<?php require_once('../footer.php');
