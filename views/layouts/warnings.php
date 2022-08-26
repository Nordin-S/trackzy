<?php
/**
 * BY: Nordin Suleimani <nordin.suleimani@email.com>
 * DATE: 8/15/2022
 * TIME: 11:20 PM
 * COURSE: Webbprogrammering DT058G
 * SUPERVISOR: Mikael Hasselmalm
 */
use app\core\Application;
?>
<?php if (Application::$app->session->getFlash('success')): ?>
    <div class="alert alert-success flash-alert" tabindex="-1" id="flash-alert">
        <?php echo Application::$app->session->getFlash('success') ?>
    </div>
<?php endif; ?>
<?php if (Application::$app->session->getFlash('warning')): ?>
    <div class="alert alert-warning flash-alert"  tabindex="-1" id="flash-alert">
        <?php echo Application::$app->session->getFlash('warning') ?>
    </div>
<?php endif; ?>
<?php if (Application::$app->session->getFlash('danger')): ?>
    <div class="alert alert-danger flash-alert"  tabindex="-1" id="flash-alert">
        <?php echo Application::$app->session->getFlash('danger') ?>
    </div>
<?php endif; ?>
