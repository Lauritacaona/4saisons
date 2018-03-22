<?php
require_once('Membre.class.php');
require_once('Tache.class.php');
//Classe des pages

class Page{
  // $num
  // $sequence;//int
  // $type;// array
  // $description;// string
  // $taches; // array de taches

  //Fonction permettant de creer des taches dans la page.
  public function tacheConstruct(){
    if(isset($this->taches)){
      foreach($this->taches as $cle => $tab){
        $this->taches[$cle] = new Tache($tab);
      }
    }
  }

  public function __construct($fichier){
    $this->{'emplacement'} = $fichier;
    $nomJson = explode('/', $fichier);
    $motif = '/[0-9]+/';
    preg_match($motif, $nomJson[count($nomJson)-1], $matches);
    $this->{'num'} = intval($matches[0]);
    $content = @file_get_contents($fichier);
    if($content === false){
      throw new Exception("Cette page n'existe pas", 1);
    }
    $tab = json_decode($content, true);
    if(!empty($tab)){
      foreach($tab as $cle => $valeur){
        $this->{$cle} = $valeur;
      }
      $this->tacheConstruct();
    }else{
      $this->{'sequence'} = "";
      $this->{'type'} = "";
      $this->{'description'} = "";
      $this->{'taches'} = array();
      // throw new Exception("Cette page ne contient pour le moment aucune information.");
    }
  }//fin du constructeur

  //fonction retournant le nombre de taches
  public function nbTaches(){
    return count($this->taches);
  }

  public function toJson(){
    foreach($this->taches as $cle => $tache){
      $this->taches[$cle] = (array) $tache;
    }
    $tab = (array) $this;

    $fichier = fopen($this->emplacement, 'w');//On écrase le contenu du fichier
    fwrite($fichier, json_encode($tab, JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP));
    fclose($fichier);
    //return json_encode($tab, JSON_HEX_APOS | JSON_HEX_QUOT);
  }

  public function progressionPage(){
    $tab = array(0, 0, 0); //[0]= taches non commencées, [1]=en cours, [2]=finies
    foreach($this->taches as $cle => $tache){
      $tab[$tache->getProgression()] = $tab[$tache->getProgression()] + 1;
    }
    return $tab;
  }

}

//Lancer une exception si l'objet est vide ?
