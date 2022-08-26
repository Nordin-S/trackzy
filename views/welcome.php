<?php
/**
 * BY: Nordin Suleimani <nordin.suleimani@email.com>
 * DATE: 8/15/2022
 * TIME: 11:20 PM
 * COURSE: Webbprogrammering DT058G
 * SUPERVISOR: Mikael Hasselmalm
 */
/** @var $title \app\core\View */
$this->title = $title;
?>

<!-- Hero head-->
<header class="hero-header">
    <div class="container px-4 px-lg-5 d-flex h-100 align-items-center justify-content-center">
        <div class="d-flex justify-content-center">
            <div class="text-center">
                <h1 class="mx-auto my-0 text-uppercase" tabindex="-1">INTRODUCING TRACKZY</h1>
                <h2 class="text-white-50 mx-auto mt-2 mb-5">A MVC based issue tracker made as a university class
                    project.</h2>
                <a href="#instructions" class="smooth-anchor">
                    <span class="vis-hidden">Hit enter to scroll down to testing instructions</span>
                    <i class="fa-solid fa-circle-arrow-down fa-2xl arrow-read-down"></i></a>
            </div>
        </div>
    </div>
</header>
<!-- Instructions-->
<section class="instructions-section text-center" id="instructions">
    <div class="row gx-2 gx-lg-5 justify-content-center">
        <div class="col-lg-6">
            <h2 class="text-dark mb-4">TESTING INSTRUCTIONS</h2>
            <p class="text-dark muted">
                Followings are testing instructions for my teacher.
            </p>
            <div class="list-group">
                <div class="w-100 justify-content-between text-left">
                    <div class="alert alert-secondary">
                        <h4 class="mb-1">1. Hello World!</h4>
                        <p class="mb-1">
                            If you see this page for the first time, then congratulations you are an administrator.
                        </p>
                    </div>
                    <div class="alert alert-secondary">
                        <h4 class="mb-1">2. Log in/Log out and password reset</h4>
                        <p class="mb-1">
                            Lets begin by testing the log in system.
                            Go ahead and log out, go to the login page and press forgot password, once you have reset
                            your password log back in again. Don't forget to try wrong inputs and such.

                        </p>

                    </div>
                    <div class="alert alert-secondary">
                        <h4 class="mb-1">3. Manage users</h4>
                        <p class="mb-1">
                            New users can't register on this site without being invited. Head on to the users page
                            and try inviting a new user(you need to have a second email address to test this feature).
                            Make sure the new user you invite has author or moderator as role. Hint, you will get a
                            email to the newly invited users mail account. Before you register with the new user try to
                            revoke the invitation. Once revoked, redo the invite(again as an author or moderator).
                            <br>
                            While you are here, go ahead and try deleting your own account.
                            <br>
                            Now, log out with your admin account and log in with the new user.
                        </p>
                    </div>
                    <div class="alert alert-secondary">
                        <h4 class="mb-1">4. 403/404 errors</h4>
                        <p class="mb-1">
                            Try getting into the users page again, then try to change the address bar adding a random
                            word at the end of the url.
                        </p>
                    </div>
                    <div class="alert alert-secondary">
                        <h4 class="mb-1">5. User profile</h4>
                        <p class="mb-1">
                            Using the main navbar open the dropdown menu on the right side of the navbar and
                            enter your profile page, you can also get to your profile or other users profile from the
                            users page but only if you are an administrator.
                        </p>
                    </div>
                    <div class="alert alert-secondary">
                        <h4 class="mb-1">6. Extra</h4>
                        <p class="mb-1">
                            Don't forget to try out responsiveness of pages, resizing page font using buttons stuck to
                            the bottom of the scree. And lastly turn on you systems narrator and test out accessibility.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
