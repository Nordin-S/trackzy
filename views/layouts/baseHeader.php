<?php
/**
 * BY: Nordin Suleimani <nordin.suleimani@email.com>
 * DATE: 8/15/2022
 * TIME: 11:20 PM
 * COURSE: Webbprogrammering DT058G
 * SUPERVISOR: Mikael Hasselmalm
 */
/** @var $title \app\core\View */
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
    <link rel="stylesheet" href="/css/style.css">
    <link rel="icon" href="/img/trackzy-logo2.svg" sizes="any" type="image/svg+xml">

    <!--    Google font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Varela+Round&display=swap" rel="stylesheet">
    <!--     Font Awesome -->
    <script src="https://kit.fontawesome.com/30da6e6dc2.js" crossorigin="anonymous"></script>

    <title>Trackzy <?php echo $title; ?></title>
</head>
<body id="bs-override">
<?php
include_once($_ENV['ROOT_DIR'] . 'views/layouts/warnings.php')
?>
<div class="ballury-wrap">
    <div class="ballury-wrap ballury-ball"></div>
</div>
<div class="font-resizer navbar fixed-bottom justify-content-center">
  <div class="bg-dark mx-2" onclick="document.body.style.fontSize ='1em'"><i class="fa-solid fa-a fa-sm py-4"></i></div>
  <div class="bg-dark mx-2" onclick="document.body.style.fontSize ='1.2em'"><i class="fa-solid fa-a fa-lg py-4"></i></div>
  <div class="bg-dark mx-2" onclick="document.body.style.fontSize ='1.4em'"><i class="fa-solid fa-a fa-2xl py-4"></i></div>
</div>