<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once('classes/Page.class.php');
require_once('classes/Tache.class.php');
require_once('fonctions.php');

if(!isset($_GET['clap'])){
  header('Location:index.php');
}
predump($_GET);
$saison = $_GET['saison'];
$clap = $_GET['clap'];

$listeTaches = listeAppercuPage('../../'.$saison.'/'.$clap.'/taches');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Taskator - <?=str_replace("-", " ", $clap);?></title>
  <style>
  .ligneTache{
    background-color: lightPink;
  }
  </style>
</head>

<body>
  <h1>Taskator - <?=str_replace("-", " ", $clap);?></h1>
  <hr />

  <div class="listePages">
    <h2>Sélectionnez une page du clap "<?=str_replace("-", " ", $clap);?>"</h2>

    <table border="1px">
      <tr>
        <th>Page</th>
        <th>Type</th>
        <th>Description</th>
        <th>Nb. taches</th>
        <th>Modifier</th>
      </tr>
      <?php
      for($i=0; $i<count($listeTaches); $i++){
        if($listeTaches[$i]->nbTaches() < 1){
          echo '<tr>';
        }else{
          echo '<tr class="ligneTache">';
        }
        ?>
        <td>Page <?=$listeTaches[$i]->num;?></td>
        <td><?=$listeTaches[$i]->type;?></td>
        <td><?=$listeTaches[$i]->description;?></td>
        <td><?=$listeTaches[$i]->nbTaches();?></td>
        <td>
          <?php
          if($listeTaches[$i]->nbTaches() < 1){
            //Il n'y a que les admins qui ont le droit d'ajouter des infos ???
            ?>
            <a href="page.php?action=modif&saison=<?=$saison;?>&clap=<?=$clap;?>&page=<?=$listeTaches[$i]->num;?>">
              <button>Ajouter des informations</button>
            </a>
            <?php
          }else{
            ?>
            <a href="page.php?action=affiche&saison=<?=$saison;?>&clap=<?=$clap;?>&page=<?=$listeTaches[$i]->num;?>">
              <button>Voir le détail de la page</button>
            </a>
            <?php
          }
          ?>
        </td>
        <?php
        echo '</tr>';
      }
      ?>
    </table>
  </div>

</body>
</html>
