<?php
//Chargement de(s) la classe et demarrage de la session
function chargeurClasses($class){
  include 'classes/' . $class . '.class.php';
}
spl_autoload_register('chargeurClasses');
?>
