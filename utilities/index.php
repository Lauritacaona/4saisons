<?php
//error_reporting(E_ALL);
//ini_set("display_errors", 1);
require_once("session/autoload.php");
session_start();
$dirSession = "session/";
$dirPrincipal = "";
require_once("header.php");

require_once('../connexionPDO.php');

$query =
"
	SELECT COUNT(*) AS allUnsolvedErrors
	FROM contact_anomalie
	WHERE treatmentStage = 'unsolved'
";
$resultSet = $bdd->prepare($query);
$resultSet->execute();
$errors = $resultSet->fetch(PDO::FETCH_ASSOC);
?>
	<!--h1 class="text-center">WELCOME TO ZE DATACREATOR</h1-->

	<!-- Affichage du datacreator si le membre est bien connecté  -->
	<?php
	if(isset($_SESSION['membre'])){
		var_dump($_SESSION);

		}else{
			echo '<p class="text-center">Vous ne pouvez pas utiliser le datacreator. Contactez un administrateur pour en discuter </p>';
		//fin de "estCreateur"
	}
	?>

<?php require_once("footer.php"); ?>
