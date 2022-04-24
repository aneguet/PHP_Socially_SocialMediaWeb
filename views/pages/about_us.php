<?php
$c = new CompanyController();
$info = $c->getCompanyInfo();
$developers = $c->getCompanyDevelopers();
$webInsights = $c->getCompanyWebInsights();

?>
<div class="row">
    <?php
    echo '<script type="text/javascript">scrollToTop();</script>';
    ?>
    <div id="about-us-content" class="col col-lg-12 col-xs-12">
        <div id="about-us-header" class="d-flex align-items-center flex-column page-centering text-center">
            <img src="views/web/img/assets/logo.png" alt="socially_logo" />
            <h2><?php echo $info[0]['header_title'] ?></h2>
            <h3><?php echo $info[0]['header_desc'] ?></h3>
        </div>
        <div id="about-us-info" class="d-flex align-items-center flex-row page-centering justify-content-center">
            <div class="d-flex flex-column align-items-center justify-content-center section-margin">
                <p><i class="<?php echo $webInsights[0]['field_icon']; ?>"></i> <span><?php echo $webInsights[0]['field_title']; ?></span></p>
                <?php echo $webInsights[0]['field_desc']; ?>
            </div>
            <div class="d-flex flex-column align-items-center justify-content-center section-margin">
                <p><i class="<?php echo $webInsights[1]['field_icon']; ?>"></i> <span><?php echo $webInsights[1]['field_title']; ?></span></p>
                <?php echo $webInsights[1]['field_desc']; ?>
            </div>
            <div class="d-flex flex-column align-items-center justify-content-center">
                <p><i class="<?php echo $webInsights[2]['field_icon']; ?>"></i> <span><?php echo $webInsights[2]['field_title']; ?></span></p>
                <?php echo $webInsights[2]['field_desc']; ?>
            </div>
        </div>
        <div id="about-us-avatars" class="d-flex align-items-center flex-column page-centering justify-content-center">
            <div>
                <h3>About the creators</h3>
            </div>
            <div class="d-flex flex-row">
                <div class="d-flex flex-column justify-content-center align-items-center dev-1">
                    <img class="img-dev-1" src="https://i.imgur.com/yoyKPg4.png" alt="anna_avatar" />
                    <p class="d-flex text-center dev1-name mb-1"><?php echo $developers[0]['name']; ?> <?php echo $developers[0]['surname']; ?></p>
                    <span class="hr-separator"></span>
                    <p class="d-flex text-center dev1-profession"><?php echo $developers[0]['profession']; ?></p>
                </div>
                <div class="d-flex flex-column justify-content-center align-items-center dev-2">
                    <img class="img-dev-2" src="https://i.imgur.com/AebmHmJ.png" alt="andres_avatar" />
                    <p class="d-flex text-center dev2-name mb-1"><?php echo $developers[1]['name']; ?> <?php echo $developers[1]['surname']; ?></p>
                    <span class="hr-separator"></span>
                    <p class="d-flex text-center dev2-profession"><?php echo $developers[1]['profession']; ?></p>
                </div>
            </div>
        </div>
        <div id="about-us-footer" class="d-flex align-items-center flex-column justify-content-center page-centering">
            <div>
                <button class="btn section-margin"><i class="fab fa-linkedin-in"></i></button>
                <button class="btn section-margin"><i class="fab fa-twitter"></i></button>
                <button class="btn section-margin"><i class="fab fa-facebook-f"></i></button>
                <button class="btn"><i class="fab fa-instagram"></i></button>
            </div>
            <div id="footer-text" class="d-flex flex-row align-items-center justify-content-center">
                <p class="mt-0 mb-0 "><?php echo $info[0]['rights'] ?> <i class="far fa-copyright"></i></p>
                <span class="section-margin">|</span>
                <p class="mt-0 mb-0 "><?php echo $info[0]['address'] ?></p>
                <span class="section-margin">|</span>
                <p class="mt-0 mb-0"><?php echo $info[0]['phone'] ?></p>
            </div>

        </div>
    </div>

</div>
</div>