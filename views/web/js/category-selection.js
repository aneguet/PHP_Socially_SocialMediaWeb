var selectedCategories=[];
var totalSelectedCategories=0; // Total of selected categories by the user
$(document).ready(function(){
selectCategory = function(buttonNumber,categoryId){
    if($("#category-info-text").hasClass("text-danger")){
        $("#category-info-text").removeClass("text-danger");
    }
    // We change the button style
    switch(buttonNumber){
        case 1:
        case 8:
        case 15:
            if($("#"+categoryId).hasClass("btn-blue-deselected")){
                $("#"+categoryId).removeClass( "btn-blue-deselected" ).addClass( "btn-blue-selected" );
                totalSelectedCategories ++;
            }
            else if($("#"+categoryId).hasClass("btn-blue-selected")){
                $("#"+categoryId).removeClass( "btn-blue-selected" ).addClass( "btn-blue-deselected" );
                totalSelectedCategories --;
            }
            break;

            case 2:
            case 9:
            case 16:
                if($("#"+categoryId).hasClass("btn-green-deselected")){
                    $("#"+categoryId).removeClass( "btn-green-deselected" ).addClass( "btn-green-selected" );
                    totalSelectedCategories ++;
                }
                else if($("#"+categoryId).hasClass("btn-green-selected")){
                    $("#"+categoryId).removeClass( "btn-green-selected" ).addClass( "btn-green-deselected" );
                    totalSelectedCategories --;
                }
            break;

            case 3:
            case 10:
            case 17:
                if($("#"+categoryId).hasClass("btn-red-deselected")){
                    $("#"+categoryId).removeClass( "btn-red-deselected" ).addClass( "btn-red-selected" );
                    totalSelectedCategories ++;
                }
                else if($("#"+categoryId).hasClass("btn-red-selected")){
                    $("#"+categoryId).removeClass( "btn-red-selected" ).addClass( "btn-red-deselected" );
                    totalSelectedCategories --;
                }
            break;

            case 4:
            case 11:
            case 18:
                if($("#"+categoryId).hasClass("btn-yellow-deselected")){
                    $("#"+categoryId).removeClass( "btn-yellow-deselected" ).addClass( "btn-yellow-selected" );
                    totalSelectedCategories ++;
                }
                else if($("#"+categoryId).hasClass("btn-yellow-selected")){
                    $("#"+categoryId).removeClass( "btn-yellow-selected" ).addClass( "btn-yellow-deselected" );
                    totalSelectedCategories --;
                }
            break;

            case 5:
            case 12:
                if($("#"+categoryId).hasClass("btn-orange-deselected")){
                    $("#"+categoryId).removeClass( "btn-orange-deselected" ).addClass( "btn-orange-selected" );
                    totalSelectedCategories ++;
                }
                else if($("#"+categoryId).hasClass("btn-orange-selected")){
                    $("#"+categoryId).removeClass( "btn-orange-selected" ).addClass( "btn-orange-deselected" );
                    totalSelectedCategories --;
                }
            break;

            case 6:
            case 13:
                if($("#"+categoryId).hasClass("btn-pink-deselected")){
                    $("#"+categoryId).removeClass( "btn-pink-deselected" ).addClass( "btn-pink-selected" );
                    totalSelectedCategories ++;
                }
                else if($("#"+categoryId).hasClass("btn-pink-selected")){
                    $("#"+categoryId).removeClass( "btn-pink-selected" ).addClass( "btn-pink-deselected" );
                    totalSelectedCategories --;
                }
            break;

            case 7:
            case 14:
                if($("#"+categoryId).hasClass("btn-purple-deselected")){
                    $("#"+categoryId).removeClass( "btn-purple-deselected" ).addClass( "btn-purple-selected" );
                    totalSelectedCategories ++;
                }
                else if($("#"+categoryId).hasClass("btn-purple-selected")){
                    $("#"+categoryId).removeClass( "btn-purple-selected" ).addClass( "btn-purple-deselected" );
                    totalSelectedCategories --;
                }
            break;

            default:
                if($("#"+categoryId).hasClass("btn-purple-deselected")){
                    $("#"+categoryId).removeClass( "btn-purple-deselected" ).addClass( "btn-purple-selected" );
                    totalSelectedCategories ++;
                }
                else if($("#"+categoryId).hasClass("btn-purple-selected")){
                    $("#"+categoryId).removeClass( "btn-purple-selected" ).addClass( "btn-purple-deselected" );
                    totalSelectedCategories --;
                }
                break;
    }
    // If the user selected at least two categories, the submit button gets enabled
    if(totalSelectedCategories>=2){
        $('#category-submit-btn').prop('disabled', false);
    } 
    else{
        $('#category-submit-btn').prop('disabled', true);
    }
}






});

function validate_category_selection()
{
    hideGeneralMessage();   // Hides general messages div every time the function is launched
    // If the button, for some reason, enables but the user selected less than 2 categories
    if(totalSelectedCategories<2 && !($('#category-submit-btn').prop('disabled'))){
        $("#category-info-text").addClass("text-danger");
        $('#category-submit-btn').prop('disabled', true);
    }
    else{
        // We look for the selected buttons by getting the ones with a class named "btn-...-selected"
        $('[class*=btn-][class*=-selected]').each( function(i,e) {
            // We push inside the global array the categories 
            selectedCategories.push($(e).attr('id'));
        });
        if(selectedCategories){
            //ajax "category_selection"

            $.ajax({
                url: "controller/ViewsController.php",
                method: "POST",
                data: { option:"category_selection", categories:selectedCategories}
            })
            .done(function(data) {
                if(data){ 
                    var parsedData = $.parseJSON(data);
                    if(parsedData["id"] == "categories"){
                        // if there's a PHP validation error 
                        $('#general').text(parsedData["text"]);
                        showGeneralMessage();
                        $('#category-submit-btn').prop('disabled', false);
                    }
                    else{
                        // Categories correctly added to registered user
                        // We send the user to the main page, logged in
                        window.location.href ='home';
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
}




