$(document).ready(function()
{
  if($('#snackbar').html() != ""){
    showSnackbar();
  }

  $('#modifyForm').submit(function( event ) {
    event.preventDefault();
    var data = $('#modifyForm').serializeArray();
    var nome = new RegExp(/^[A-Za-z]{0,30}$/);
    var cognome = new RegExp(/^[A-Za-z]{0,30}$/);
    var email = new RegExp(/^[^\s@]+@[^\s@]+\.[^\s@]+$/);
    console.log('ciao');
    /*
    if(data[0].value.length > 0){
      if (!email.test(data[0].value) || data[0].value.length > 70) {
        showSnackbarMessage("L'email deve essere simile a questa: esempio@servizio.com e massimo 70 caratteri");
      }
    } else if (data[1].value.length > 0) {
      if (!nome.test(data[1].value)){
        showSnackbarMessage("Il nome può contente A-Z, a-z  e massimo 30 caratteri");
      }
    } else if (data[2].value.length > 0) {
      if(!cognome.test(data[2].value)){
        showSnackbarMessage("Il cognome può contente A-Z, a-z  e massimo 30 caratteri");
      }
    }else if (data[3].value.length > 500){
      showSnackbarMessage("La descrizione deve essere lunga massimo 500 caratteri");
    } else if(data[4].value.length > 100){
      showSnackbarMessage("La residenza deve essere al massimo 100 caratteri");
    } else {
      this.submit();
    }
    */
    if(data[0].value.length > 0 || data[1].value.length > 0 || data[1].value.length > 0){
      if (!email.test(data[0].value) || data[0].value.length > 70) {
        showSnackbarMessage("L'email deve essere simile a questa: esempio@servizio.com e massimo 70 caratteri");
      } else if (!nome.test(data[1].value)){
        showSnackbarMessage("Il nome può contente A-Z, a-z  e massimo 30 caratteri");
      } else if(!cognome.test(data[2].value)){
        showSnackbarMessage("Il cognome può contente A-Z, a-z  e massimo 30 caratteri");
      } else if (data[3].value.length > 500){
        showSnackbarMessage("La descrizione deve essere lunga massimo 500 caratteri");
      } else if(data[4].value.length > 100){
        showSnackbarMessage("La residenza deve essere al massimo 100 caratteri");
      } else {
        this.submit();
      }
    } else if (data[3].value.length > 500){
      showSnackbarMessage("La descrizione deve essere lunga massimo 500 caratteri");
    } else if(data[4].value.length > 100){
      showSnackbarMessage("La residenza deve essere al massimo 100 caratteri");
    } else {
      this.submit();
    }

  });

});

function showSnackbarMessage(message){
  console.log('ciao');
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
