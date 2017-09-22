<?php
session_start();
// get database connection
include_once './config/database.php';

// instantiate product object
include_once './objects/post.php';

$database = new Database();
$db = $database->getConnection();
$post = new Post($db);

if (isset($_POST["id_post"])) {
  $id_post = $_POST['id_post'];
  $username = $_SESSION['username'];
  $result = $post->getPost($id_post);
  if($result){
    if($result[0]['utente'] == $username){
      if($post->deleteCommentsOf($id_post)){
        $post->redirect("../post/view-post.php?id=".$id_post, "You have reset comments");
      } else {
        $post->redirect("../post/view-post.php?id=".$id_post, "It was not possible to complete your action, try again later.");
      }
    } else {
      $post->redirect("../post/view-post.php?id=".$id_post, "You are not the owner of post.");
    }
  } else {
    $post->redirect("../post/home.php", "Post not found!");
  }
} else {
  $post->redirect("../post/view-post.php?id=".$id_post, "Invalid input.");
}
?>
