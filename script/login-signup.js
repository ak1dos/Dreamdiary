$(document).ready(function()
{
  $('.loginContainer').slideToggle();
  $('.signupContainer').slideToggle();

  $('#goLogin').click(function(){
    $('.wellcome').slideToggle();
    $('.loginContainer').slideToggle();
  });

  $('#signupButton, #loginButton').click(function(e){
    e.preventDefault();
    stateChange();
  });

  $('#loginForm').submit(function( event ) {
    event.preventDefault();
    var data = $('#loginForm').serializeArray();
    var username = new RegExp(/^[a-z0-9_-]{3,16}$/);
    var password = new RegExp(/^[A-Za-z0-9]{6,16}$/);
    if (!username.test(data[0].value)) {
      showSnackbarMessage("L'username deve deve essere lunga 3-16 caratteri e contente a-z, 0-9, '_'");
    } else if (!password.test(data[1].value)){
      showSnackbarMessage("La password deve deve essere lunga 3-16 caratteri e contente A-Z, a-z, 0-9");
    } else {
      this.submit();
    }
  });

  $('#signupForm').submit(function( event ) {
    event.preventDefault();
    var data = $('#signupForm').serializeArray();
    var username = new RegExp(/^[a-z0-9_-]{3,16}$/);
    var password = new RegExp(/^[A-Za-z0-9]{6,16}$/);
    if (!username.test(data[0].value)) {
      showSnackbarMessage("L'username deve deve essere lunga 3-16 caratteri e contente a-z, 0-9, '_'");
    } else if (!password.test(data[1].value)){
      showSnackbarMessage("La password deve deve essere lunga 3-16 caratteri e contente A-Z, a-z, 0-9");
    } else if(data[1].value != data[2].value){
      showSnackbarMessage("Le password non combaciano");
    } else {
      this.submit();
    }
  });

  if($('#snackbar').html() != ""){
    showSnackbar();
  }

  function stateChange(){
    $('.loginContainer').slideToggle();
    $('.signupContainer').slideToggle();
  }
});

function showSnackbarMessage(message){
  // Get the snackbar DIV
  var x = document.getElementById("snackbar");

  // Add the "show" class to DIV
  x.className = "show";

  // Add message
  x.textContent = message;

  // After 3 seconds, remove the show class from DIV
  setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
}


function showSnackbar(){
  // Get the snackbar DIV
  var x = document.getElementById("snackbar");

  // Add the "show" class to DIV
  x.className = "show";

  // After 3 seconds, remove the show class from DIV
  setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
}
