<?php
session_start();
// get database connection
include_once './config/database.php';

// instantiate product object
include_once './objects/utente.php';

$database = new Database();
$db = $database->getConnection();
$user = new Utente($db);

if (isset($_POST["username"]) && isset($_POST["password"]) && isset($_POST["password_confirm"])) {
  $username = $_POST["username"];
  $password = $_POST["password"];
  $password_confirm = $_POST["password_confirm"];
  $datai = date('Y/m/d');
  if($password === $password_confirm){
    if (!$user->is_username_present($username)) {
      $password = password_hash($password, PASSWORD_DEFAULT);
      if($user->insert_user($username, $password, $datai)){
        if (isset($_SESSION)) {
          session_destroy();
          session_regenerate_id(TRUE);
          session_start();
        }
        $_SESSION["username"] = $username;     # start session, remember user info
        $user->redirect("../post/home.php", "Signup successful! Welcome!.");
      }else {
        $user->redirect("../index.php", "It was not possible to complete the registration, try again later.");
      }
    } else {
      $user->redirect("../index.php", "The username is already registered.");
    }
  }else{
    $user->redirect("../index.php", "Passwords do not match.");
  }
}
?>
