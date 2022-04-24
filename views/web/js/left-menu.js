$(document).ready(function() {
    // When we click something on a post that must redirect to that specific post page > we take the post id and the page name ("showpost" page) 
    loadSpecificCategory = function(categoryName){
        // We send the clicked category in the left menu to the controller to set it as a session variable
        $.ajax({
            url: "controller/ViewsController.php",
            method: "POST",
            data: { option:"specific_category", categoryName: categoryName}
        })
        .done(function() {
            // Once the category is set as a session variable, we load the category posts page
            // When this page loads for the first time, we set the filter as default (latest)
            $.ajax({
                url: "controller/ViewsController.php",
                method: "POST",
                data: { option:"category_posts", categoryPostsFilter: 'latest'}
            })
            .done(function(data) {
                var filteredCategoryPosts = $.parseJSON(data);
                loadContent('category_posts', filteredCategoryPosts);
            });

        });
    }
    

});