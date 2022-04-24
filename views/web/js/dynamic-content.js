$(document).ready(function () {
  loadContent = function (pageName, data) {
    // In case we are sending the page name and a param
    if (data) {
      $.ajax({
        url: "controller/PageController.php",
        method: "POST",
        data: { pageName: pageName, data: data },
        success: function (data) {
          $("#content").html(data);
        },
      });
    }
    // In case we only send the page name
    else {
      if (pageName) {
        $.ajax({
          url: "controller/PageController.php",
          method: "POST",
          data: { pageName: pageName },
          success: function (data) {
            $("#content").html(data);
          },
        });
      }
    }
  };

  // When we click header links (match user, new post) - We only send the page Name via the id (in this case, we only send the page name "")
  $(".navbar_links i, .navbar_profile").click(function () {
    var pageName = $(this).attr("id");
    loadContent(pageName, "");
  });
});
