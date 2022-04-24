$(document).ready(function(){

    adminDeactivateUser = function (e) {
        e.preventDefault();
        let userId = $('#deactivateUserBtn').val();
        let userBanned = $('#userBanStatus').val();
        $.ajax({
            method: "POST",
            url: "../../controller/AdminViewController.php",
            data: {option: 'adminDeactivateUser', userid: userId, banned: userBanned}
        })
        .done(function(data){
            location.reload();
        })
        .fail(function(error){
            console.log(error);
        })
    }

    adminUpdateUser = function (e) {
        e.preventDefault();
        resetErrorMessages();
        // let array  = [];
        let username = $('#admin-edit-user-username').val();
        let email = $('#admin-edit-user-email').val();
        let password = $('#admin-edit-user-password').val();
        let userRank = $('input[name="userRank"]:checked').val();
        let userPermission = $('input[name="userPermission"]:checked').val();
        let userId = $('#userId').val();
        let option = 'adminEditUser';
        let validationFront = true;


        let username_regexp = /^[0-9A-Za-z\_]+$/;
        let email_regexp = /^[^0-9][A-z0-9_-]+([.][A-z0-9_]+)*[@][A-z0-9_]+([.][A-z0-9_-]+)*[.][A-z]{2,4}$/;
        let password_regexp = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{6,30}$/;

        
        // USERNAME
    
        if( !isEmptyOrSpaces(username) ){
            if (username.length<4){
                $('#username-error').text("Username must have at least 4 characters");
                validationFront = false;
            }else if(username.length>30){
                $('#username-error').text("Username cannot exceed 30 characters");
                validationFront = false;
            }
            // Username is not the accepted type
            else if(!(username_regexp.test(username))){
                $('#username-error').text("Username can only contain letters, numbers and underscores");
                validationFront = false;
            }
        }
        // EMAIL
        if (!isEmptyOrSpaces(email) ) {
            if(!(email_regexp.test(email))){
                $('#email-error').text("This email is not valid");
                validationFront = false;
            }
        }

        // PASSWORD
        if( !isEmptyOrSpaces(password) ){

            if(password.length<6){
                $('#password-error').text("Password must have at least 6 characters");
                validationFront = false;
            }
            else if(password.length>30){
                $('#password-error').text("Password cannot exceed 30 characters");
                validationFront = false;
            }
            // Password is not the accepted type
            else if(!(password_regexp.test(password))){
                $('#password-error').text("Password must contain at least one uppercase letter, one lowercase letter, one number and one special character");
                validationFront = false;
            }  

        }
        

        if (validationFront) {
            $.ajax({
                method: "POST",
                url: "../../controller/AdminViewController.php",
                data: {option: option, username: username, email: email, password: password, userrank: userRank, userpermission: userPermission, userid: userId }
            })
            .done(function(data){
                data=$.parseJSON(data);
    
                if (!(data.id == 'result')) {
                    if (data.text) {
                        $('#'+data.id+'-error').text(data.text)
                      }
                } else {
                    $('#success-info').text(data.text);
                    setTimeout(function () {
                        location.reload();
                    }, 3000);
                }
    
            })
            .fail(function(error){
                console.log(error);
            })
        }

    }

})


function resetErrorMessages(){
    $('#username-error').text("");
    $('#email-error').text("");
    $('#password-error').text("");
}