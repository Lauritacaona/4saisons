<?php
  if(!isset($_SESSION['membre'])){
    //var_dump($_COOKIE);
?>
<div class="connexion class text-center">
  <h3>Connectez vous pour accéder au DATACREATOR</h3>
  <?php afficheMess('connect'); ?>
  <!--si le message est set, affiche le-->
  <form method="POST" action="session/traitement.php" onsubmit="return verifConnex();">
    <input type="hidden" name="typeForm" value="connexion" />
    <p>
      <label for="pseudo">Identifiant : </label>
      <input type="text" name="pseudo" id="pseudo" placeholder="ex : DatacreatorMaster" />

      <label for="mdp">Mot de passe : </label>
      <input type="password" name="mdp" id="mdp" />
    </p>
    <input type="submit" value="Connexion"/>
  </form>
  <p>Suite à un léger dysfonctionnement, utilisez "<b>mdp</b>" comme mot de passe. Vous pourrez le modifier en consultant votre page.</p>
</div>

<?php
}else{
  afficheMess('deconnect');
  ?>
  <div class="text-right">
    <p>
      Bonjour, <?= $_SESSION['membre']->pseudo; ?>.
      <?php

      echo '<a href="' . $dirPrincipal . 'index.php">Retour à l\'accueil</a> || ';
      echo '<a href="' . $dirSession . 'pageMembre.php?id=' . $_SESSION['membre']->id . '">Ma page</a> || ';
      echo '<a href="' . $dirSession . 'traitement.php?typeForm=deconnexion">Déconnexion</a>';
      ?>
    </p>
  </div>
  <div class="adminConnecte">
      <?php
          if($_SESSION['membre']->droit == 1){
            echo '<p class="ongletAdmin"><a href="' . $dirSession . 'ajouterMembre.php">Ajouter un membre/Voir tous les membres</a></p>';

            echo '<p class="ongletAdmin"><a href="' . $dirSession . 'vousEtesFiches.php">Voir les différents logs de l’utilitaire</a></p>';
          }
      ?>
  </div>
  <?php
}
?>
<script>
  function caseNonvide(id){
    if($(id).val() == ""){
      return false;
    }else{
      return true;
    }
  }

  function verifConnex(){
    return caseNonvide("#pseudo") && caseNonvide("#mdp");
    //return caseNonvide("#pseudo");
  }
</script>
