<?php

$session = new SessionHandle();
if ($session->confirm_logged_in()) {
    $redirect = new Redirector("../home/login.php");
}
$c = new CategoryController();
$categories = $c->loadCategories();

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Category selection</title>
    <!-- Bootstrap 5.1.3 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css">
    <!-- Stylesheets -->
    <link rel="stylesheet" href="views/web/css/login-signup.css" />
    <link rel="stylesheet" href="views/web/css/category_selection.css" />
    <link rel="stylesheet" href="views/web/css/utilities.css" />
    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body id="category-selection">
    <div class="container-fluid d-flex flex-column">
        <div class="row min-vh-100">
            <div id="category-selection-form" class="col col-lg-4 col-md-9 col-sm-12 col-xs-12 mx-auto form-wrap">
                <!-- Standard top popup message -->
                <div class="text-center mb-3 alert alert-danger py-2 fade show d-none" role="alert" id="general-message">
                    <span class="my-2 " id="general"></span>
                </div>
                <h3 class="text-center">Choose the categories that you are interested in</h3>
                <!-- -->
                <form method="post" action="" onsubmit="return false">
                    <div class="form-group d-flex flex-wrap justify-content-between">
                        <?php $count = 1; ?>
                        <?php foreach ($categories as $category) { ?>
                            <?php if ($count == 1 || $count == 8 || $count == 15) { ?>
                                <button type=" button" id="<?php echo $category['category_name'] ?>" class="category btn btn-style d-flex <?php echo 'btn-category-' . $count ?> btn-blue-deselected" onclick="selectCategory(<?php echo $count ?>,'<?php echo $category['category_name'] ?>')">
                                    <i class="<?php echo $category['icon'] ?> my-auto"></i>
                                    <?php echo $category['category_name'] ?>
                                </button>
                            <?php } elseif ($count == 2 || $count == 9 || $count == 16) { ?>
                                <button type=" button" id="<?php echo $category['category_name'] ?>" class="category btn btn-style d-flex <?php echo 'btn-category-' . $count ?> btn-green-deselected" onclick="selectCategory(<?php echo $count ?>,'<?php echo $category['category_name'] ?>')">
                                    <i class="<?php echo $category['icon'] ?> my-auto"></i>
                                    <?php echo $category['category_name'] ?>
                                </button>
                            <?php } elseif ($count == 3 || $count == 10 || $count == 17) { ?>
                                <button type=" button" id="<?php echo $category['category_name'] ?>" class="category btn btn-style d-flex <?php echo 'btn-category-' . $count ?> btn-red-deselected" onclick="selectCategory(<?php echo $count ?>,'<?php echo $category['category_name'] ?>')">
                                    <i class="<?php echo $category['icon'] ?> my-auto"></i>
                                    <?php echo $category['category_name'] ?>
                                </button>
                            <?php } elseif ($count == 4 || $count == 11 || $count == 18) { ?>
                                <button type=" button" id="<?php echo $category['category_name'] ?>" class="category btn btn-style d-flex <?php echo 'btn-category-' . $count ?> btn-yellow-deselected" onclick="selectCategory(<?php echo $count ?>,'<?php echo $category['category_name'] ?>')">
                                    <i class="<?php echo $category['icon'] ?> my-auto"></i>
                                    <?php echo $category['category_name'] ?>
                                </button>
                            <?php } elseif ($count == 5 || $count == 12) { ?>
                                <button type=" button" id="<?php echo $category['category_name'] ?>" class="category btn btn-style d-flex <?php echo 'btn-category-' . $count ?> btn-orange-deselected" onclick="selectCategory(<?php echo $count ?>,'<?php echo $category['category_name'] ?>')">
                                    <i class="<?php echo $category['icon'] ?> my-auto"></i>
                                    <?php echo $category['category_name'] ?>
                                </button>
                            <?php } elseif ($count == 6 || $count == 13) { ?>
                                <button type=" button" id="<?php echo $category['category_name'] ?>" class="category btn btn-style d-flex <?php echo 'btn-category-' . $count ?> btn-pink-deselected" onclick="selectCategory(<?php echo $count ?>,'<?php echo $category['category_name'] ?>')">
                                    <i class="<?php echo $category['icon'] ?> my-auto"></i>
                                    <?php echo $category['category_name'] ?>
                                </button>
                            <?php } else { ?>
                                <button type=" button" id="<?php echo $category['category_name'] ?>" class="category btn btn-style d-flex <?php echo 'btn-category-' . $count ?> btn-purple-deselected" onclick="selectCategory(<?php echo $count ?>,'<?php echo $category['category_name'] ?>')">
                                    <i class="<?php echo $category['icon'] ?> my-auto"></i>
                                    <?php echo $category['category_name'] ?>
                                </button>
                            <?php } ?>
                            <?php $count++; ?>
                        <?php }; ?>
                    </div>
                    <h6 id="category-info-text" class="text-center mt-3">Please, pick at least <u>two</u></h6>

                    <input disabled class="btn mb-3" type="button" value="Next" name="submit" id="category-submit-btn" onclick="validate_category_selection()">
                    <!-- <div id="omit-link" class="text-center mt-2"><u><a href="../../index.php">Omit</a></u></div> -->
                </form>

            </div>
        </div>
    </div>
    <!-- Validation -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script> -->

</body>
<script type="text/javascript" src="views/web/js/utils.js"></script>
<script type="text/javascript" src="views/web/js/category-selection.js"></script>

</html>