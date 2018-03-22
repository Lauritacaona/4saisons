<?php
/*Fichier contenant les differentes fonctions permettant d'afficher le contenu
des fichiers de logs.
*/

//Fonction basique de lecture du fichier. rangement des infos dans un tableau
//Si on veut tout le monde idMembre = false
//Quoi qu'il arrive
function lireDoc($doc, $idMembre){
  $fichier = fopen($doc, "r");
  $tab = array();
  if($fichier){
    //Si on ne veut que les infos d'un membre
    if($idMembre != false){
      while(($ligne = fgets($fichier)) !== false){
        $info = explode(';', $ligne);
        if($info[0] == $idMembre){
          $tab[] = $info;
        }
      }
    }else{
      while(($ligne = fgets($fichier)) !== false){
        $info = explode(';', $ligne);
          $tab[] = $info;
    }

    if (!feof($fichier)) {
         echo "Erreur: fgets() a échoué\n";
     }
   }
   fclose($fichier);
  }
  return $tab;
}

//Fonction créant des contenus de tableaux rapidement avec le contenu d'une ligne explosée
function creeLigneTab($ligne){
  echo '<tr>';
  for($i=0; $i<count($ligne); $i++){
    echo '<td>' . $ligne[$i] . '</td>';
  }
  echo '</tr>';
}
//Fonction dextraction d'informations contenues dans les logs
//Paramètres :
//idMembre = id du Membre  -- $nb = nombre de connexions qu'on veut afficher (s'il est egal à 0, on affiche tout)
function lectureConnexMembre($idMembre, $nb){
  $tab = lireDoc("../../logs/connexions.txt", $idMembre);
  if(count($tab) != 0){//Si le tableau n'est pas vide...
    if($nb == 0 || count($tab) <= $nb){
      for($i=(count($tab)-1); $i>= 0; $i--){//On veut la dernière connexion en premier
        $dateHeure = explode(' ', $tab[$i][2]);
        echo "Connexion le <b>" . $dateHeure[0] . "</b> à <b>" . $dateHeure[1] . "</b><br />";
      }
    }else{
      for($i=(count($tab)-1); $i>(count($tab)-($nb+1)); $i--){
        $dateHeure = explode(' ', $tab[$i][2]);
        echo "Connexion le <b>" . $dateHeure[0] . "</b> à <b>" . $dateHeure[1] . "</b><br />";
      }
    }
  }else{
    echo "<b>Jamais connecté</b>";
  }

}//fin de la fonction

//Fontion affichant un certain nombre de dernieres connexions
function afficheLastConnex($nb){
  $tab = lireDoc("../../logs/connexions.txt", false);
  if(count($tab) != 0){//Si le tableau n'est pas vide...
    echo "<table>";
    if($nb == 0 || count($tab) <= $nb){//On affiche tout
      for($i=(count($tab)-1); $i>= 0; $i--){//On veut la dernière connexion en premier
        $dateHeure = explode(' ', $tab[$i][2]);
        echo "<tr><td><b>".$tab[$i][1]."</b></td><td>" . $dateHeure[0] . "</td><td>" . $dateHeure[1] . "</td></tr>";
      }
    }else{
      for($i=(count($tab)-1); $i>(count($tab)-($nb+1)); $i--){
        $dateHeure = explode(' ', $tab[$i][2]);
        echo "<tr><td><b>".$tab[$i][1]."</b></td><td>" . $dateHeure[0] . "</td><td>" . $dateHeure[1] . "</td></tr>";
      }
    }
    echo "</table>";
  }else{
    echo "<b>Pas de connexions</b>";
  }
}

