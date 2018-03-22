<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
require_once("autoload.php");
session_start();
$dirSession = "";
$dirPrincipal = "../";
require_once("codes/daoMembre.php");
require_once("codes/daoCreation.php");
//Si le membre n'est pas de type admin, il doit retourner à l'index
if(!isset($_SESSION['membre'])){
  header("Location:../index.php");
}else{
  if($_SESSION['membre']->droit != 1){
    header("Location:../index.php");
  }
}
require_once("switchListe.php");
require_once("../header.php");
?>

    <h1 class="text-center">Liste des datas crées ou modifiées</h1>

    <div class="blocChoix">
      <ul>
        <li><a href="listeDatasCrees.php?liste=membre">Par membre</a></li>
        <li><a href="listeDatasCrees.php?liste=template">Par template</a></li>
        <li class="saison">Par saison</li>
        <li id="calendrier"><a href="listeDatasCrees.php?liste=date">Par date de création</a></li>
      </ul>
      <ul id="listeSaisons">
        <li><a href="listeDatasCrees.php?liste=saison1">Saison 1</a></li><!--ajouter les romans de ces saisons-->
        <li><a href="listeDatasCrees.php?liste=saison2">Saison 2</a></li>
        <li><a href="listeDatasCrees.php?liste=saison3">Saison 3</a></li>
        <li><a href="listeDatasCrees.php?liste=saison4">Saison 4</a></li>
      </ul>
    </div>

    <div class="resultats">
      <h2><? if(isset($_GET['liste'])){ echo $_GET['liste'];} ?></h2>

      <?php
      include("choixDate.php");
      if(isset($_GET['liste']) || isset($_GET['datePrecise'])){
        echo '<table class="table-hover table-bordered table-responsive col-xs-12 matable">';
        echo "<thead>";
        echo "<tr>" . $liste[0] . "</tr>";
        echo "</thead>";
        echo '<tbody>';
        for($i=1; $i<count($liste); $i++){
          echo "<tr>" . $liste[$i] . "</tr>";
        }
        echo '</tbody>';
        echo "</table>";
      }

      //tableau special templates
      if(isset($_GET['template'])){
        echo "<h3>" .$_GET['template']. "</h3>";
        $liste2 = getTemplatePage($_GET['template']);
        echo '<table class="table-hover table-bordered table-responsive col-xs-12">';
        echo "<thead>";
        echo "<tr>" . $liste2[0] . "</tr>";
        echo "</thead>";
        echo '<tbody>';
        for($i=1; $i<count($liste2); $i++){
          echo "<tr>" . $liste2[$i] . "</tr>";
        }
        echo '</tbody>';
        echo "</table>";
      }
      ?>
    </div>

<script>
  $(document).ready(function(){
    $(".saison").on("click", function(){
      $("#listeSaisons").show();
    });
    $('.matable').tablesorter();
  });
</script>


<?php require_once("../footer.php");
