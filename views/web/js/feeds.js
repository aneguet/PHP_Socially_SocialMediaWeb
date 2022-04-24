
$(document).ready(function() {


    // We retrieve the data and refresh the posts
    loadFeed = function(filter){ 
    
        var feedFilter = filter;
        $.ajax({
            url: "controller/ViewsController.php",
            method: "POST",
            data: { option:'feed', feedFilter: feedFilter}
        })
        .done(function(data) {
            var filteredPosts = $.parseJSON(data);
            loadContent('feed', filteredPosts);
        });
    };

    loadFeed('latest');

    // When we click something on a post that must redirect to that specific post page > we take the post id and the page name ("showpost" page) 
    sendPostId = function(id){
        loadContent('show_post',id);
    }
    
    // When user clicks on a post voting icon
    ratePost = function(postId, isPositive){ 
        if(isPositive || !isPositive){
            $.ajax({
                url: "controller/ViewsController.php",
                method: "POST",
                data: { option:"rate_post", postId:postId, isPositive:isPositive }
            })
            .done(function(data) {
                var rate = data;
                fillVoteWhenClicked(postId,rate);
                getPostTotalVotes(postId);
            });
        }
        
    };
    
    // When the post is rated, this applies the css to the selected vote button 
    fillVoteWhenClicked = function(postId,rate){ 
        // unfill all votes
        if(rate==-1){
            if($("#"+postId+" .upvote_button").hasClass("upvote_filled")){
                $("#"+postId+" .upvote_button").removeClass( "upvote_filled" ).addClass( "upvote_default" );
            }
            if($("#"+postId+" .downvote_button").hasClass("downvote_filled")){
                $("#"+postId+" .downvote_button").removeClass( "downvote_filled" ).addClass( "downvote_default" );
            }
        }
        // fill upvote
        else if(rate==2){
            if($("#"+postId+" .upvote_button").hasClass("upvote_default")){
                $("#"+postId+" .upvote_button").removeClass( "upvote_default" ).addClass( "upvote_filled" );
            }
            if($("#"+postId+" .downvote_button").hasClass("downvote_filled")){
                $("#"+postId+" .downvote_button").removeClass( "downvote_filled" ).addClass( "downvote_default" );
            }
        
        }// fill downvote
        else if(rate==3){
            if($("#"+postId+" .downvote_button").hasClass("downvote_default")){
                $("#"+postId+" .downvote_button").removeClass( "downvote_default" ).addClass( "downvote_filled" );
            }
            if($("#"+postId+" .upvote_button").hasClass("upvote_filled")){
                $("#"+postId+" .upvote_button").removeClass( "upvote_filled" ).addClass( "upvote_default" );
            }
        }
    };
    // Gets the post total votes
    getPostTotalVotes = function(postId){
        $.ajax({
            url: "controller/ViewsController.php",
            method: "POST",
            data: { option:"post_votes", postId:postId}
        })
        .done(function(data) {
            updatePostTotalVotes(postId, $.parseJSON(data));
        });
    };

    // Updates the total votes in the post
    updatePostTotalVotes = function(postId, totalVotes){
        $("#"+postId+" .total_upvotes").html(totalVotes[0]['up_votes']);
        $("#"+postId+" .total_downvotes").html(totalVotes[0]['down_votes']);
    };

});