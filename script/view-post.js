$(document).ready(function(){
  if($('.text_comments')){
    getComments();
  }
  if($('.users_like')){
    getLikeInfo();
  }
  $('.comments').click(function(event){
    event.preventDefault();
    $('.text_comments').slideToggle();
  });

  $('.like').click(function(event){
    event.preventDefault();
    $('.users_like').slideToggle();
  });

  if($('#snackbar').html() != ""){
    showSnackbar();
  }
});

function getComments(){
  var id = $('.portfolio-post').attr('id');
  var url = "../php/comments.php";
  var data = {'id_post': id};
  $.ajax({
          url: url,
          data: data,
          type: 'post',
          success:function(response){
            var result = JSON.parse(response);
            if(!result['message'])
              generateCommentsOnDOM(result);
          }
      });
}

function getLikeInfo(){
  var id = $('.portfolio-post').attr('id');
  var url = "../php/likes.php";
  var data = {'get_users': id};
  $.ajax({
          url: url,
          data: data,
          type: 'post',
          success:function(response){
            var result = JSON.parse(response);
            if(!result['message'])
              generateLikesOnDOM(result);
          }
      });
}

function generateLikesOnDOM(data){
  if(data['records'].length > 0)
    $('.like').attr('data-badge', data['records'].length);
  $.each(data.records, function(index, value){
    $link = $('<a href="../utente/view-user.php?id='+value.utente+'"class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect mdl-button--accent"></a>').html(value.utente);
    $icon = $('<i class="material-icons">person</i>');
    $link.append($icon);
    $('.users_like').append($link);
  });
}

function generateCommentsOnDOM(data){

  if(data['records'].length > 0)
    $('.comments').attr('data-badge', data['records'].length);

  $.each(data.records, function(index, value){
    var $comment = $('<div class="comment mdl-color-text--grey-700"></div>');
    var $comment__header = $('<div class="comment__header"></div>');
    var $img = $('<img src="../images/user.jpg" class="comment__avatar">');
    var $comment__author = $('<div class="comment__author"></div>');
    var $label = $('<label></label>');
    var $span1 = $('<span class="mdl-chip"></span>');
    var $span2 = $('<span class="mdl-chip__text"></span>');
    var $name = $('<strong></strong>').html(value.utente);
    var $link = $('<a href="../utente/view-user.php?id='+value.utente+'" class="mdl-chip__action"><i class="material-icons">forward</i></a>');
    var $date = $('<span></span>').html('Pubblicato: ' + convertDate(value.data) + ' alle ' + value.ora);
    var $comment__text = $('<div class="comment__text"></div>').html(value.messaggio);
    $span2.append($name);
    $span1.append($span2, $link);
    $label.append($span1);
    $comment__author.append($label, $date);
    $comment__header.append($img, $comment__author);
    $comment.append($comment__header, $comment__text);

    $('.text_comments').append($comment);
  });
}

function convertDate(str){
   return str.split('-').reverse().join('/');
}

function showSnackbar(){
  // Get the snackbar DIV
  var x = document.getElementById("snackbar");

  // Add the "show" class to DIV
  x.className = "show";

  // After 3 seconds, remove the show class from DIV
  setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
}
