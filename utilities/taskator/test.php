<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once('classes/Page.class.php');
require_once('classes/Tache.class.php');

try{
  $page = new Page('../../saison2/miss-blunder/taches/t58.json');
  predump($page);

  echo $page->taches["tache1"]->getTaskeurs();

}catch(Exception $e){
  //
  echo $e->getMessage();
  echo "Souhaitez-vous ajouter des informations ?";
}

//$handle = fopen('tache1.json', 'a+');
// for($i=0; $i<105; $i++){
//   $fichier = fopen('../../saison2/miss-blunder/taches/t'.$i.'.json', 'a+');
// }
