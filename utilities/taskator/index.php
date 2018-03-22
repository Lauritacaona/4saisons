<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once('classes/Page.class.php');
require_once('classes/Tache.class.php');
require_once('fonctions.php');

$romans = array(
  'saison1' => lireDossier('../../saison1'),
  'saison2' => lireDossier('../../saison2'),
  // 'saison3' => lireDossier('../../saison3'),
  // 'saison4' => lireDossier('../../saison4'),
);

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Taskator</title>
</head>
<body>
  <h1>Taskator</h1>
  <hr>


  <div>
      rien d'excitant pour le moment
      <h2>Sélectionez un roman...</h2>

      <div class="listeClaps">
        <?php
        foreach($romans as $saison => $claps){
          ?>
          <h3 class="nomSaison"><?= $saison;?></h3>
          <ul>
            <?php
            for($i=0; $i<count($claps); $i++){
              ?>
              <li>
                <a href="roman.php?saison=<?=$saison;?>&clap=<?=$claps[$i];?>">
                  <?=str_replace("-", " ", $claps[$i]);?>
                </a>
              </li>
              <?php
            }
            ?>
          </ul>
          <?php
        }
        ?>
      </div>
  </div>
</body>
</html>
