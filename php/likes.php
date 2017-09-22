<?php
session_start();
// get database connection
include_once './config/database.php';

// instantiate product object
include_once './objects/post.php';
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
// initialize object
$post = new Post($db);

if (isset($_GET["id_post"])){
  $id_post = $_GET["id_post"];
  $username = $_SESSION["username"];
  if($post->checkLike($id_post, $username)){
    echo json_encode(
        array("message" => "delete")
    );
  } else {
    echo json_encode(
        array("message" => "add")
    );
  }
}

if (isset($_POST["get_users"])){
  $id_post = $_POST["get_users"];
  $users = $post->getLikeInfo($id_post);
  if($users){
    echo json_encode($users);
  } else {
    echo json_encode(
        array("message" => "false")
    );
  }
}

?>
