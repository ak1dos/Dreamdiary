<?php
session_start();
// verifies if the user is logged in
include_once '../php/config/database.php';
include_once '../php/objects/utente.php';
include_once '../php/objects/post.php';
$database = new Database();
$db = $database->getConnection();
$user = new Utente($db);
$user->ensure_logged_in();
$post = new Post($db);
include_once '../html/header-search-post.html';
$error = null;
if(isset($_SESSION['flash'])){
  $error = $_SESSION['flash'];
  unset($_SESSION['flash']);
}
?>
<div id="snackbar"><?=$error?></div>
<?php
if(isset($_GET['key'])){
  $key = $_GET['key'];
  $username = $_SESSION['username'];
  $result = $post->searchSimpleInfo($key, $username);
  if($result){
    ?>
    <div class="mdl-grid portfolio-max-width">
    <?php
      foreach ($result as $p) {
        if($p['utente'] == $username || $p['pubblico'] == 1){
        ?>
        <div id="<?=$p['id']?>"class="mdl-cell mdl-card mdl-shadow--4dp portfolio-card">
            <div class="mdl-card__title">
                <h2 class="mdl-card__title-text"><?=$p['titolo']?></h2>
            </div>
            <div class="mdl-card__supporting-text">
              <span class="mdl-chip mdl-chip--contact mdl-chip--deletable">
                <img class="mdl-chip__contact" src="../images/user.jpg"></img>
                <span class="mdl-chip__text"><?= $p['utente'] ?></span>
                <a href="../utente/view-user.php?id=<?= $p['utente'] ?>" class="mdl-chip__action"><i class="material-icons">forward</i></a>
              </span>
            <?php
              if($p['luogo']){
            ?>
              <span class="location mdl-chip mdl-chip--deletable">
                <span class="mdl-chip__text"><?= $p['luogo'] ?></span>
                <a href="#" class="mdl-chip__action"><i class="material-icons">location_on</i></a>
              </span>
            <?php
              } else {
            ?>
              <span class="location mdl-chip mdl-chip--deletable">
                <span class="mdl-chip__text">Non specificato</span>
                <a href="#" class="mdl-chip__action"><i class="material-icons">location_off</i></a>
              </span>
            <?php
              }
            ?>
            </div>
            <div class="mdl-card__actions mdl-card--border">
              <a href="./view-post.php?id=<?= $p['id']?>"class="openPost mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect mdl-button--accent">
                Vai al post
              </a>
            </div>
        </div>
        <?php
      }
    }
      ?>
    </div>
  <?php
  } else {
   ?>
   <h3>Non ci sono post che stai cercando</h3>
   <?php
  }
}else{
?>
<h3>Errore nella richiesta</h3>
 <<?php
}
include_once '../html/bottom.html';
 ?>
