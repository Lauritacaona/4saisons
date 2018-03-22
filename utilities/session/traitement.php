<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
require_once("autoload.php");
session_start();
require_once("codes/daoMembre.php");
//echo "Eh oh";


switch ($_REQUEST['typeForm']) {
  case 'connexion':
  //echo "Eh oh";
    $reponse = connexionMembre();
    echo "Coucou";
    //var_dump($_SESSION);;
    if($reponse){
      //Retourner à la page correspondant à son offre

      header("Location:../index.php");
    }else{
      $message = "Identifiant ou mot de passe incorrect";
      header("Location:../index.php?connect=" . $message);
    }
    break;

    case 'deconnexion':
      session_destroy();
      $message = "A bientot sur le datacreator.";
      header("Location:../index.php?deconnect=" . $message);
      break;

    case 'bannir':
      $id = changeDroit($_POST['id'], 3);
      header('Location:pageMembre.php?id=' .$id);
    break;

    case 'retireBan':
      $id = changeDroit($_POST['id'], 2);
      header('Location:pageMembre.php?id=' .$id);
    break;

    case 'rendreAdmin':
      $id = changeAdmin($_POST['id'], 1);//1 true
      header('Location:pageMembre.php?id=' .$id);
    break;

    case 'retireAdmin':
      $id = changeAdmin($_POST['id'], 2);//0 false
      header('Location:pageMembre.php?id=' .$id);
    break;

    case 'ajouterMembre':
    //var_dump($_SESSION['']);
      $id = ajouteMembre();
      //header('Location:ajouterMembre.php');
      header("Location:pageMembre.php?id=" . $id);
    break;

    case 'changeCrea':
    //var_dump($_GET);
      $id = changeCrea($_GET['droit'], $_GET['val'], $_GET['id']);
      header("Location:pageMembre.php?id=" . $id);
    break;

    case 'modifTexte':
      $id = modifTexte($_POST['aModifier'], $_POST['newText']);
      header("Location:pageMembre.php?id=" . $id);
    break;

    case 'modifMdp':
      $id = modifMdp();
      header("Location:pageMembre.php?id=" . $id);
    break;

    case 'resetMdp':
      $id = resetMdp($_POST['id']);
      echo "C'est ok. id : " . $id;
      header("Location:pageMembre.php?id=" . $id);
    break;
  default:
    # code...
    break;
}
