<?php

use app\core\Application;

?>
<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!-- Trackzy CSS -->
    <link rel="stylesheet" href="\css\style.css">
    <link rel="icon" href="\img\trackzy-logo2.svg" sizes="any" type="image/svg+xml">

    <!--    Google font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Varela+Round&display=swap" rel="stylesheet">
    <!--     Font Awesome -->
    <script src="https://kit.fontawesome.com/30da6e6dc2.js" crossorigin="anonymous"></script>

    <title>Trackzy <?php echo $title; ?></title>
</head>
<body id="bs-override">
<div class="ballury-wrap">
    <div class="ballury-wrap ballury-ball"></div>
</div>

<div class="container">
<!--    --><?php //if (Application::$app->session->getFlash('success')): ?>
<!--        <div class="alert alert-success flash-alert">-->
<!--            --><?php //echo Application::$app->session->getFlash('success') ?>
<!--        </div>-->
<!--    --><?php //endif; ?>
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-12 col-md-8 col-lg-5 col-xl-4 text-center">
                <a href="/">
                    <img src="/img/trackzy-logo2.svg" id="logo-hero" alt="trackzy logo">
                </a>
                <br>
                <h2><?php  ?></h2>
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


<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>
<script src="/js/trackzy-main.js"></script>
</body>
</html>
