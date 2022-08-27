<?php
/**
 * BY: Nordin Suleimani <nordin.suleimani@gmail.com>
 * DATE: 8/15/2022
 * TIME: 11:20 PM
 * COURSE: Webbprogrammering DT058G
 * SUPERVISOR: Mikael Hasselmalm
 */
/** @var $model \app\models\RecoverPassword */
/** @var $title \app\core\View */
$this->title = $title;
?>

<?php $form = \app\core\form\Form::begin('#', 'post') ?>
<?php echo $form->field($model, 'email')->setExtras('email') ?>
<button type="submit" class="btn btn-primary rounded-lg btn-block">Recover</button>
<?php echo \app\core\form\Form::end(); ?>
