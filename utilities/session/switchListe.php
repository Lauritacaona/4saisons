<?php
$liste = array();
//$liste['membre'] = getAllMembres();
//var_dump($liste);
if(isset($_GET['liste'])){
  switch ($_GET['liste']) {
    case 'membre':
      $liste = getNbTemplateMembre();
      break;

    case 'template':
      $liste = getAllTemplates();
      break;

    case 'date':
      $liste = dataParDate(); //ressort les lignes d'un tableau
      break;

    case 'saison1':
      $liste = dataParSaisons("saison1"); //ressort les lignes d'un tableau
      break;

    case 'saison2':
      $liste = dataParSaisons("saison2"); //ressort les lignes d'un tableau
      break;

    case 'saison3':
      $liste = dataParSaisons("saison3"); //ressort les lignes d'un tableau
      break;

    case 'saison4':
      $liste = dataParSaisons("saison4"); //ressort les lignes d'un tableau
      break;

    default:
      # code...
      break;
  }
}

if(isset($_GET['datePrecise']) && isset($_GET['operateur'])){
  $liste = dataDatePrecise($_GET['operateur'], $_GET['datePrecise']);

}
?>
