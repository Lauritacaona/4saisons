<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once('classes/Membre.class.php');
require_once('classes/Page.class.php');
require_once('classes/Tache.class.php');
require_once('fonctions.php');

predump($_REQUEST);

switch($_REQUEST['typeForm']){
  case 'modifPage':
    $ok = modifPage($_REQUEST);
    header('Location:page.php?action=affiche&saison='.$_REQUEST['saison'].'&clap='.$_REQUEST['clap'].'&page='.$_REQUEST['numPage']);
  break;

  default;
  header('Location:index.php');
}
