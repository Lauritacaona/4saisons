<?php
require_once('Membre.class.php');
require_once('fonctions.php');
//Fichier de classe pour une tache
//Les taches sont dans une classe plus générale qui s'apellerait Page ?
class Tache{
  // $titre; //string
  // $description; //string
  // $responsable; //int
  // $progression; // string
  // $validation; //array  associatif (des nom associés à des booleens)
  // $taskeurs; //array (id de chaque taskeur)

  public function __construct(array $tab = array()){
    if(!empty($tab)){
      foreach($tab as $cle => $valeur){
        $this->{$cle} = $valeur;
      }
      if(!isset($tab['progression'])){
        $this->{'progression'} = "non commencée";
      }
      if(!isset($tab['validation'])){
        $this->{'validation'} = array(
          'Vincent' => false,
          'Michel' => false,
          'MAC' => false,
        );
      }
    }else{
      $this->{'titre'} = "";
      $this->{'description'} = "";
      $this->{'responsable'} = "";
      $this->{'progression'} = "non commencée";
      $this->{'validation'} = array(
        'Vincent' => false,
        'Michel' => false,
        'MAC' => false,
      );
      $this->{'taskeurs'} = array();

    }
  }

  public function getProgression(){
    if($this->progression == "non commencée"){
      return 0;
    }elseif($this->progression == "en cours"){
      return 1;
    }else{
      return 2;
    }
  }
//On récupere les membres
  public function getTaskeurs(){
    if(isset($this->{'taskeurs'}) || count($this->taskeurs) > 0){
      $noms = array();
      for($i=0; $i<count($this->taskeurs); $i++){
        $membre = getMembre($this->taskeurs[$i]);
        $noms[] = $membre->fullName;
      }
      return implode(', ', $noms);
    }else{
      return "Personne pour cette tache";
    }
  }

  //On récuperation du nom du reponsable
  public function getNomResp(){
    $membreResp = getMembre($this->responsable);
    return $membreResp->fullName;
  }

}
//lancer une exception si l'objet est vide ?
