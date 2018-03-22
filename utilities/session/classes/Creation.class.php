<?php
class Creation{
  public $id;
  public $idMembre;
  public $dateCreation;
  public $saison;
  public $roman;
  public $nomPage;
  public $sousTitre;
  public $template;

  public function __construct(){}

  // Pour l'affichage dans un tableau à refaire...
  public function tabListe(){
    echo "<td>" . $this->saison . "</td>";
    echo "<td>" . $this->roman . "</td>";
    echo "<td>" . $this->nomPage . "</td>";
    echo "<td>" . $this->sousTitre . "</td>";
    echo "<td>" . $this->template . "</td>";
    echo "<td>" . $this->dateCreation . "</td>";
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
}
