
// Bytes equivalences
const TB = 1099511627776;
const GB = 1073741824;
const MB = 1048576;
const KB = 1024;
let imageHeight = 0;
let imageWidth = 0;
let imageRatio = 0;

$(document).ready(function () {

  loadEditor = function(){
    tinymce.remove("textarea#description");
    tinymce.init({
      selector: 'textarea#description',
      toolbar_mode:'floating',
      // icon groups in toolbar
      toolbar: 'undo redo | styleselect | bold italic underline strikethrough formatpainter | alignment | lists',
      toolbar_groups: {
        alignment: {
          icon: 'align-left',
          items: 'alignleft aligncenter alignright alignjustify'
        },
        lists: {
          icon: 'ordered-list',
          items: 'numlist bullist'
        }
      },
      plugins: 'formatpainter lists',
      // lists indent 
      lists_indent_on_tab: false,
      // Removes the menu bar (File, Edit, View and Format)
      menubar : false,
      // If false, removes the resizing option
      statusbar:true,
    });

  }

  submitNewPostForm = function () {
    hideGeneralMessage();   // Hides general messages div every time the function is launched
    resetNewPostErrorMessages();   // Reset error messages
    //Files can be sent through AJAX using the FormData object.
    //The AJAX call must specify contentType and processdata otherwise it won't work.
    // We retrieve the form data before validation, only to have all the fields
    mydata = $("#new-post-form")[0];
    let formData = new FormData(mydata);

    // Fields retrievement
    let title = $('#new-post-form #title').val().trim();
    formData.set('title', title);
    // Category
    let category = $('#new-post-form #category').val().trim();
    formData.set('category', category);
    let description = "";
    // For validation, we retrieve the textarea editor content as "text" (plain text)
    let plainDescription = tinyMCE.activeEditor.getContent({format : 'text'}).trim();
    // If validation is okay, we retrieve the textarea editor content as "raw" (with tags)
    let editorDescription = tinyMCE.activeEditor.getContent({format : 'raw'});
    let imageFile;
    if($('#new-post-form #imgfile').get(0).files[0]){
      imageFile = $('#new-post-form #imgfile').get(0).files[0];
    }
    formData.append("option", "new_post_form");
    
    if(validateNewPostFields(title,category,plainDescription,editorDescription,imageFile,formData)){
      $.ajax({
        method: "POST",
        url: "controller/ViewsController.php",
        contentType: false, // to tell jQuery to not set any content type header.
        processData: false, //  to send a DOMDocument, or other non-processed data it has to be set to false
        data: formData
        //dataType: "json",
      })
        .done(function (data) {
          if(data){
            var parsedData = $.parseJSON(data);
            if(typeof parsedData === 'boolean'){ // true or false
              if(parsedData) {// post succesfully created
                // Redirect to the specific category page to see the created new post 
                redirectToCategoryPage(formData.get('category'));
              }
              else{// Errors
                $('#general-message #general').text("Ooops! Something went wrong.");
                showGeneralMessage();
                emptyImageField();
              }
              
            }
            else{ 
              
              if(parsedData["id"] == "title"){
                $('#title-error').text(parsedData["text"]);
              }
              else if(parsedData["id"] == "category"){
                  $('#category-error').text(parsedData["text"]);
              }
              else if(parsedData["id"] == "description"){
                  $('#description-error').text(parsedData["text"]);
              }
              else if(parsedData["id"] == "image"){
                  $('#image-error').text(parsedData["text"]);
              }
              else if(parsedData["id"] == "general"){
                $('#general-message #general').text(parsedData["text"]);
                showGeneralMessage();
              }
              emptyImageField();
            }
          }
          else{
            $('#general-message #general').text("Ooops! Something went wrong.");
            showGeneralMessage();
            emptyImageField();
          }

        })
        .fail(function (jqXHR, textStatus, errorThrown) {
          $('#general-message #general').text("Ooops! Something went wrong.");
          showGeneralMessage();
          emptyImageField();
        });

    }

  };
  
});
// Validation 
function validateNewPostFields(title,category,plainDescription,editorDescription,imageFile,formData){
  let dataIsValid = true;
  // TITLE
  if(isEmptyOrSpaces(title)){
    $("#title-error").text('Title cannot be empty');
    dataIsValid=false;
  }
  else if(title.length<4){
    $("#title-error").text('Title must have at least 4 characters');
    dataIsValid=false;
  }
  // CATEGORY
    else if(category=="Category"){
      $("#category-error").text('Category cannot be empty');
      dataIsValid=false;     
    }  
  // IMAGE
  // Posts must have an image or a description: Posts with photo can have a description or not | Posts without photo must have a description

  else if(isEmptyOrSpaces(plainDescription) && (!imageFile)){
    $('#image-error').text("A post must have a description or an image.");
    dataIsValid=false;
  }
  // DESCRIPTION AND IMAGE
  // If there is no description but there is an image, we send an empty description
  else if(isEmptyOrSpaces(plainDescription) && imageFile){
    description = plainDescription;
  }
  else if(!isEmptyOrSpaces(plainDescription)){
    description = editorDescription;
    // Description is not empty but has less than 4 characters
    if(plainDescription.length<4){
      $("#description-error").text('Description must have at least 4 characters');
      dataIsValid=false;
    } // We check the total bytes of the description
    else if(byteCount(plainDescription)>15000){
      $("#description-error").text('Description is too long');
      dataIsValid=false;
    }
  }
  // Image specific validation 
  if (!imageFile) {// If there is no image, we set its value to empty
    imageFile = "";
    formData.set('imgfile', "");
  }
  if(imageFile){ 
    
    formData.set('imgfile', $('#new-post-form #imgfile').get(0).files[0]);

    if (isImageTheSupportedType(imageFile['type'])) {
      //and size meet the criteria 
      if (isImageBiggerThan2MB(imageFile['size'])) {
        $('#image-error').text("Maximum image size is 2MB");
        dataIsValid = false;
      }
      else if(imageWidth<554){// Image width is too small
        $('#image-error').text("Image is too small. Choose an image of a minimum width of 554px.");
        dataIsValid = false;
      }
      else if(imageWidth>1920 || imageHeight>1920){// The image is too big in px
        $('#image-error').text("Image width or height can't be bigger than 1920px.");
        dataIsValid = false;
      }
      else if(imageRatio<0.5){ // Image's height size is too big
        $('#image-error').text("Image height is too big in relation to its width. (Accepted ratios: 0.5-3)");
        dataIsValid = false;
      }
      else if(imageRatio>3){ // Image's width size is too big
        $('#image-error').text("Image width is too big in relation to its height. (Accepted ratios: 0.5-3)");
        dataIsValid = false;
      }
    } else {
      $('#image-error').text("Only jpeg, jpg, png and gif images are allowed");
        dataIsValid = false;
    }
  } 
  formData.set('description', description);
  return dataIsValid;
}

