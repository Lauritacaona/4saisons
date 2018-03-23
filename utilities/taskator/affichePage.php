<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="theme-color" content="#FFB6C1" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <title>Taskator</title>
  <style>
  .tache{
    padding: 5px;
    margin-bottom: 15px;
    background-color: WhiteSmoke;
    border-radius: 3px;
    border: solid lightgrey 1px;
  }
  </style>
</head>
<body>
  <div class="container-fluid">
    <div class="entete">
      <div class="navigation">
        <p class="col-xs-6 text-left">
          <a href="page.php?action=affiche&saison=<?=$saison;?>&clap=<?=$clap;?>&page=<?=$num-1;?>">
            << Page précedente
          </a>
        </p>
        <p class="col-xs-6 text-right">
          <a href="page.php?action=affiche&saison=<?=$saison;?>&clap=<?=$clap;?>&page=<?=$num+1;?>">
            Page suivante >></a>
        </p>
      </div>
      <h1>Taches de la page <?=$num;?> de <?=str_replace("-", " ", $clap);?></h1>
      <a href="page.php?action=modif&saison=<?=$saison;?>&clap=<?=$clap;?>&page=<?=$num;?>">Modifier le contenu de la page et/ou des taches</a>
    </div>


    <hr />

    <div class="infosPages">
      <p><b>Type :</b> <?=$page->type;?></p>
      <p><b>Description :</b> <?=$page->description?></p>
      <p><b>Nombre de taches :</b> <?=$page->nbTaches();?></p>
      <ul>
        <?php $progressionPage = $page->progressionPage();?>
        <li>Non commencées : <?=$progressionPage[0];?> </li>
        <li>En cours : <?=$progressionPage[1];?></li>
        <li>Terminées : <?=$progressionPage[2];?></li>
      </ul>
    </div>

    <!-- ICI LES TACHEEEEESSSSS -->
    <div class="listeTaches">
      <?php
      if($page->nbTaches() > 0){
        $cpt = 0;
        foreach ($page->taches as $cle => $tache){
          ?>
          <div class="col-md-6">
            <div class="tache progress<?=$tache->getProgression();?>" id="<?=$cle;?>">
              <a href="page.php?action=tache&saison=<?=$_GET['saison']?>&clap=<?=$_GET['clap']?>&cle_tache=<?=$cle;?>&page=<?= $_GET['page']?>">voir la tache</a>
              <h3 class="text-center"><?=$tache->titre;?></h3>
              <p><b>Description de la tache :</b> <?=$tache->description;?></p>
              <p><b>Responsable : </b><?=$tache->getNomResp();?></p>
              <p><b>Etat de la progression : </b><?=$tache->progression;?></p>
              <p><b>Taskeurs : </b><?=$tache->getTaskeurs();?></p>
            </div>
          </div>
          <?php
          $cpt++;
          if($cpt%2 == 0){
            echo '<div class="row"></div>';
          }
        }
      }else{
        ?>
        <h3>Aucune tache pour le moment</h3>
        <p>
          <a href="page.php?action=modif&saison=<?=$saison;?>&clap=<?=$clap;?>&page=<?=$num;?>">
            Ajouter des taches...
          </a>
        </p>
        <?php
      }
      ?>

    </div>

  </div>

</body>
</html>
