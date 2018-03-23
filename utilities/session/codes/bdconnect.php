<?php
//Fonction de connexion
function conBD(){
  try{
	$bdd = new PDO('mysql:host=localhost;dbname=utilities;charset=utf8', 'root', 'root');
  $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  }catch (Exception $e){
          die('Erreur à la connexion: ' . $e->getMessage());
  }
  return $bdd;
}

function hashPassword($password){
 /*
				* Génération du sel, nécessite l'extension PHP OpenSSL pour fonctionner.
				*
				* openssl_random_pseudo_bytes() va renvoyer n'importe quel type de caractères.
				* Or le chiffrement en blowfish nécessite un sel avec uniquement les caractères
				* a-z, A-Z ou 0-9.
				*
				* On utilise donc bin2hex() pour convertir en une chaîne hexadécimale le résultat,
				* qu'on tronque ensuite à 22 caractères pour être sûr d'obtenir la taille
				* nécessaire pour construire le sel du chiffrement en blowfish.
				*/

			 $salt = '$2y$11$'.substr(bin2hex(openssl_random_pseudo_bytes(32)), 0, 22);

								 // Voir la documentation de crypt() : http://devdocs.io/php/function.crypt
		 return crypt($password, $salt);
	 }
?>
