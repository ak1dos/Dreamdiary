$(document).ready(function()
{
  if($('#snackbar').html() != ""){
    showSnackbar();
  }

  $('#modifyForm').submit(function( event ) {
    event.preventDefault();
    var data = $('#modifyForm').serializeArray();
    if (data[1].value.length < 2 || data[1].value.length > 50) {
      showSnackbarMessage("Il titolo deve essere lungo 2-50 caratteri");
    } else if (data[2].value.length < 10 || data[2].value.length > 500){
      showSnackbarMessage("La descrizione deve essere lunga 10-500 caratteri");
    } else if(data[3].value.length > 100){
      showSnackbarMessage("Il luogo deve essere al massimo 100 caratteri");
    } else {
      this.submit();
    }
  });

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
