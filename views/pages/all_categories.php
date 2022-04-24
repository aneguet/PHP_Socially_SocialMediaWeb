<?php


// We load the categories as well to get the icons (we need them in case the category doesn't have posts)
$c = new CategoryController();
$categories = $c->loadCategories();

?>


<div class="row">
    <!-- Main content -->
    <div class="col col-lg-12 col-xs-12 all-categories d-flex flex-wrap justify-content-between" id='content'>

        <?php foreach ($categories as $category) { ?>
            <div class="card text-center" id="<?php echo $category['category_name'] ?>" onclick="loadSpecificCategory('<?php echo $category['category_name'] ?>')">
                <div class="card-body d-flex align-items-center justify-content-center">
                    <p class="card-text"><?php echo $category['category_name'] ?></p>
                </div>
            </div>
        <?php } ?>
    </div>
</div>