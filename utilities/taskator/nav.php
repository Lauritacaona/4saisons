<?php require_once 'classes/laClasse.php'; ?>
<div class="col-xs-12">
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
