<?php
require_once("autoload.php");
require_once("bdconnect.php");

//Fonction créant un fichier et le remplit de texte
function ecritureFichier($doc, $texte){
  $fichier = fopen($doc, 'a+');
  $ok = fwrite($fichier, $texte);
  fclose($fichier);
}


//Fonction de changement de timestamp
function setTimeStamp(){
  $link = conBD();
  $req = $link->query("UPDATE dataMembre SET derniereConnexion = CURRENT_TIMESTAMP WHERE pseudo = '" . $_SESSION['membre']->pseudo ."'");
}

//Fonction de connexion d'un membre
function connexionMembre(){
  $pseudo = htmlspecialchars($_POST['pseudo']);
  $mdp = htmlspecialchars($_POST['mdp']);

  $link = conBD();//requete à refaire
  $req = $link->prepare("SELECT * FROM dataMembre WHERE pseudo=:pseudo;");
  $req->execute(array(':pseudo' => $pseudo));

  if($req->rowCount() !== 1){
    return false;
  }
  $membre = $req->fetchObject("Membre");
  $req->closeCursor();
  $hash = $membre->mdp;
 echo "Je suis ici";
  if(crypt($mdp,$hash) == $hash){
    // echo "c'est vrai";
    // echo "<pre>";
    // var_dump($donnee);
    // echo "</pre>";
    // echo "Je suis là";
    $texte = $membre->id . ";" . $membre->pseudo . ";" . date("Y-m-d H:i:s") . PHP_EOL;
    ecritureFichier("../logs/connexions.txt", $texte);
    $membre->cacheMdp();
    $_SESSION['membre'] = $membre;
    var_dump($_SESSION);
    setTimeStamp();

    return true;
  }else{
    return false;
  }
}

//Fonction affichat la liste des MEMBRES
function getAllMembres(){
  $link = conBD();
  $req = $link->query("SELECT * FROM dataMembre ORDER BY pseudo ASC;");

  //$liste = array();
  while($membre = $req->fetchObject("Membre")){
    $liste[] = $membre;
  }
  $req->closeCursor();
  return $liste;
}

//Fonction récupérant un membre
function getMembre($id){
  $id = htmlspecialchars($id);

  $link = conBD();
  $req = $link->prepare("SELECT * FROM dataMembre WHERE id = :id ;");
  $req->execute(array(":id" => $id));

  if($req->rowCount() == 1){
    $membre = $req->fetchObject("Membre");
    $membre->cacheMdp();
  }else{
    header("Location:../index.php");
  }
  $req->closeCursor();
  return $membre;
}

//Fonction bannir/ retirer le ban d'un membre
function changeDroit($id, $droit){
  $id = htmlspecialchars($id);
  $droit = htmlspecialchars($droit);
  $link =  conBD();
  $req = $link->prepare("UPDATE `dataMembre` SET `droit` = :droit WHERE `dataMembre`.`id` = :id;");
  $resultat = $req->execute(array(':droit' => $droit, ':id' => $id));
  if($resultat){
    return $id;
  }else{
    header("Location:pageMembre.php?id=" . $id . "&message=Erreur");
  }
}

//Fonction devenir/ne plus etre admin
function changeAdmin($id, $droit){
  $id = htmlspecialchars($id);
  $droit = htmlspecialchars($droit);

  $link = conBD();
  $req = $link->prepare("UPDATE dataMembre SET droit = :droit, paginator = 1, datacreator = 1, backgrounator = 1 WHERE id = :id");
  $resultat = $req->execute(array(':droit' => $droit, ':id' =>$id));
  $req->closeCursor();
  if($resultat){
    return $id;
  }else{
    header("Location:pageMembre.php?id=" . $id . "&message=Erreur");
  }
}

