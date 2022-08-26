<?php
/** @var $model \app\models\Login */
/** @var $title \app\core\View */
$this->title = $title;
?>
<?php $form = \app\core\form\Form::begin('#', 'post') ?>
<?php echo $form->field($model, 'email')->setExtras('email') ?>
<?php echo $form->field($model, 'password')->setExtras('password') ?>
<p class="small mb-2 pb-lg-2 text-center"><a class="text-white-50" href="/recover-password">Forgot password?</a></p>
<button type="submit" class="btn btn-primary rounded-lg btn-block">Login</button>
<?php echo \app\core\form\Form::end(); ?>
