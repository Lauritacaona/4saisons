<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

$fichier = fopen("../logs/connexions.txt", "r");

if($fichier){
  while(($tampon = fgets($fichier)) !== false){
    echo $tampon . "<br />";
  }
  if (!feof($fichier)) {
       echo "Erreur: fgets() a échoué\n";
   }
   fclose($fichier);
}

//Fonction dextraction d'informations contenues dans les logs
//Paramètres :
//idMembre = id du Membre  -- $nb = nombre de connexions qu'on veut afficher (s'il est egal à 0, on affiche tout)
function lectureConnexMembre($idMembre, $nb){
  $fichier = fopen("../logs/connexions.txt", "r");

  $tab = array();
  if($fichier){
    while(($ligne = fgets($fichier)) !== false){
      //On fait le decoupage des info ici
      $info = explode(';', $ligne);
      if($info[0] == $idMembre){
        $tab[] = $info;
      }
    }
    if (!feof($fichier)) {
         echo "Erreur: fgets() a échoué\n";
     }
     fclose($fichier);
  }
  if(count($tab) != 0){//Si le tableau n'est pas vide...
    if($nb == 0 || count($tab) <= $nb){
      for($i=(count($tab)-1); $i>= 0; $i--){
        $dateHeure = explode(' ', $tab[$i][2]);
        echo "Connexion le <b>" . $dateHeure[0] . "</b> à <b>" . $dateHeure[1] . "</b><br />";
      }
    }else{
      for($i=(count($tab)-1); $i>(count($tab)-($nb+1)); $i--){
        $dateHeure = explode(' ', $tab[$i][2]);
        echo "Connexion le <b>" . $dateHeure[0] . "</b> à <b>" . $dateHeure[1] . "</b><br />";
      }
    }
  }else{
    echo "<b>Jamais connecté</b>";
  }

}//fin de la fonction

lectureConnexMembre(19, 4);
if(isset($_GET["sex"])){
  var_dump($_GET);
}
?>
<form action="testLecturefichier.php">
<label>
  Sex:
  <input name=sex list=sexes>
  <datalist id=sexes>
  <option value="Female">
  <option value="Male">
  </datalist>
</label>
<input type="submit" />
</form>
