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

    <title>Trackzy - <?php echo $this->title; ?></title>
</head>
<body id="bs-override">
<div class="ballury-wrap">
    <div class="ballury-wrap ballury-ball"></div>
</div>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="/">
        <img src="/img/trackzy-logo2.svg" width="30" height="30" alt="">
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item<?php echo ($this->title === 'View Issues') ?  ' active' : ''; ?>">
                <a class="nav-link" href="/">Issues</a>
            </li>
            <li class="nav-item<?php echo ($this->title === 'Create Issue') ?  ' active' : ''; ?>">
                <a class="nav-link" href="/new-issue">New issue</a>
            </li>
            <li class="nav-item<?php echo ($this->title === 'Registered users list') ?  ' active' : ''; ?>">
                <a class="nav-link" href="/users-list">Users</a>
            </li>
            <?php if (!Application::isGuest()): ?>
                <div class="dropdown-divider d-lg-none"></div>
                <li class="nav-item <?php echo ($this->title === 'Profile') ?  ' active' : ''; ?> d-lg-none">
                    <a class="nav-link" href="/profile">Profile</a>
                </li>
                <li class="nav-item d-lg-none">
                    <a class="nav-link" href="/logout">Logout</a>
                </li>
            <?php endif; ?>
        </ul>
        <?php if (Application::isGuest()): ?>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="/login">Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/register">Register</a>
                </li>
            </ul>
        <?php else: ?>
            <ul class="navbar-nav flex-row ml-md-auto d-none d-lg-flex">
                <li class="nav-item dropdown show">
                    <a class="nav-item nav-link dropdown-toggle mr-md-2" href="#" id="login-menu"
                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa-solid fa-circle-user fa-lg"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right pb-3" aria-labelledby="login-menu">
                        Signed in as <?php echo Application::$app->user->getUsername(); ?>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="/profile">Profile</a>
                        <a class="dropdown-item" href="/logout">Logout</a>
                    </div>
                </li>
            </ul>
        <?php endif; ?>
    </div>
</nav>

<div class="container">
    <?php if (Application::$app->session->getFlash('success')): ?>
        <div class="alert alert-success flash-alert" id="flash-alert">
            <?php echo Application::$app->session->getFlash('success') ?>
        </div>
    <?php endif; ?>
    <?php if (Application::$app->session->getFlash('warning')): ?>
        <div class="alert alert-warning flash-alert" id="flash-alert">
            <?php echo Application::$app->session->getFlash('warning') ?>
        </div>
    <?php endif; ?>
    <?php if (Application::$app->session->getFlash('danger')): ?>
        <div class="alert alert-danger flash-alert" id="flash-alert">
            <?php echo Application::$app->session->getFlash('danger') ?>
        </div>
    <?php endif; ?>
    {{content}}
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
