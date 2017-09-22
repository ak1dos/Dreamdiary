<?php
session_start();
// get database connection
include_once './config/database.php';

// instantiate product object
include_once './objects/post.php';

$database = new Database();
$db = $database->getConnection();
$post = new Post($db);

if (isset($_POST['id']) && isset($_POST["titolo"]) && isset($_POST["messaggio"])) {
  $id = $_POST['id'];
  $titolo = $_POST["titolo"];
  $messaggio = $_POST["messaggio"];
  $luogo = $_POST["luogo"];
  $username = $_SESSION["username"];
  $pubblico = 0;
  if(isset($_POST["pubblico"])){
    $pubblico = 1;
  }
  $datam = date('Y/m/d');
  $oram = date('H:i:s');
  if($post->validate($titolo, $messaggio, $luogo)){
    if(!$post->checkChanges($id, $titolo, $messaggio, $luogo, $pubblico)){
      if($post->update_post($id, $titolo, $messaggio, $luogo, $pubblico, $datam, $oram)){
        $post->redirect("../post/view-post.php?id=".$id, "Post has been updated.");
      } else {
        $post->redirect("../post/modify-post.php?id=".$id, "It was not possible to complete the your action, try again later.");
      }
    } else {
      $post->redirect("../post/modify-post.php?id=".$id, "Nothing to update");
    }
  } else {
    $post->redirect("../post/modify-post.php?id=".$id, "Form is invalid");
  }
} else {
  $post->redirect("../post/modify-post.php?id=".$id, "Set required input.");
}
?>
