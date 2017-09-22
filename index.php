<?php
session_start();
// verifies if the user is logged in
include_once './php/config/database.php';
include_once './php/objects/utente.php';
$database = new Database();
$db = $database->getConnection();
$user = new Utente($db);
$user->check_logged_in();
$error = null;
if(isset($_SESSION['flash'])){
  $error = $_SESSION['flash'];
  unset($_SESSION['flash']);
}
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Dreamdiary</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons" />
    <link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.grey-pink.min.css" />
    <link rel="stylesheet" href="./css/main.css" />
    <link rel="shortcut icon" type="image/png" href="./images/logo.png"/>
  </head>

  <body>
    <div class="mdl-layout mdl-js-layout mdl-layout--fixed-header">
      <header class="mdl-layout__header mdl-layout__header--waterfall portfolio-header">
          <div class="mdl-layout__header-row portfolio-logo-row">
              <span class="mdl-layout__title">
                  <div class="portfolio-logo"></div>
                  <span class="mdl-layout__title">Dreamdiary</span>
              </span>
          </div>
      </header>
      <main class="mdl-layout__content">

        <div id="snackbar"><?=$error?></div>

        <!--Un div di benvenuto-->
        <div class="wellcome mdl-card mdl-shadow--2dp">
          <div class="mdl-card__title">
            <h2 class="mdl-card__title-text">Benvenuti!</h2>
          </div>
          <div class="mdl-card__supporting-text">
            Questo è il portale che vi permetterà di condividere e rivivere
            i vostri sogni con il mondo oppure tenerli tutti per voi.
          </div>
          <div class="mdl-card__actions mdl-card--border">
            <button id="goLogin" class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect">
              Entra
            </button>
          </div>
        </div>
        <!--Div con contenente il form del login-->
        <div class="loginContainer mdl-card mdl-shadow--2dp">
          <div class="mdl-card__title mdl-card--expand">
            <h2 class="mdl-card__title-text">Accedi al tuo account</h2>
          </div>
          <div class="mdl-card__supporting-text">
            <form id="loginForm" action="./php/login.php" method="post">
              <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input" type="text" id="log_username" name="username">
                <label class="mdl-textfield__label" for="log_username">Username</label>
              </div>
              <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input" type="password" id="log_password" name="password">
                <label class="mdl-textfield__label" for="log_password">Password</label>
              </div>
              <button type="submit" class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect">
                Login
              </button>
              <button id="signupButton" class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect">
                Non sei registrato?
              </button>
            </form>
          </div>
        </div>
        <!--Div con contenente il form della registrazione-->
        <div class="signupContainer mdl-card mdl-shadow--2dp">
          <div class="mdl-card__title mdl-card--expand">
            <h2 class="mdl-card__title-text">Crea un nuovo account</h2>
          </div>
          <div class="mdl-card__supporting-text">
            <form id="signupForm" action="./php/signup.php" method="post">
              <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input" type="text" id="reg_username" name="username">
                <label class="mdl-textfield__label" for="reg_username">Username</label>
              </div>
              <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input" type="password" minlength="6" maxlength="12" id="reg_password" name="password">
                <label class="mdl-textfield__label" for="reg_password">Password</label>
              </div>
              <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input" type="password" minlength="6" maxlength="12" id="reg_password_confirm" name="password_confirm">
                <label class="mdl-textfield__label" for="reg_password_confirm">Conferma Password</label>
              </div>
              <button type="submit" class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect">
                Signup
              </button>
              <button id="loginButton" class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect">
                Sei registrato?
              </button>
            </form>
          </div>
        </div>
      </main>
    </div>
  </body>
  <!-- Material Design Lite JavaScript -->
  <script defer src="https://code.getmdl.io/1.3.0/material.min.js"></script>
  <script type="text/javascript" src="./script/jquery-3.2.1.js"></script>
  <script type="text/javascript" src="./script/login-signup.js"></script>
</html>
