<?php

// fichier avec les requires des classes
// oui l'auto load existe mais on fait ce qu'on veut
// on a eu un problème avec l'auto loader du coup voilà
require 'classes/laClasse.php';
?>


<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>details tache</title>
</head>
<body>
  <?php preDump($page->taches[$_GET['cle_tache']])?>
</body>
</html>
