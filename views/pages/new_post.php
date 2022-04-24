<?php
$c = new CategoryController();
$categories = $c->loadCategories();
?>

<div class="row d-flex justify-content-center min-vh-100">

  <div id="post-form" class="col col-lg-10">
    <section>
      <div class="container-form min-vh-100">
        <!-- Standard top popup message -->
        <div class="text-center mb-3 alert alert-danger py-2 fade show d-none" role="alert" id="general-message">
          <span class="my-2 " id="general"></span>
        </div>
        <h2 class="f-heading">
          <span>New post</span>
        </h2>
        <form action="" method="post" enctype="multipart/form-data" id="new-post-form">
          <div class="form-group">
            <label for="title">Title<span class="required_field_dark">*</span></label>
            <input type="text" name="title" id="title">
            <span class="msg error-message-dark my-2" id="title-error">
          </div>
          <div class="form-group">
            <label for="category">Category<span class="required_field_dark">*</span></label>
            <select name="category" id="category">
              <option value="Category">Select category</option>
              <?php foreach ($categories as $category) { ?>
                <option value="<?php echo $category['category_name'] ?>"><?php echo $category['category_name'] ?></option>
              <?php } ?>
            </select>
            <span class="msg error-message-dark my-2" id="category-error">
          </div>
          <div class="form-group">
            <label for="title">Description</label>
            <textarea type="text" name="description" id="description"></textarea>
            <span class="msg error-message-dark my-2" id="description-error">
          </div>
          <div class="form-group d-flex mb-1">
            <input type="file" name="imgfile" id="imgfile" onchange="getImageDimensions(this);">
            <button id="remove-img-btn" class="btn" type="button" onclick="removeAttachedImage()">Remove attached image</button>
          </div>
          <div><span class="msg error-message-dark my-2" id="image-error"></div>
          <button class="btn" type="button" id="new_post-submit-btn" onclick="submitNewPostForm()"> Create</button>
        </form>
      </div>
    </section>
  </div>
  <?php
  echo '<script type="text/javascript">loadEditor();</script>';
  ?>
</div>