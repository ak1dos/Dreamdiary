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
$error = null;
if(isset($_SESSION['flash'])){
  $error = $_SESSION['flash'];
  unset($_SESSION['flash']);
}
?>
<div id="snackbar"><?=$error?></div>
<?php
if(isset($_GET['id'])){
  include_once '../html/header-view-user.html';
  $username = $_GET['id'];
  $user_info = $user->getInfo($username);
  $recent = $post->getRecent($username);
  $popular = $post->getLiked($username);
  $commented = $post->getMostCommented($username);
  if($user_info){
    foreach ($user_info as $info) {
    ?>
    <div class="mdl-grid portfolio-max-width">
      <div class="user_info mdl-cell mdl-cell--12-col mdl-card mdl-shadow--2dp">
        <div class="mdl-card__title mdl-card--expand">
          <h2 class="mdl-card__title-text">Questo è il profilo di: <?=$info['username']?></h2>
        </div>
        <div class="mdl-card__supporting-text">
          <?php
          if($info['descrizione']) {?>
            <h4>Descrizione:</h4>
            <?=$info['descrizione']?>
            <?php
          }else{?>
          <h4>Non ha ancora aggiornato la sua descrizione!</h4>
          <?php
        } ?>
          <p class="dateRegistration">Iscritto il: <?= date("d-m-Y",strtotime($info['datai'])) ?></p>
        </div>
        <div class="mdl-card__actions mdl-card--border">
          <span class="mdl-chip mdl-chip--contact">
            <span class="mdl-chip__contact mdl-color--teal mdl-color-text--white">N</span>
            <span class="mdl-chip__text"><strong>Nome: </strong><?=$info['nome']?></span>
          </span>
          <span class="mdl-chip mdl-chip--contact">
            <span class="mdl-chip__contact mdl-color--teal mdl-color-text--white">C</span>
            <span class="mdl-chip__text"><strong>Cognome: </strong><?=$info['cognome']?></span>
          </span>
          <span class="mdl-chip mdl-chip--contact">
            <span class="mdl-chip__contact mdl-color--teal mdl-color-text--white">@</span>
            <span class="mdl-chip__text"><strong>Email: </strong><?=$info['email']?></span>
          </span>
          <?php
            if($info['residenza']){
          ?>
            <span class="location mdl-chip mdl-chip--deletable">
              <span class="mdl-chip__text"><?= $info['residenza'] ?></span>
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
        <div class=" bestPost mdl-card__actions mdl-card--border">
            <p class="infoTitlePost">Post:</p>
            <?php
            if($commented) {
            ?>
            <a href="../post/view-post.php?id=<?=$commented[0]['id']?>" class=" mdl-button mdl-button--colored  mdl-button--accent  mdl-badge" data-badge="<?=$commented[0]['commenti']?>">
              PIU' COMMENTATO<i class="material-icons">reply</i>
            </a>
            <?php
            }
            if($recent) {
            ?>
            <a href="../post/view-post.php?id=<?=$recent[0]['id']?>" class=" mdl-button mdl-button--colored  mdl-button--accent">
              PIU' RECENTE<i class="material-icons">update</i>
            </a>
            <?php
            }
            if($popular) {
            ?>
            <a href="../post/view-post.php?id=<?=$popular[0]['id']?>" class=" mdl-button mdl-button--colored  mdl-button--accent  mdl-badge" data-badge="<?=$popular[0]['voti']?>">
              PIU' VOTATO<i class="material-icons">star_rate</i>
            </a>
            <?php
            }
            ?>
        </div>
      </div>
    </div>
    <?php
    }
  }else{
    ?>
    <h3>Sembra che non ci sia la persona che cerhi</h3>
    <?php
  }
} else {
  ?>
  <h3>Hai passato un imput non valido.</h3>
  <?php
}
include_once '../html/bottom.html';
?>
