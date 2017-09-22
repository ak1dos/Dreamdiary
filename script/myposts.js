$(document).ready(function()
{

  $('#addPost').click(function(){
    $('.newPostContainer').slideToggle();
    changeIcon();
  })

  $('.like').click(function(event){
    event.preventDefault();
    var button = $(this);
    var id_post = button.closest('.portfolio-post').attr('id');
    console.log('premuto');
    sendLike(id_post, button);
  });

  if($('#snackbar').html() != ""){
    showSnackbar();
  }

  $('#newpostForm').submit(function( event ) {
    event.preventDefault();
    var data = $('#newpostForm').serializeArray();
    if (data[0].value.length < 2 || data[0].value.length > 50) {
      showSnackbarMessage("Il titolo deve essere lungo 2-50 caratteri");
    } else if (data[1].value.length < 10 || data[1].value.length > 500){
      showSnackbarMessage("La descrizione deve essere lunga 10-500 caratteri");
    } else if(data[2].value.length > 100){
      showSnackbarMessage("Il luogo deve essere al massimo 100 caratteri");
    } else {
      this.submit();
    }
  });
});


function sendLike(id_post, button){
  var url = "../php/likes.php?id_post=" + id_post;
  $.ajax({
          url: url,
          type: 'get',
          success:function(response){
            var message = JSON.parse(response).message;
            var badge = Number(button.attr('data-badge'));
            if(message == "add"){
              button.attr('data-badge', (badge + 1));
              showSnackbarMessage("Like aggiunto");
            } else {
              button.attr('data-badge', (badge - 1));
              showSnackbarMessage("Like rimosso");
            }
          }
    });
}

function changeIcon(){
  var icon = $('#change').text();
  if(icon == "add")
    $('#change').text('close');
  else
    $('#change').text('add');
}

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
