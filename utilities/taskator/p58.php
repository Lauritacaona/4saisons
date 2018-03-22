<?php

$tab = array(
  "sequence" => 4,
  "type" => "exercice",
  'description' => "salut les amis",
  "taches" => array(
    "tache1" => array(
      'description' => 'créer un fond',
      'responsable' => 19,
      'etat_progression' => "en cours",
      'etat_validation' => array(
        'Vincent' => false,
        'Michel' => true,
        'MAC'=> false
      ),
      'taskeurs' => array(19, 22, 45),
    ),
    "tache2" => array(
      'description' => 'Changer la coupe de cheveux de Miss Blunder',
      'responsable' => 19,
      'etat_progression' => "fait",
      'etat_validation' => array(
        'Vincent' => false,
        'Michel' => true,
        'MAC'=> false
      ),
      'taskeurs' => array(19, 22, 45),
    ),
  ),
);

echo json_encode($tab);
