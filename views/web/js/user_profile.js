$(document).ready(function () {

  // If user wants to remove the image 
  removeUserAttachedImage = function() {
    resetAvatarErrorMessages();
    // We only call the function if there's an image to remove
    if($("#profile-settings-section #new-avatar-upload").val()){
      $("#profile-settings-section #new-avatar-upload").val('');
    }
  }

  submitUserSettingsForm = function () {
    resetProfileErrorMessages();
    var email = $("#email-profile").val();
    email = email.trim();
    var password1 = $('#password1-profile').val();
    password1 = password1.trim();
    var password2 = $('#password2-profile').val();
    password2 = password2.trim();
    var password = $('#password-profile').val();
    password = password.trim();

    //Files can be sent through AJAX using the FormData object.
    //The AJAX call must specify contentType and psrocessdata otherwise it won't work.
    let formData = {
      option: "profile_form",
      email: email,
      password: password,
      password1: password1,
      password2: password2,
    };
    if(validateUserProfileForm(email,password,password1,password2)){
      $.ajax({
        method: "POST",
        url: "controller/ViewsController.php",
        data: formData,
        dataType: "json",
      })
        .done(function (data) {
          if(data){
            if(typeof data === 'boolean'){// everything ok
              $(".success-message").text(
                "User information successfully updated. Refreshing in 3 seconds..."
              );
              setTimeout(function () {
                loadContent('user_profile', ""); // we reload the page
              }, 2000);
            }
            else{
              if(data["id"] == "email"){
                $('#email-error').text(data["text"]);
              }
              else if(data["id"] == "password"){
                $('#password-error').text(data["text"]);
              }
              else if(data["id"] == "password1"){
                $('#password1-error').text(data["text"]);
              }
              else if(data["id"] == "password2"){
                $('#password2-error').text(data["text"]);
              }
              else if(data["id"] == "avatar"){
                $('#avatar-error').text(data["text"]);
              }
              else if(data["id"] == "general"){
                $('#general-error').text(data["text"]);
              }
            }
          }
          else{
            $('#general-error').text("Ooops! Something went wrong.");
          }
        })
        .fail(function (jqXHR, textStatus, errorThrown) {
          $('#general-error').text("Ooops! Something went wrong.");
        });
    }   
  };

  uploadUserAvatar = function () {
    resetProfileErrorMessages();

    let mydata = $("#new-avatar-form")[0];
    let formData = new FormData(mydata);
    formData.append("option", "new_avatar_form");
    

    if($('#profile-settings-section #new-avatar-upload').get(0).files[0]){
      imageFile = $('#profile-settings-section #new-avatar-upload').get(0).files[0];
    }
    else{
      imageFile="";
    }
    if(validateAvatarImage(imageFile)){
      $.ajax({
        method: "POST",
        url: "controller/ViewsController.php",
        contentType: false, // to tell jQuery to not set any content type header.
        processData: false, //  to send a DOMDocument, or other non-processed data it has to be set to false
        data: formData,
        dataType: "json",
      })
        .done(function (data) {
          if(data){
            if(typeof data === 'boolean'){// everything ok
              loadContent('user_profile', ""); // we reload the page
            }
            else{ // errors
              if(data["id"] == "avatar"){
                $('#avatar-error').text(data["text"]);
              }
            }
          }
          else{
            $('#avatar-msg').text("Ooops! Something went wrong.");
          }
        })
        .fail(function (jqXHR, textStatus, errorThrown) {
          $('#avatar-msg').text("Ooops! Something went wrong.");
        });
    }


  };

  function resetProfileErrorMessages() {
    $("#general-error").text("");
    $("#general-error").val('');
    $("#email-error").text("");
    $("#email-error").val('');
    $("#avatar-error").text("");
    $("#avatar-error").val('');
    $("#password-error").text("");
    $("#password-error").val('');
    $("#password1-error").text("");
    $("#password1-error").val('');
    $("#password2-error").text("");
    $("#password2-error").val('');
  }
  function resetAvatarErrorMessages() {
    $("#avatar-error").text("");
    $("#avatar-error").val('');
  }


});
function validateAvatarImage(imageFile){
  var isDataOk=true;
  if(!imageFile){ // Image doesn't exist
    $('#avatar-error').text("Please upload an image.");
    isDataOk = false;
  }
  else{// image exists
    if (isImageTheSupportedType(imageFile['type'])) {
      //and size meet the criteria 
      if (isImageBiggerThan2MB(imageFile['size'])) {
        $('#avatar-error').text("Maximum image size is 2MB");
        isDataOk = false;
      }
      else if(imageWidth<120){// Width is too small
        $('#avatar-error').text("Image width must be at least of 120px");
        isDataOk = false;
      }
      else if(imageWidth>1920 || imageHeight>1920){// The image is too big in px
        $('#avatar-error').text("Image width or height can't be bigger than 1920px.");
        isDataOk = false;
      }
      else if(imageRatio<0.5){ // Image's height size is too big
        $('#avatar-error').text("Image height is too big in relation to its width. (Accepted ratios: 0.5-3)");
        isDataOk = false;
      }
      else if(imageRatio>3){ // Image's width size is too big
        $('#avatar-error').text("Image width is too big in relation to its height. (Accepted ratios: 0.5-3)");
        isDataOk = false;
      }
    } else {
      $('#avatar-error').text("Only jpeg, jpg, png and gif images are allowed");
        isDataOk = false;
    }
  }
  return isDataOk;
}
function validateUserProfileForm(email,password,password1,password2){
  var email_regexp = /^[^0-9][A-z0-9_-]+([.][A-z0-9_]+)*[@][A-z0-9_]+([.][A-z0-9_-]+)*[.][A-z]{2,4}$/;
  var password_regexp = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{6,30}$/;

  var isDataOk = true;
  // No field 
  if(!email && !password && !password1 && !password2){
    $("#general-error").text('Write an email or password to save changes');
    isDataOk = false;
  } 
  else if(email){// check if email is the accepted type
    if(!(email_regexp.test(email))){
      $('#email-error').text("This email is not valid");
      isDataOk = false;
    }
    else{
      if((password && (!password1 || !password2)) || (password1 && (!password || !password2)) || (password2 && (!password || !password1))){
        $("#general-error").text('The new password, the confirmation password and the current password are required to upload your information.');
        isDataOk = false;
      }
      else if(password && password1 && password2){
        if(!(password_regexp.test(password1))){
          $("#general-error").text("The new password must contain at least one uppercase letter, one lowercase letter, one number and one special character");
          isDataOk = false;
        }
        else if(password1.length<6){
          $('#password1-error').text("Password must have at least 6 characters");
          isDataOk = false;  
        }
        else if(password1.length>30){
          $('#password1-error').text("Password cannot exceed 30 characters");
          isDataOk = false;
        }
        else if(password1!==password2){
          $("#general-error").text("The new password and the confirmation password don't match.");
          isDataOk = false;
        }
        else if(password === password1 === password2){
          $("#general-error").text("The new password should be different than your current one.");
          isDataOk = false;
        }
      }
    }
  }
  else if((password && (!password1 || !password2)) || (password1 && (!password || !password2)) || (password2 && (!password || !password1))){
    $("#general-error").text('The new password, the confirmation password and the current password are required to upload your information.');
    isDataOk = false;
  }
  else if(password && password1 && password2){
    if(!(password_regexp.test(password1))){
      $("#general-error").text("The new password must contain at least one uppercase letter, one lowercase letter, one number and one special character");
      isDataOk = false;
    }
    else if(password1.length<6){
      $('#password1-error').text("Password must have at least 6 characters");
      isDataOk = false;  
    }
    else if(password1.length>30){
      $('#password1-error').text("Password cannot exceed 30 characters");
      isDataOk = false;
    }
    else if(password1!==password2){
      $("#general-error").text("The new password and the confirmation password don't match.");
      isDataOk = false;
    }
    else if(password === password1 === password2){
      $("#general-error").text("The new password should be different than your current one.");
      isDataOk = false;
    }
  }

  return isDataOk;
}
// When an image is uploaded, its dimensions are saved in global variables
function getImageDimensions(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    reader.onload = function (e) {
      var img = new Image;
      img.onload = function() {
        imageHeight = img.height;
        imageWidth = img.width;
        imageRatio = imageWidth/imageHeight; 
      };
      img.src = reader.result;
    };
    reader.readAsDataURL(input.files[0]);
  }
}

