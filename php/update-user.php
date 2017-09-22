<?php
session_start();
// get database connection
include_once './config/database.php';

// instantiate product object
include_once './objects/utente.php';

$database = new Database();
$db = $database->getConnection();
$user = new Utente($db);

if (isset($_POST['email']) && isset($_POST["nome"]) && isset($_POST["cognome"]) && isset($_POST["descrizione"]) && isset($_POST["residenza"])) {
  $email = $_POST['email'];
  $nome = $_POST["nome"];
  $cognome = $_POST["cognome"];
  $descrizione = $_POST["descrizione"];
  $username = $_SESSION["username"];
  $residenza = $_POST["residenza"];
  if($user->validate($email, $nome, $cognome, $descrizione, $residenza)){
    if(!$user->checkChanges($username, $email, $nome, $cognome, $descrizione, $residenza)){
      if($user->update_user($username, $email, $nome, $cognome, $descrizione, $residenza)){
        $user->redirect("../utente/myaccount.php", "User info has been updated.");
      } else {
        echo "fallito";
        //$user->redirect("../utente/myaccount.php", "It was not possible to complete the your action, try again later.");
      }
    } else {
      $user->redirect("../utente/myaccount.php", "Nothing to update");
    }
  } else {
    $user->redirect("../utente/myaccount.php", "Form is invalid");
  }
} else {
  $user->redirect("../utente/myaccount.php", "Set required input.");
}
?>
