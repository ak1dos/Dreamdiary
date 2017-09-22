<?php
// get database connection
include_once './config/database.php';

// instantiate product object
include_once './objects/post.php';
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
// initialize object
$post = new Post($db);

if (isset($_POST["id_post"])){
  $id_post = $_POST["id_post"];
  $comments = $post->getComments($id_post);
  if($comments){
    echo json_encode($comments);
  } else {
    echo json_encode(
        array("message" => "false")
    );
  }
}
?>