// If user wants to remove the image on the post
function removeAttachedImage () {
  // We only call the function if there's an image to remove
  if($("#new-post-form #imgfile").val()){
    emptyImageField();
  }
}
function resetNewPostErrorMessages() {
    $("#title-error").val('');
    $("#title-error").text("");
    $("#category-error").val('');
    $("#category-error").text("");
    $("#description-error").val('');
    $("#description-error").text("");
    $("#avatar-error").val('');
    $("#avatar-error").text("");
  }
  
function emptyImageField(){
  $("#new-post-form #imgfile").val('');
  
}

function redirectToCategoryPage(categoryName){
  loadSpecificCategory(categoryName);
}

 // Image functions
 function isImageTheSupportedType(imageType)
 {
     if ((imageType == "image/jpeg" ||
         imageType == "image/jpg"   ||
         imageType == "image/png"   ||
         imageType == "image/gif")) {
         return true;
     } else {
         return false;
     }
 }
 // File image format is Bytes
 function isImageBiggerThan2MB(imageSize)
 {
     if (imageSize > 2 * MB) {
         return true;
     }
     return false;
 }

// When an image is uploaded, its dimensions are saved in global variables
function getImageDimensions(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    reader.onload = function (e) {
      var img = new Image;
      img.onload = function() {
        imageHeight = img.height;
        imageWidth = img.width;
        imageRatio = imageWidth/imageHeight; 
      };
      img.src = reader.result;
    };
    reader.readAsDataURL(input.files[0]);
  }
}


