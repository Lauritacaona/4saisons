<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once('classes/Membre.class.php');
require_once('classes/Page.class.php');
require_once('classes/Tache.class.php');
require_once('fonctions.php');

if(!isset($_GET['clap'])){
  header('Location:index.php');
}
//predump($_GET);
$saison = $_GET['saison'];
$clap = $_GET['clap'];
$num = $_GET['page'];

try{
  $page = new Page('../../'.$saison.'/'.$clap.'/taches/t'.$num.'.json');
  //predump($page);

  switch($_GET['action']){
    case "affiche":
      require('affichePage.php');
    break;

    case "modif":
      //Si la personne n'est pas un admin, il faudra mettre ici une condition
      require('modifPage.php');
    break;

    default:
     header('Location:index.php');
  }

}catch(Exception $e){
  echo $e->getMessage();
  echo '<br /><a href="index.php">Retour à l’index</a>';
}
