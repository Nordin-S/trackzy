<?php
/** @var $model \app\models\User */
/** @var $title \app\core\View */
$this->title = $title;
?>
<h2 class="lead pb-2">Create site administrator</h2>
<?php $form = \app\core\form\Form::begin('', 'post') ?>
<?php echo $form->field($model, 'username')->setExtras('text') ?>
<?php echo $form->field($model, 'email')->setExtras('email') ?>
<?php echo $form->field($model, 'password')->setExtras('password') ?>
<?php echo $form->field($model, 'passwordConfirmation')->setExtras('password') ?>
<button type="submit" class="btn btn-primary rounded-lg btn-block">Submit</button>
<?php echo \app\core\form\Form::end(); ?>
