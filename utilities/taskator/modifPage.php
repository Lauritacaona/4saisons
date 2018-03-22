<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Taskator - Modifier une page</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <style>
  .supprTache{
    margin-bottom: 5px;
  }
  .nouvelleTache{
    display:none;
  }
  fieldset{
    border: solid lightgrey 1px !important;
    padding: 5px;
    background: linear-gradient(WhiteSmoke, white);
    margin-bottom: 10px;
  }
  .zoneTache fieldset{
    background: linear-gradient(aliceblue, white);
    border: solid skyblue 1px !important;
  }
  legend{
    border: none !important;
    width: auto;
    margin-bottom: 5px;
  }
  </style>
  </head>
<body>
  <div class="container-fluid">
  <h1>Créer/modifier le contenu de la page <?=$num;?> de <?=str_replace("-", " ", $clap);?></h1>
  <hr />

  <form class="page" action="traitement.php" method="POST">
    <div class="col-xs-12">
      <fieldset>
        <legend>Infos générales de la page</legend>
        <input type="hidden" name="typeForm" value="modifPage" />
        <input type="hidden" name="numPage" value="<?=$page->num;?>" />
        <input type="hidden" name="saison" value="<?=$saison;?>" />
        <input type="hidden" name="clap" value="<?=$clap;?>" />
        <div>
          <label for="sequence">Séquence : </label>
          <input type="number" name="sequence" value="<?=$page->sequence;?>"/><span>(si connue)</span>
        </div>
        <div>
          <label for="typePage">Type de page : </label>
          <input type="text" name="typePage" value="<?=$page->type;?>" />
        </div>
        <div>
          <label for="descPage">Description : </label>
          <textarea name="descPage"><?=$page->description;?></textarea>
        </div>
      </fieldset>
    </div>

    <!-- Zone des taches -->
    <?php
    $cpt = 1;
    if($page->nbTaches()>0){
      foreach ($page->taches as $key => $tache) {
        ?>
        <div class="col-md-6">
          <fieldset class="zoneTacheExistante" id="tacheExistante<?=$cpt;?>">
            <button type="button" class="supprTache">Supprimer cette tache</button>
            <legend class="tache">Tache #<?=$cpt;?></legend>
            <!-- titre -->
            <div>
              <label for="titretache">Titre : </label>
              <input type="text"  name="taches[<?=$cpt;?>][titre]" class="titreTache" value="<?=$tache->titre;?>" />
            </div>

            <div>
              <label for="descriptionTache">Description : </label>
              <textarea name="taches[<?=$cpt;?>][description]" class="descriptionTache" cols="40" rows="3"><?=$tache->description;?></textarea>
            </div>
  <!-- Responsable -->
            <div>
              <label for="responsableTache">Responsable : </label>
              <select name="taches[<?=$cpt;?>][responsable]" class="responsable">
                <?php
                $listeMembres = getAllMembres();
                for($i=0; $i<count($listeMembres); $i++){
                  if(!$listeMembres[$i]->dev){
                    if($listeMembres[$i]->id == $tache->responsable){
                      echo '<option value="'.$listeMembres[$i]->id.'" selected>'.$listeMembres[$i]->fullName.'</option>';
                    }else{
                    ?>
                    <option value="<?=$listeMembres[$i]->id;?>"><?=$listeMembres[$i]->fullName;?></option>
                    <?php
                    }
                  }
                }
                ?>
              </select>
            </div>
  <!-- Taskeurs -->
            <div>
              <label for="responsableTache">Responsable : </label>
              <select name="taches[<?=$cpt;?>][taskeurs][]" class="taskeurs" multiple>
                <?php
                for($i=0; $i<count($listeMembres); $i++){
                  if(!$listeMembres[$i]->dev){
                    if(in_array($listeMembres[$i]->id, $tache->taskeurs)){
                      echo '<option value="'.$listeMembres[$i]->id.'" selected>'.$listeMembres[$i]->fullName.'</option>';
                    }else{
                    ?>
                    <option value="<?=$listeMembres[$i]->id;?>"><?=$listeMembres[$i]->fullName;?></option>
                    <?php
                    }
                  }
                }
                ?>
              </select>
            </div>

          <!-- Progression -->
          <input type="hidden" name="taches[<?=$cpt;?>][etat]" value="<?=$tache->progression;?>" />

          <input type="hidden" name="taches[<?=$cpt;?>][validation][Vincent]" value="<?=$tache->validation['Vincent'];?>" />
          <input type="hidden" name="taches[<?=$cpt;?>][validation][Michel]" value="<?=$tache->validation['Michel'];?>" />
          <input type="hidden" name="taches[<?=$cpt;?>][validation][MAC]" value="<?=$tache->validation['MAC'];?>" />


          </fieldset>
        </div>
        <?php
        $cpt++;
      }
    }//Fin des taches existantes

    ?>
    <div class="row"></div>
    <!-- ICI POUR LES NOUVELLES TACHES -->

    <div class="zoneTache"></div>

    <div class="row col-xs-12 text-center">
      <button class="ajoutTache" type="button">Ajouter une tache</button>
      <input type="submit" value="Modifier les infos" class="valider" />
    </div>
  </form>


