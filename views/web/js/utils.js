$(document).ready(function() {

   //Useful functions 
   
   // Scrolls to top when clicking Header Button
   $("#scrollTop").click(function () {
     // Scrolls to the top of the page
     $( "html,body" ).animate({
       scrollTop: $("body").offset().top
       }, 200, function() {
       // Animation complete.
     });
   });

 });
 function scrollToTop(){
   // Scrolls to the top of the page
   $( "html,body" ).animate({
    scrollTop: $("body").offset().top
    }, 200, function() {
    // Animation complete.
  });
 }
function isEmptyOrSpaces(str){
  return str === null || str.match(/^ *$/) !== null;
}

// Bootstrap generic message (red) for showing info/error messages
function showGeneralMessage(){
  if( $('#general-message').hasClass("d-none")){    // It unhides the html div. Take login.php as an example
      $('#general-message').removeClass( "d-none" ).addClass( "d-block" );
  }
}

function hideGeneralMessage(){
  if( $('#general-message').hasClass("d-block")){   // It hides the html div. Take login.php as an example
    $('#general-message').removeClass( "d-block" ).addClass( "d-none" );
  }
}

// TEXT type on DB has a maximum size, we must check that the input description doesn't exceed it
function byteCount(s) {
  let lengthOfText = encodeURI(s).split(/%..|./).length - 1;
    return lengthOfText;
}