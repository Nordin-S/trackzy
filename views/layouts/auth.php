<?php
use app\core\Application;
include_once($_ENV['ROOT_DIR'] . 'views/layouts/baseHeader.php')
?>

<div class="container">
    <?php if (Application::$app->session->getFlash('success')): ?>
        <div class="alert alert-success flash-alert">
            <?php echo Application::$app->session->getFlash('success') ?>
        </div>
    <?php endif; ?>
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-12 col-md-8 col-lg-5 col-xl-4 text-center">
                <a href="/">
                    <img src="/img/trackzy-logo2.svg" id="logo-hero" alt="trackzy logo">
                </a>
                <br>
                <h2 class="d-block text-truncate mb-3"><?php echo $this->title; ?></h2>
                <div class="card text-white">
                    <div class="p-4 text-left">
                        <div class="mb-md-2 pb-1">
                            {{content}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include_once($_ENV['ROOT_DIR'] . 'views/layouts/footerBase.php')
?>