<!---On ne veut pas que cette div soit envoyée meme quand il n'y pas de nouvelles taches--->
<fieldset class="nouvelleTache">
  <legend class="tache">Nouvelle tache</legend>
  <div>
    <label for="titretache">Titre : </label>
    <input type="text"  name="taches[1][titre]" class="titreTache"/>
  </div>

  <div>
    <label for="descriptionTache">Description : </label>
    <textarea name="taches[1][description]" class="descriptionTache" cols="40" rows="3"></textarea>
  </div>

  <div>
    <label for="responsableTache">Responsable : </label>
    <select name="taches[1][responsable]" class="responsable">
      <?php
      $listeMembres = getAllMembres();
      for($i=0; $i<count($listeMembres); $i++){
        if(!$listeMembres[$i]->dev){
          ?>
          <option value="<?=$listeMembres[$i]->id;?>"><?=$listeMembres[$i]->fullName;?></option>
          <?php
        }
      }
      ?>
    </select>
  </div>

  <div>
    <label for="taskeurs">Taskeurs</label>
    <select class="taskeurs" name="taches[1][taskeurs][]" multiple>
      <?php
      for($i=0; $i<count($listeMembres); $i++){
        if(!$listeMembres[$i]->dev){
          //C'est qu'il est graphiste
          ?>
          <option value="<?=$listeMembres[$i]->id;?>"><?=$listeMembres[$i]->fullName;?></option>
          <?php
        }
      }
      ?>
    </select>
  </div>
</fieldset>

</div>
  <script>


  var ajoutTache = $(".nouvelleTache")[0].innerHTML;
  //Numero de la tache suivante
  var tache = <?=$cpt?>;
  var mafonction = function ajouteTache(){
    var fieldset = $(document.createElement('fieldset'));
    fieldset.prepend(ajoutTache);
    fieldset.addClass('tache'+ tache);

    var fieldsetDiv = $(document.createElement('div'));
    fieldsetDiv.prepend(fieldset);
    fieldsetDiv.addClass('zoneTache');
    fieldsetDiv.addClass('col-md-6');
    var prevSib = $('.zoneTache')[$('.zoneTache').length - 1];
    $(fieldsetDiv).insertAfter(prevSib);

    for(var i=0; i<$('.tache'+ tache)[0].elements.length; i++){
      var reg = /\[\d+\]/;
      var name = $('.tache'+ tache)[0].elements[i].name;
      name = name.replace(reg, '['+tache+']');
      $('.tache'+ tache)[0].elements[i].name = name;
    }
    //console.log($('.tache'+ tache)[0].elements);
    tache++;
  }
    $(document).ready(function(){
      $('.ajoutTache').on('click', mafonction);

      //Action du bouton valider
      //$('.valider').on('click', valider());
      $('.supprTache').on('click', function(){
        var parentId = $(this)[0].parentNode.id;
        $("#" + parentId).remove();
      });
    });


  </script>
</body>
</html>