//Fonction permettant la lecture des action de pagination effectuée par un membre.
//Paramètres :
//idMembre = id du Membre  -- $nb = nombre de lignes qu'on veut afficher (s'il est egal à 0, on affiche tout)
function lecturePagiMembre($idMembre, $nb){
  $tab = lireDoc("../../logs/paginator.txt", $idMembre);
  if(count($tab) != 0){//Si le tableau n'est pas vide...
    ?>
    <table class="table-responsive table-bordered table-hover tablePagi">
      <thead>
        <tr>
          <th>Action</th>
          <th>Page</th>
          <th>Saison</th>
          <th>Clap</th>
          <th>date</th>
        </tr>
      </thead>
      <tbody>
        <?php
        if($nb == 0 || count($tab) <= $nb){
          for($i=(count($tab)-1); $i>= 0; $i--){//On veut la dernière action en premier
            $rebus = array_shift($tab[$i]);
            $rebus = array_shift($tab[$i]);
            echo creeLigneTab($tab[$i]);
          }
        }else{
          for($i=(count($tab)-1); $i>(count($tab)-($nb+1)); $i--){
            $rebus = array_shift($tab[$i]);
            $rebus = array_shift($tab[$i]);
            echo creeLigneTab($tab[$i]);
          }
        }
        ?>
    </tbody>
    </table>
    <?php
  }else{
    echo "<b>N'a jamais paginé.</b>";
  }
}
//fonction qui ne s'occupe pas de savoir quel memebre en particulier a fait si ou ça
function afficheLastPagi($nb){
  $tab = lireDoc("../../logs/paginator.txt", $idMembre);
  if(count($tab) != 0){//Si le tableau n'est pas vide...
    ?>
    <table class="table-responsive table-bordered table-hover tablePagi">
      <thead>
        <tr>
          <th>User</th>
          <th>Action</th>
          <th>Page</th>
          <th>Saison</th>
          <th>Clap</th>
          <th>date</th>
        </tr>
      </thead>
      <tbody>
        <?php
        if($nb == 0 || count($tab) <= $nb){
          for($i=(count($tab)-1); $i>= 0; $i--){//On veut la dernière action en premier
            $rebus = array_shift($tab[$i]);
            echo creeLigneTab($tab[$i]);
          }
        }else{
          for($i=(count($tab)-1); $i>(count($tab)-($nb+1)); $i--){
            $rebus = array_shift($tab[$i]);
            echo creeLigneTab($tab[$i]);
          }
        }
        ?>
    </tbody>
    </table>
    <?php
  }else{
    echo "<b>Auvune pagination enregistrée.</b>";
  }
}

//fonction permmetant d'afficher les dernieres insertions de fonds
function afficheLastBg($nb){
  $tab = lireDoc("../../logs/backgroundator.txt", false);
  if(count($tab) != 0){//Si le tableau n'est pas vide...
    ?>
    <table class="table-responsive table-bordered table-hover tableBg col-sm-12">
      <thead>
        <tr>
          <th>User</th>
          <th>Saison</th>
          <th>Clap</th>
          <th>Fichier</th>
          <th>Date</th>
        </tr>
      </thead>
      <tbody>
        <?php
        if($nb == 0 || count($tab) <= $nb){
          for($i=(count($tab)-1); $i>= 0; $i--){//On veut la dernière action en premier
            $rebus = array_shift($tab[$i]);
            echo creeLigneTab($tab[$i]);
          }
        }else{
          for($i=(count($tab)-1); $i>(count($tab)-($nb+1)); $i--){
            $rebus = array_shift($tab[$i]);
            echo creeLigneTab($tab[$i]);
          }
        }
        ?>
    </tbody>
    </table>
    <?php
  }else{
    echo "<b>Auvune insertion de fond enregistrée.</b>";
  }
}

//fonction affichant les dernieres insertions de fond pour 1 Membre
function lectureBgMembre($idMembre, $nb){
  $tab = lireDoc("../../logs/backgroundator.txt", $idMembre);
  if(count($tab) != 0){//Si le tableau n'est pas vide...
    ?>
    <table class="table-responsive table-bordered table-hover tablePagi">
      <thead>
        <tr>
          <th>Saison</th>
          <th>Clap</th>
          <th>fichier</th>
          <th>date</th>
        </tr>
      </thead>
      <tbody>
        <?php
        if($nb == 0 || count($tab) <= $nb){
          for($i=(count($tab)-1); $i>= 0; $i--){//On veut la dernière action en premier
            $rebus = array_shift($tab[$i]);
            $rebus = array_shift($tab[$i]);
            echo creeLigneTab($tab[$i]);
          }
        }else{
          for($i=(count($tab)-1); $i>(count($tab)-($nb+1)); $i--){
            $rebus = array_shift($tab[$i]);
            $rebus = array_shift($tab[$i]);
            echo creeLigneTab($tab[$i]);
          }
        }
        ?>
    </tbody>
    </table>
    <?php
  }else{
    echo "<b>N'a jamais inséré de fond.</b>";
  }
}
/********************************** SWITCH pour AJAX ***********************************/
/********************************** SWITCH pour AJAX ***********************************/
/********************************** SWITCH pour AJAX ***********************************/
switch ($_POST['demande']) {
  case 'lectureConnexMembre':
    return lectureConnexMembre($_POST['idMembre'], $_POST['nbRes']);
  break;

  case 'lecturePagiMembre':
    return lecturePagiMembre($_POST['idMembre'], $_POST['nbRes']);
  break;

  case 'lectureBgMembre':
    return lectureBgMembre($_POST['idMembre'], $_POST['nbRes']);
  break;

  case 'afficheLastConnex':
    return afficheLastConnex($_POST['nbRes']);
  break;
  case 'afficheLastPagi':
    return afficheLastPagi($_POST['nbRes']);
  break;

  case 'afficheLastBg':
    return afficheLastBg($_POST['nbRes']);
  break;

  default:
    return "youpi";
  break;
}
