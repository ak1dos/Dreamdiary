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
include_once '../html/header-modify-post.html';
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
  $modify = $post->getPost($id);
  if($modify){
    $username = $_SESSION['username'];
    if($modify[0]['utente'] == $username){
    ?>
    <div class="mdl-grid portfolio-max-width">
    <?php
      foreach ($modify as $p) {
    ?>
      <div id="<?=$p['id']?>" class="portfolio-post mdl-cell mdl-cell--12-col mdl-cell--12-col-tablet mdl-card  mdl-card mdl-shadow--4dp">
        <div class="mdl-card__title mdl-card--expand portfolio-blog-card-strip-bg mdl-color-text--white">
          <h2>“<?= $p['titolo'] ?>”</h2>
        </div>
        <div class="mdl-card__supporting-text">
            <?= $p['messaggio'] ?>
        </div>
        <div>
          <span class="mdl-chip mdl-chip--contact mdl-chip--deletable">
            <img class="mdl-chip__contact" src="../images/user.jpg"></img>
            <span class="username mdl-chip__text"><?= $p['utente'] ?></span>
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
        <div class="mdl-card__supporting-text">
          <p id="formTitle">
              Quali sono le modifiche che vuoi apportare?
          </p>
          <form id="modifyForm" action="../php/update-post.php" method="post">
            <input type="hidden" name="id" value="<?=$p['id']?>" />
            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
              <input class="mdl-textfield__input" type="text" id="new_titolo" name="titolo" value="<?= $p['titolo'] ?>">
              <label class="mdl-textfield__label" for="new_titolo">Titolo</label>
                <span class="mdl-textfield__error">Il titolo deve essere massimo 50 lettere!</span>
            </div>
            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
              <textarea class="mdl-textfield__input" type="text" rows= "3" maxlength="500" id="new_messaggio" name="messaggio"><?= $p['messaggio'] ?></textarea>
              <label class="mdl-textfield__label" for="new_messaggio">Testo</label>
            </div>
            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
              <input class="mdl-textfield__input" type="text" maxlength="100" id="new_luogo" name="luogo" value="<?= $p['luogo'] ?>">
              <label class="mdl-textfield__label" for="new_luogo">Luogo</label>
              <span class="mdl-textfield__error">Il luogo deve essere massimo 100 lettere!</span>
            </div>
            <label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="new_pubblico">
              <input type="checkbox" id="new_pubblico" class="mdl-checkbox__input" name="pubblico">
              <span class="mdl-checkbox__label">Post Pubblico?</span>
            </label>
            <button type="submit" class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect">
              Invia
            </button>
            <button type="reset" class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect">
              Cancella
            </button>
          </form>
        </div>
      </div>
    <?php
      }
    ?>
    </div>
    <?php
    } else {?>
      <h3>Non sei il proprietario del posts.</h3>
    <?php
    }
  }else {?>
    <h3>Il post che tenti di modificare non esiste.</h3>
  <?php
  }
} else {?>
  <h3>Non hai specificato il post da modificare!</h3>
<?php
}
include_once '../html/bottom.html';
?>
