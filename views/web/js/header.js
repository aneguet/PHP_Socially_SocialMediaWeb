$( document ).ready(function() {

    // When clicking on menu > "all categories" option
    $("#header-buttons #all-cats").click(function () {
        loadContent('all_categories', "");
    });
    // When clicking on menu > "popular feed" option
    $("#header-buttons #popular-feed").click(function () {
        $.ajax({
            url: "controller/ViewsController.php",
            method: "POST",
            data: { option:'set_feed', feedPage: 'popularfeed'}
        })
        .done(function(data) {
          goToFeed('latest');
        });
    });
    // shows tooltip content
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    });
    // When clicking index logo (we go home or also called userfeed)
    $("#logo-link").click(function () {
        //goToUserFeed('latest');
        location.reload();
    });
    goToAboutPage= function(){
        loadContent('about_us', "");
    }
    
});

// // Functions need to be defined outside docready
// function goToUserFeed(){ 
//     location.reload();
// };
// We retrieve the data and refresh the posts
goToFeed = function(filter){ 
    
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