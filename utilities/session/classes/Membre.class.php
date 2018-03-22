<?php
class Membre{
  public $id;
  public $pseudo;
  public $mdp;
  public $fullName;
  public $email;
  public $droit;
  public $derniereConnexion;
  public $paginator;
  public $datacreator;
  public $backgrounator;
  public $dev;

  public function __construct(){}

  //Fonction cachant le mot de passe.
  public function cacheMdp(){
    $this->mdp = "hihihi";
  }

  //Fonction permettant de savoir si le membre peut utiliser le datacreator
  public function estCreateur(){
    if($this->droit == 1 || $this->droit == 2){
      return true;
    }else{
      return false;
    }
  }

  //Fonction donnant le pseudo du droit
  public function getDroit(){
    if($this->droit == 1){
      return "Administrateur";
    }elseif ($this->droit == 2){
      return "Membre simple";
    }else{
      return "Membre à accès restreint";
    }
  }

  //Fonction de dataParDate
  public function getDate(){
    $dateComplete = explode(' ', $this->derniereConnexion);
    $date = explode('-', $dateComplete[0]);
    $heure = $dateComplete[1];

    switch ($date[1]) {
      case '01':
        $date[1] = 'janvier';
        break;
      case '02':
        $date[1] = 'février';
        break;
      case '03':
        $date[1] = 'mars';
        break;
      case '04':
        $date[1] = 'avril';
        break;
      case '05':
        $date[1] = 'mai';
        break;
      case '06':
        $date[1] = 'juin';
        break;
      case '07':
        $date[1] = 'juillet';
        break;
      case '08':
        $date[1] = 'août';
        break;
      case '09':
        $date[1] = 'septembre';
        break;
      case '10':
        $date[1] = 'octobre';
        break;
      case '11':
        $date[1] = 'novembre';
        break;
      case '12':
        $date[1] = 'décembre';
        break;
    }
    return $date[2] . ' ' . $date[1] . ' ' . $date[0] . ' à ' . $heure;
  }

  public function pagiToString(){
    if($this->paginator){
      return "Oui";
    }else{
      return "Non";
    }
  }
  public function dataToString(){
    if($this->datacreator){
      return "Oui";
    }else{
      return "Non";
    }
  }
  public function backToString(){
    if($this->backgrounator){
      return "Oui";
    }else{
      return "Non";
    }
  }

  //fonction donnant le lien de la page membre
  public function getLien(){
    return '<a href="pageMembre.php?id=' . $this->id . '">' . $this->pseudo . '</a>';
  }

  //Fonction affichant les droits des utilisateurs
  public function afficheDroits($currentUserDroit){
    $tab = array(
      "PAGINATOR" => array('paginator', $this->paginator),
      "BACKGROUND SELECTOR" => array('backgrounator', $this->backgrounator),
      "DATACREATOR" => array('datacreator', $this->datacreator),
    );
    foreach($tab as $nom => $tabMots){
      if($tabMots[1]){
        echo "<li>Peut utiliser le " . $nom ." ";
        if($currentUserDroit == 1){
          echo '<span class="modifier"><a href="traitement.php?typeForm=changeCrea&droit='.$tabMots[0].'&val=0&id='. $this->id .'">';
          echo 'retirer</a></span>';
        }
        echo '</li>';
      }else{
        echo "<li class='gris'>Ne peut pas utiliser le " . $nom ." ";
        if($currentUserDroit == 1){
          echo '<span class="modifier"><a href="traitement.php?typeForm=changeCrea&droit='.$tabMots[0].'&val=1&id='. $this->id .'">';
          echo 'ajouter</a></span>';
        }
        echo '</li>';
      }
    }
  }//fn afficheDroits
}
