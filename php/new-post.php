<?php
session_start();
// get database connection
include_once './config/database.php';

// instantiate product object
include_once './objects/post.php';

$database = new Database();
$db = $database->getConnection();
$post = new Post($db);

if (isset($_POST["titolo"]) && isset($_POST["messaggio"])) {
  $titolo = $_POST["titolo"];
  $messaggio = $_POST["messaggio"];
  $luogo = $_POST["luogo"];
  $username = $_SESSION["username"];
  $pubblico = 0;
  if(isset($_POST["pubblico"])){
    $pubblico = 1;
  }
  $datac = date('Y/m/d');
  $orac = date('H:i:s');
  if($post->validate($titolo, $messaggio, $luogo)){
    if($post->insert_post($titolo, $messaggio, $luogo, $username, $pubblico, $datac, $orac)){
      $post->redirect("../post/home.php", "Post has been added.");
    } else {
      $post->redirect("../post/home.php", "It was not possible to complete the your action, try again later.");
    }
  } else {
    $post->redirect("../post/home.php", "Invalid form.");
  }
} else {
  $post->redirect("../post/home.php", "Invalid form.");
}
?>
