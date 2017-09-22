<?php
session_start();
// get database connection
include_once './config/database.php';

// instantiate product object
include_once './objects/post.php';

$database = new Database();
$db = $database->getConnection();
$post = new Post($db);

if (isset($_POST["id"]) && isset($_POST["messaggio"])) {
  $id_post = $_POST['id'];
  $messaggio = $_POST['messaggio'];
  $username = $_SESSION['username'];
  $data = date('Y/m/d');
  $ora = date('H:i:s');
  if($post->checkPost($id_post)){
    if($post->validateComment($messaggio)){
      if($post->insert_comment($id_post, $messaggio, $username, $data, $ora)){
        $post->redirect("../post/view-post.php?id=".$id_post, "You have posted a comment");
      } else {
        $post->redirect("../post/view-post.php?id=".$id_post, "It was not possible to complete your action, try again later.");
      }
    } else {
      $post->redirect("../post/view-post.php?id=".$id_post, "Invalid comment");
    }
  } else {
    $post->redirect("../post/home.php", "Post not found!");
  }
} else {
  $post->redirect("../post/view-post.php?id=".$id_post, "Invalid form.");
}
?>
