<?php
session_start();
// get database connection
include_once './config/database.php';

// instantiate product object
include_once './objects/utente.php';

$database = new Database();
$db = $database->getConnection();
$user = new Utente($db);
session_destroy();
session_regenerate_id(TRUE);
session_start();
$user->redirect("../index.php", "Logout successful.");
?>
