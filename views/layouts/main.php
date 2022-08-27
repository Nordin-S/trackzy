<?php
/**
 * BY: Nordin Suleimani <nordin.suleimani@gmail.com>
 * DATE: 8/15/2022
 * TIME: 11:20 PM
 * COURSE: Webbprogrammering DT058G
 * SUPERVISOR: Mikael Hasselmalm
 */

use app\core\Application;

include_once($_ENV['ROOT_DIR'] . 'views/layouts/baseHeader.php');
include_once($_ENV['ROOT_DIR'] . 'views/layouts/warnings.php');
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark" id="navbar">
    <a class="navbar-brand" href="/">
        <img src="/img/trackzy-logo2.svg" width="30" height="30" alt="Trackzy logo, links to main page">
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
                <li class="nav-item <?php echo ($this->title === 'Profile') ? ' active' : ''; ?> d-lg-none">
                    <hr class="dropdown-divider d-lg-none">
                    <a class="nav-link" href="/profile?id=<?php echo $_SESSION['user'] ?>">Profile</a>
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
                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" aria-label="toggle navigation menu">
                        <i class="fa-solid fa-circle-user fa-lg"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right pb-3" aria-labelledby="login-menu">
                        Signed in as <?php echo Application::$app->user->getUsername(); ?>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="/profile?id=<?php echo $_SESSION['user'] ?>">Profile</a>
                        <a class="dropdown-item" href="/logout">Logout</a>
                    </div>
                </li>
            </ul>
        <?php endif; ?>
    </div>
</nav>
{{content}}

<?php
include_once($_ENV['ROOT_DIR'] . 'views/layouts/footerBase.php')
?>
