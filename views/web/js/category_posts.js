$(document).ready(function() {

    // Every time the filters dropdown changes, we reload the page with the specific query data
    loadCategoryPosts = function(value){ 
    
        var categoryPostsFilter = value;

        $.ajax({
            url: "controller/ViewsController.php",
            method: "POST",
            data: { option:"category_posts", categoryPostsFilter: categoryPostsFilter}
        })
        .done(function(data) {
            var filteredCategoryPosts = $.parseJSON(data);
            loadContent('category_posts', filteredCategoryPosts);
        });
    };

    joinCategoryOnCategoryPage = function(value){
        var categoryName = value;
        $.ajax({
            url: "controller/ViewsController.php",
            method: "POST",
            data: { option:"join_category", categoryName:categoryName}
        })
        .done(function(data) {
            loadSpecificCategory(categoryName);
        });
    }
    leaveCategoryOnCategoryPage = function(value){
        var categoryName = value;
        $.ajax({
            url: "controller/ViewsController.php",
            method: "POST",
            data: { option:"leave_category", categoryName:categoryName}
        })
        .done(function(data) {
            loadSpecificCategory(categoryName);
        });
    }


});
