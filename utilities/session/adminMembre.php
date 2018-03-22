<?php
if($_SESSION['membre']->droit == 1){//Si le memebre connecté est un membre...
  if($membre->estCreateur() && $membre->pseudo != 'admin' && $membre->id != $_SESSION['membre']->id){
  ?>
  <div class="adminForm">
    <form method="POST" action="traitement.php">
      <input type="hidden" name="id" value="<?= $membre->id; ?>" />
      <input type="hidden" name="typeForm" value="bannir" />
      <input type="submit" value="Suspendre l'activité de ce membre" class="admin"/>
    </form>
  </div>
  <?php
  }//Fin de ban
  if($membre->droit == 2){
  ?>
  <div class="adminForm">
    <form method="POST" action="traitement.php">
      <input type="hidden" name="id" value="<?= $membre->id; ?>" />
      <input type="hidden" name="typeForm" value="rendreAdmin" />
      <input type="submit" value="Etendre les droits d'administrateur" class="admin"/>
    </form>
  </div>
  <?php
  }//Fin etendre les droits
  if($membre->droit == 1 && $membre->pseudo != 'admin' && $membre->id != $_SESSION['membre']->id){
    ?>
    <div class="adminForm">
      <form method="POST" action="traitement.php">
        <input type="hidden" name="id" value="<?= $membre->id; ?>" />
        <input type="hidden" name="typeForm" value="retireAdmin" />
        <input type="submit" value="Retirer les droits d'admin" class="admin"/>
      </form>
    </div>
    <?php
  }//Fin retirer les droits d'admin
  if($membre->droit == 3){
    ?>
    <div class="adminForm">
      <form method="POST" action="traitement.php">
        <input type="hidden" name="id" value="<?= $membre->id; ?>" />
        <input type="hidden" name="typeForm" value="retireBan" />
        <input type="submit" value="Retirer le ban" class="admin"/>
      </form>
    </div>
    <?php
  }//fin retirer le ban
}
?>
<?php
//Reset le mot de passe
if($_SESSION['membre']->droit == 1 && $_SESSION['membre']->id != $_GET['id']){
  ?>
  <div class="adminForm">
      <form method="POST" action="traitement.php">
        <input type="hidden" name="id" value="<?= $membre->id; ?>" />
        <input type="hidden" name="typeForm" value="resetMdp" />
        <input type="submit" value="Réinitialiser le mot de passe" class="admin"/>
      </form>
    </div>
  <?php
}
?>
