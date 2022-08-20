<?php
/** @var $exception Exception */
?>
<div class="d-flex align-items-center justify-content-center vh-100 position-absolute fixed-top">
    <div class="text-center">
        <img class="pb-3" src="<?php echo $exception->getImg() ?>" width="128" alt="<?php echo $exception->getCode() ?> - error">
        <h1 class="display-2 pb-2"><?php echo $exception->getCode() ?></h1>
        <p class="lead"><span class="text-danger">Opps!</span> <?php echo $exception->getMessage() ?></p>
    </div>
</div>