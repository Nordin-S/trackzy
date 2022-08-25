<?php
use app\core\Application;

include_once($_ENV['ROOT_DIR'] . 'views/layouts/baseHeader.php')
?>
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
            <?php if (!Application::isGuest()): ?>
                <li class="nav-item<?php echo ($this->title === 'View Issues') ? ' active' : ''; ?>">
                    <a class="nav-link" href="/issues">Issues</a>
                </li>
                <li class="nav-item<?php echo ($this->title === 'Create Issue') ? ' active' : ''; ?>">
                    <a class="nav-link" href="/new-issue">New issue</a>
                </li>
                <li class="nav-item<?php echo ($this->title === 'Registered users list') ? ' active' : ''; ?>">
                    <a class="nav-link" href="/users-list">Users</a>
                </li>
                <div class="dropdown-divider d-lg-none"></div>
                <li class="nav-item <?php echo ($this->title === 'Profile') ? ' active' : ''; ?> d-lg-none">
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

<?php
include_once($_ENV['ROOT_DIR'] . 'views/layouts/footerBase.php')
?>
