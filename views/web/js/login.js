
function validate_login()
{
    hideGeneralMessage();   // Hides general messages div every time the function is launched
    
    resetLoginErrorMessages();   // Reset error messages

    var error="";
    var username =$('#username').val();
    username = username.trim();
    var password =$('#password').val();
    password = password.trim();

    if( isEmptyOrSpaces(username) ){
        $('#username-error').text("Username cannot be empty");
        cleanPasswordField();
    }

    else if( isEmptyOrSpaces(password) ){
        $('#password-error').text("Password cannot be empty");
        // We clear password input for security purposes
        cleanPasswordField();
    }

    // Data is valid
    else{
        $.ajax({
            url: "controller/ViewsController.php",
            method: "POST",
            data: { option:"login", username:username, password:password}
        })
        .done(function(data) {
            if(data){ 
                var parsedData = $.parseJSON(data);
                if(parsedData["id"].length==0 || parsedData["id"]==""){   // No PHP validation errors & User Exists 
                    
                    window.location.href = 'home'; // We send the user to the main page, logged in
                }
                else{ // PHP validation error ||  User doesn't exist
                    if(parsedData["id"] == "general"){
                        $('#general').text(parsedData["text"]);
                        showGeneralMessage();
                        
                    }
                    else if(parsedData["id"] == "username"){
                        $('#username-error').text(parsedData["text"]);
                    }
                    else if(parsedData["id"] == "password"){
                        $('#password-error').text(parsedData["text"]);
                    }
                }
            }
            else{
                 $('#general').text("Ooops! Something went wrong.");
                showGeneralMessage();
            }
            
        })
        .fail(function (jqXHR, textStatus, errorThrown) {
             $('#general').text("Ooops! Something went wrong.");
            showGeneralMessage();
        }); 
    }
    
}

// When user presses enter key on password field 

$('#password').keypress(function (e) {
    var key = e.which;
    if(key == 13)  // the enter key code
     {
        validate_login();  // we submit the form
     }
});   

function cleanPasswordField(){
    $('#password').val('');
    $('#password').text("");
}

function resetLoginErrorMessages(){
    $('#username-error').val('');
    $('#username-error').text("");
    
    $('#password-error').val('');
    $('#password-error').text("");
}

$(document).ready(function() {
    // When user clicks on show/hide password (eye icon)
    $("#password-parent i").on('click', function(event) {
        event.preventDefault();
        // Hide password and change icon to unsee
        if($('#password-parent input').attr("type") == "text"){
            $('#password-parent input').attr('type', 'password');
            $('#password-parent i').addClass( "fas fa-eye-slash" );
            $('#password-parent i').removeClass( "far fa-eye" );
        // Show password and change icon to see
        }else if($('#password-parent input').attr("type") == "password"){
            $('#password-parent input').attr('type', 'text');
            $('#password-parent i').removeClass( "fas fa-eye-slash" );
            $('#password-parent i').addClass( "far fa-eye" );
        }
    });

});
