
function validate_signup()
{
    hideGeneralMessage();   // Hides general messages div every time the function is launched
    resetSignUpErrorMessages(); // Reset error messages
    
    var username = $('#username').val();
    username = username.trim();
    var email =$('#email').val();
    email = email.trim();
    var password =$('#password').val();
    password = password.trim();
    var password2 =$('#password2').val();
    password2 = password2.trim();
    
    var username_regexp = /^[0-9A-Za-z\_]+$/;
    var email_regexp = /^[^0-9][A-z0-9_-]+([.][A-z0-9_]+)*[@][A-z0-9_]+([.][A-z0-9_-]+)*[.][A-z]{2,4}$/;
    var password_regexp = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{6,30}$/;
    
    // USERNAME

    if( isEmptyOrSpaces(username) ){
        $('#username-error').text("Username cannot be empty");
        
    }
    // Username length
    else if(username.length<4){
        $('#username-error').text("Username must have at least 4 characters");
        
    }
    else if(username.length>30){
        $('#username-error').text("Username cannot exceed 30 characters");
        
    }
    // Username is not the accepted type
    else if(!(username_regexp.test(username))){
        $('#username-error').text("Username can only contain letters, numbers and underscores");
        
    }
    // EMAIL
    else if( isEmptyOrSpaces(email) ){
        $('#email-error').text("Email cannot be empty");
        
    }
    // Email is not the accepted type
    else if(!(email_regexp.test(email))){
        $('#email-error').text("This email is not valid");
        
    }
    // PASSWORD
    else if( isEmptyOrSpaces(password) ){
        $('#password-error').text("Password cannot be empty");
        
    }
    // Password length
    else if(password.length<6){
        $('#password-error').text("Password must have at least 6 characters");
        
    }
    else if(password.length>30){
        $('#password-error').text("Password cannot exceed 30 characters");
        
    }
    // Password is not the accepted type
    else if(!(password_regexp.test(password))){
        $('#password-error').text("Password must contain at least one uppercase letter, one lowercase letter, one number and one special character");
        
    }
    // PASSWORD 2
    else if( isEmptyOrSpaces(password2) ){
        $('#password2-error').text("Password cannot be empty");
        
    }
    // PASSWORD VS PASSWORD  2
    // Passwords have different values
    else if(!(password===password2)){
        $('#password2-error').text("Passwords must be identical");
        
    }
    // TERMS OF USE
    else if(!$('#termsofuse').prop('checked')){
        $('#termsofuse-error').text("You must accept our Terms of Use");
        
    }
    
    else
    {
        $.ajax({
            url: "controller/ViewsController.php",
            method: "POST",
            data: { option:"signup", username:username, email:email, password:password, password2:password2}
        })
        .done(function(data) {
            if(data){ 
                var parsedData = $.parseJSON(data);
                if(typeof parsedData === 'string'){   // No PHP validation errors & User is new 
                    // Redirection to next step (category selection) 
                    window.location.href= 'category_selection';
                }
                else{ // PHP validation error ||  User doesn't exist || Error in query
                    
                    if(parsedData["id"] == "username"){
                        $('#username-error').text(parsedData["text"]);
                    }
                    else if(parsedData["id"] == "email"){
                        $('#email-error').text(parsedData["text"]);
                    }
                    else if(parsedData["id"] == "password"){
                        $('#password-error').text(parsedData["text"]);
                    }
                    else if(parsedData["id"] == "password2"){
                        $('#password2-error').text(parsedData["text"]);
                    }
                    else if(parsedData["id"] == "general"){
                        $('#general').text(parsedData["text"]);
                        showGeneralMessage();
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

function cleanPasswordField(){
    $('#password').val('');
    $('#password').text("");
}
function cleanPassword2Field(){
    $('#password2').val('');
    $('#password2').text("");
}
function resetSignUpErrorMessages(){
    $('#username-error').val('');
    $('#username-error').text("");

    $('#email-error').val('');
    $('#email-error').text("");

    $('#password-error').val('');
    $('#password-error').text("");

    $('#password2-error').val('');
    $('#password2-error').text("");

    $('#termsofuse-error').val('');
    $('#termsofuse-error').text("");

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

    // When user clicks on show/hide password 2 (eye icon)
    $("#password2-parent i").on('click', function(event) {
        event.preventDefault();
        // Hide password and change icon to unsee
        if($('#password2-parent input').attr("type") == "text"){
            $('#password2-parent input').attr('type', 'password');
            $('#password2-parent i').addClass( "fas fa-eye-slash" );
            $('#password2-parent i').removeClass( "far fa-eye" );
        // Show password and change icon to see
        }else if($('#password2-parent input').attr("type") == "password"){
            $('#password2-parent input').attr('type', 'text');
            $('#password2-parent i').removeClass( "fas fa-eye-slash" );
            $('#password2-parent i').addClass( "far fa-eye" );
        }
    });
});

