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
include_once '../html/header-view-post.html';
$error = null;
if(isset($_SESSION['flash'])){
  $error = $_SESSION['flash'];
  unset($_SESSION['flash']);
}
?>
<div id="snackbar"><?=$error?></div>
<?php
if(isset($_GET['id'])){
  $id = $_GET['id'];
  $view = $post->getPost($id);
  if($view){
    $username = $_SESSION['username'];
    if($view[0]['utente'] == $username || $view[0]['pubblico'] == 1){
    ?>
    <div class="mdl-grid portfolio-max-width">
    <?php
      foreach ($view as $p) {
    ?>
    <div id="<?=$p['id']?>" class="portfolio-post mdl-cell mdl-cell--12-col mdl-cell--12-col-tablet mdl-card  mdl-card mdl-shadow--4dp">
      <div class="mdl-card__title mdl-card--expand portfolio-blog-card-strip-bg mdl-color-text--white">
        <?php
          if($p['utente'] == $_SESSION['username']){
        ?>
        <a href="./modify-post.php?id=<?= $p['id'] ?>"id="tip<?= $p['id'] ?>" class="updatePost mdl-button mdl-js-button mdl-button--fab mdl-button--mini-fab">
          <i class="material-icons">mode_edit</i>
        </a>
        <div class="mdl-tooltip" data-mdl-for="tip<?= $p['id'] ?>">
        Modifica Post
        </div>
        <?php
          }
        ?>
        <h2>“<?= $p['titolo'] ?>”</h2>
      </div>
      <div class="mdl-card__supporting-text">
          <?= $p['messaggio'] ?>
      </div>
      <div>
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
      <?php
        if($p['datam']){
      ?>
      <p class="datePost">Modificato il: <?= date("d-m-Y",strtotime($p['datam'])) ?></p>
      <?php
        } else {
      ?>
      <p class="datePost">Pubblicato il: <?= date("d-m-Y",strtotime($p['datac'])) ?></p>
      <?php
        }
      ?>
      <div class="mdl-card__actions mdl-card--border">
          <button class="like mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect mdl-button--accent  mdl-badge" data-badge="0">
            LIKE<i class="material-icons">thumb_up</i>
          </button>
          <button class="comments mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect mdl-button--accent  mdl-badge" data-badge="0">
            COMMENTI<i class="material-icons">comment</i>
          </button>
          <?php
            if($p['utente'] == $_SESSION['username']){
          ?>
          <form id="reset" action="../php/reset-comments.php" method="post">
            <input type="submit" class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect mdl-button--accent" value="Resetta i commenti" />
            <input type="hidden" name="id_post" value="<?=$p['id']?>" />
          </form>
          <?php
            }
          ?>
      </div>
      <div class="mdl-card__actions mdl-card--border users_like">
      </div>
      <div class="mdl-color-text--primary-contrast mdl-card__supporting-text text_comments">
        <form action="../php/new-comment.php" method="post">
          <input type="hidden" name="id" value="<?=$p['id']?>" />
          <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
            <textarea rows=1 maxlength="350" class="mdl-textfield__input" id="comment" name="messaggio"></textarea>
            <label for="comment" class="mdl-textfield__label">Lascia un commento...</label>
          </div>
          <button class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon">
            <i class="material-icons" role="presentation">check</i><span class="visuallyhidden">add comment</span>
          </button>
        </form>
      </div>
    <?php
      }
    } else {?>
      <h3>Il post è privato e tu non sei il proprietario.</h3>
    <?php
    }
  }else {?>
    <h3>Il post che tenti di raggiungere non esiste.</h3>
  <?php
  }
}else {?>
  <h3>Non hai specificato il post da modificare!</h3>
<?php
}
include_once '../html/bottom.html';
?>
