<?php
function afficheMess($message){
  if(isset($_GET[$message])){
    echo '<p class="message">' . $_GET[$message] . '</p>';
  }
}
function preDump($elem){
  echo '<pre>';
  var_dump($elem);
  echo '</pre>';
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" />

	<title>dataCreator</title>
  <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
	<script
	src="https://code.jquery.com/jquery-2.2.4.min.js"
	integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44="
	crossorigin="anonymous"></script>
  <!-- <script src="js/functions.js"></script> -->
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script src="<?= $dirSession; ?>jquery.tablesorter.min.js"></script>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css">
  <?php require_once("session/sessionstyle.php"); ?>

</head>

<body>
  <div class="container-fluid">
    <div class="col-sm-10 col-sm-offset-1">
      <header>
        <?php
        require("session/connexion.php");
        ?>
      </header>
