<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once('classes/Membre.class.php');
require_once('classes/Page.class.php');
require_once('classes/Tache.class.php');
require_once('../session/codes/bdconnect.php');
function predump($e){
  echo '<pre>';
  var_dump($e);
  echo '</pre>';
}

//Fonction de lecture dans un dossier
function lireDossier($dossier){
  if ($handle = @opendir($dossier)){// '@' enlève le warning si le dossier n'existe pas
    $tab = array();
    /* Ceci est la façon correcte de traverser un dossier. */
    while (false !== ($entry = readdir($handle))) {
      if ($entry != "." && $entry != ".." && $entry != ".DS_Store") {
          $tab[] = $entry;
      }
    }
    closedir($handle);
    return $tab;
  }else{
    return null;
  }

}

//fonction qui permet d'avoir la description des pages du dossier tache et qui les range dans l'ordre croissant.
//Paramètre : le dossier de taches
//Retour : un tableau de...
function listeAppercuPage($dossier){
  $fichiers = lireDossier($dossier);
  $tabRetour = array();

  $motif = '/[0-9]+/';
  for($i=0; $i<count($fichiers); $i++){
    preg_match($motif, $fichiers[$i], $matches);
    $tabRetour[intval($matches[0])] = new Page($dossier.'/'.$fichiers[$i]);
  }
  return $tabRetour;
}

//Fonction qui crée/modifie ? le contenu d'une page
function modifPage($tab){
  $page = new Page('../../'.$tab['saison'].'/'.$tab['clap'].'/taches/t'.$tab['numPage'].'.json');

  $page->sequence = $tab['sequence'];
  $page->type = $tab['typePage'];
  $page->description = $tab['descPage'];

  foreach($tab['taches'] as $n => $info){
    $page->taches['tache'.$n] = new Tache($tab['taches'][$n]);
  }
  $page->toJson();
  return true;
}

////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////// FONCTIONS SUR LA BASE ET LES MEMBRES////////////////////////
////////////////////////////////////////////////////////////////////////////////////////
//Fonction affichat la liste des MEMBRES
function getAllMembres(){
  $link = conBD();
  $req = $link->query("SELECT * FROM dataMembre ORDER BY pseudo ASC;");

  //$liste = array();
  while($membre = $req->fetchObject("Membre")){
    $liste[] = $membre;
  }
  $req->closeCursor();
  return $liste;
}

//Fonction récupérant un membre
function getMembre($id){
  $id = htmlspecialchars($id);

  $link = conBD();
  $req = $link->prepare("SELECT * FROM dataMembre WHERE id = :id ;");
  $req->execute(array(":id" => $id));

  if($req->rowCount() == 1){
    $membre = $req->fetchObject("Membre");
    $membre->cacheMdp();
  }else{
    $element = $req->fetchAll();
    return new Membre();
    //header("Location:../index.php");
  }
  $req->closeCursor();
  return $membre;
}
