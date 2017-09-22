<?php
session_start();
// get database connection
include_once './config/database.php';

// instantiate product object
include_once './objects/utente.php';

$database = new Database();
$db = $database->getConnection();
$user = new Utente($db);

if (isset($_POST["username"]) && isset($_POST["password"])) {
  $username = $_POST["username"];
  $password = $_POST["password"];
  if ($user->is_password_correct($username, $password)) {
    if (isset($_SESSION)) {
      session_destroy();
      session_regenerate_id(TRUE);
      session_start();
    }
    $_SESSION["username"] = $username;     # start session, remember user info
    $user->redirect("../post/home.php", "Login successful! Welcome back.");
  } else {
    echo "Esco subito";
    $user->redirect("../index.php", "Incorrect user name and/or password.");
  }
}
?>
