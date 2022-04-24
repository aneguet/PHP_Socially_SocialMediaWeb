$(document).ready(function(){
    adminDeletePost = function (value) {

        if (confirm("Are you sure you want to delete the post and its comments?")){
            let postId = value;
            $.ajax({
                method: "POST",
                url: "../controller/AdminViewController.php",
                data: {option: 'adminDeletePost', postId: postId }
            })
            .done(function(data){
                alert(data);
                location.reload();
            })
            .fail (function(error){
                console.log(error);
            })
        } else {
            return false;
        }

    }
    adminBanUser = function (value, banned) {

        if (!isNaN(value) && !isNaN(banned)){
            if (confirm("Are you sure you want to ban this user?")){
                let userId = value;
                let userBanned = banned;
                $.ajax({
                    method: "POST",
                    url: "../controller/AdminViewController.php",
                    data: {option: 'adminBanUser', userid: userId, banned: userBanned }
                })
                .done(function(data){
                    alert(data);
                    location.reload();
                })
                .fail (function(error){
                    console.log(error);
                })
            } else {
                return false;
            }
        } else {
            alert('Could not process the data');
        }

    }
    adminDeleteUser = function (value) {

        if (!isNaN(value)){
            if (confirm("Are you sure you want to delete this user?")){
                let userId = value;
                $.ajax({
                    method: "POST",
                    url: "../controller/AdminViewController.php",
                    data: {option: 'adminDeleteUser', userid: userId }
                })
                .done(function(data){
                    alert(data);
                    location.reload();
                })
                .fail (function(error){
                    console.log(error);
                })
            } else {
                return false;
            }
        } else {
            alert('Could not process the data');
        }
    }
    adminDeleteComment = function (value) {

        if (!isNaN(value)){
            if (confirm("Are you sure you want to delete this comment?")){
                let commentId = value;
                $.ajax({
                    method: "POST",
                    url: "../controller/AdminViewController.php",
                    data: {option: 'adminDeleteComment', commentId: commentId }
                })
                .done(function(data){
                    alert(data);
                    location.reload();
                })
                .fail (function(error){
                    console.log(error);
                })
            } else {
                return false;
            }
        } else {
            alert('Could not process the data');
        }
    }
    adminEditUserRedirect = function (value) {

        if (!isNaN(value)){
            let link = '../admin/user/'+value;
            window.location.href = link;
        } else {
            alert('Could not process the data');
        }
    }
})