//Fonction d'ajout d'un membre
function ajouteMembre(){
  $pseudo = htmlspecialchars($_POST['pseudo']);
  $mdp1 = htmlspecialchars($_POST['mdp1']);
  $mdp2 = htmlspecialchars($_POST['mdp2']);
  $email = htmlspecialchars($_POST['email']);
  $fullName = htmlspecialchars($_POST['fullName']);
  $dev = htmlspecialchars($_POST['dev']);
  $droits = $_POST['creation'];
  //var_dump($droits);
  if((empty($pseudo) || empty($mdp1)) || empty($mdp2)){
    $message = "Veuillez remplir correctement le formulaire";
    header('Location:ajouterMembre.php?infogen' . $message);
  }
  if(count($droits) == 0){
    $message = "Veuillez cocher au moins une case";
    header('Location:ajouterMembre.php?droits' . $message);
  }
  if($mdp1 != $mdp2){
    $message = "Les mots de passes doivent être identiques";
    header('Location:ajouterMembre.php?infogen' . $message);
  }

  $pg = $droits['paginator'];
  $dc = $droits['datacreator'];
  $bg = $droits['backgrounator'];

  $link = conBD();
  $req = $link->prepare("INSERT INTO `dataMembre` (`id`, `pseudo`, `mdp`, `droit`, `derniereConnexion`, `paginator`, `datacreator`, `backgrounator`, email, fullName, dev) VALUES (NULL, :pseudo, :mdp, '2', CURRENT_TIMESTAMP, :paginator, :datacreator, :backgrounator, :email, :fullName, :dev);");
  $resultat = $req->execute(array(
                  ":pseudo" => $pseudo,
                  ":mdp" => hashPassword($mdp1),
                  ":paginator" => $pg,
                  ":datacreator" => $dc,
                  ":backgrounator" => $bg,
                  ":email" => $email,
                  ":fullName" => $fullName,
                  ":dev" => $dev));

  $req->closeCursor();
  if($resultat){
    $id = $link->lastInsertId();
    return $id;
  }else{
    $message = "Ce pseudo est déja pris";
    header('Location:ajouterMembre.php?infogen' . $message);
  }

}

//Fonction de modification des droits d'un membre
//Paramètres : $droit = pseudo du droit, $val = 1 ou 0, $id = id du membre
function changeCrea($droit, $val, $id){
  $droit = htmlspecialchars($droit);
  $val = htmlspecialchars($val);
  $id = htmlspecialchars($id);

  $link = conBd();
  $req =  $link->prepare("UPDATE dataMembre SET " . $droit ." = :val WHERE id = :id;");
  $resultat = $req->execute(array(':val' => $val, ':id' => $id));

  if($resultat){
    return $id;
  }else{
    $info = " une erreur s'est produite";//Il faudrait plutot une pge d'erreur dédiée...
    header('Location:pageMembre.php?id=' . $id . '&info=' . $info);
  }
}

//Fonction modifiant un champ de type texte dans la table dataMembre...
//Parametres : $typeTexte = nom du champ -
function modifTexte($typeTexte, $texte){
  $typeTexte = htmlspecialchars($typeTexte);
  $texte = htmlspecialchars($texte);
  $id = $_SESSION['membre']->id;

  $link = conBD();
  $req= $link->prepare("UPDATE dataMembre SET ".$typeTexte." = :texte WHERE id = :id");
  $resultat = $req->execute(array(':texte' => $texte, ':id' => $id));

  $req->closeCursor();

  if($resultat){
    if($typeTexte == "fullName"){
      $_SESSION['membre']->fullName = $texte;
    }
    if($typeTexte == "email"){
      $_SESSION['membre']->email = $texte;
    }
    return $id;
  }else{
    $info = " une erreur s'est produite";//Il faudrait plutot une pge d'erreur dédiée...
    header('Location:pageMembre.php?id=' . $id . '&info=' . $info);
  }
}

//Fonction pour changer de mot de passe
function modifMdp(){
  $id = $_SESSION['membre']->id;
  $oldMdp = htmlspecialchars($_POST['oldMdp']);
  $newMdp1 = htmlspecialchars($_POST['newMdp1']);
  $newMdp2 = htmlspecialchars($_POST['newMdp2']);
  if($newMdp1 != $newMdp2 || $newMdp1 == ''){
    $info = "Les mots de passe ne sont pas identiques ou sont vides.";
    header('Location:erreur.php?info='.$info);
  }

  $link = conBD();
  $req = $link->query("SELECT mdp FROM dataMembre WHERE id = ".$id.";");
  $membre = $req->fetchObject('Membre');
  $req->closeCursor();

  $hash = $membre->mdp;
  if(crypt($oldMdp,$hash) == $hash){
    $req = $link->prepare("UPDATE dataMembre SET mdp = :mdp WHERE id= :id");
    $resultat = $req->execute(array(":mdp" => hashPassword($newMdp1), ":id"=>$id));
    if($resultat){
      return $id;
    }else{
      $info = "Une erreur s'est produite.";
      header('Location:erreur.php?info='.$info);
    }
  }else{
    $info = "Mauvais ancien mot de passe. Contactez un administrateur pour changer de mot de passe si vous l'avez oublié.";
    header('Location:erreur.php?info='.$info);
  }

}

//Fonction reset du mot de passe
function resetMdp($id){
  $id= htmlspecialchars($id);
  $link = conBD();
  $req = $link->prepare("UPDATE dataMembre SET mdp = :mdp WHERE id= :id");
  $resultat = $req->execute(array(":mdp" => hashPassword("mdp"), ":id"=>$id));
  if($resultat){
    return $id;
  }else{
    $info = "Une erreur s'est produite.";
    //echo $info;
    header('Location:erreur.php?info='.$info);
  }
}
