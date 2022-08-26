<?php
/**
 * BY: Nordin Suleimani <nordin.suleimani@email.com>
 * DATE: 8/15/2022
 * TIME: 11:20 PM
 * COURSE: Webbprogrammering DT058G
 * SUPERVISOR: Mikael Hasselmalm
 */
use app\core\Application;
/** @var $title */
?>
<div class="container">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-12 col-md-8 col-lg-5 col-xl-4 text-center">
                <a href="/">
                    <img src="/img/trackzy-logo2.svg" id="logo-hero" alt="trackzy logo">
                </a>
                <br>
                <h2><?php echo $title;  ?></h2>
                <div class="card text-white">
                    <div class="p-4 text-left">
                        <div class="mb-md-2 pb-1">
                            <h2 class="lead"><span class="text-danger">Opps!</span> Could not connect to the database</h2>
                            <p class="lead text-info">Edit .env file in the project root folder with your Database information.</p>
                            <a class="btn btn-primary rounded-lg btn-block" href="/">Retry</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
