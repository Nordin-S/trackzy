<?php
/** @var $model \app\models\User */
/** @var $title \app\core\View */
/** @var $email \app\core\View */
/** @var $recovery_token \app\core\View */
$this->title = $title;

?>


<?php $form = \app\core\form\Form::begin('', 'post') ?>
<?php echo $form->field($model, 'recovery_token')->setExtras('text', 'd-none ', 'd-none ', 'd-flex ') ?>
<?php echo $form->field($model, 'password')->setExtras('password') ?>
<?php echo $form->field($model, 'passwordConfirmation')->setExtras('password') ?>
<?php echo $form->field($model, 'email')->setExtras('email', 'd-none', 'd-none', 'd-none') ?>
    <p class="small mb-2 pb-lg-2 text-center">Your new password needs to be at least 8 characters</p>
    <button type="submit" class="btn btn-primary rounded-lg btn-block">Change password</button>
<?php echo \app\core\form\Form::end(); ?>