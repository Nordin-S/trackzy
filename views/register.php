<?php
/** @var $model \app\models\User */
/** @var $title \app\core\View */
$this->title = $title;
?>


<?php

if (isset($model)) {
    if (isset($model->invitecode)) {
//        echo '<h3>Sign up for ' . $model->email . '</h3>';
    }
    $form = \app\core\form\Form::begin('', 'post');
    echo $form->field($model, 'username')->setExtras('text');
//    echo $form->field($model, 'email')->setExtras('email');
    echo $form->field($model, 'password')->setExtras('password');
    echo $form->field($model, 'passwordConfirmation')->setExtras('password');
    echo '<button type="submit" class="btn btn-primary rounded-lg btn-block">Submit</button>';
    echo \app\core\form\Form::end();
} else {

    echo '<h2 class="lead" ><span class="text-danger" > Opps!</span > Could not find invitation code.</h2>';
    echo '<p class="lead text-info">Please refer to the invitation email you got from your IT admin and click the
            "REGISTER" button to get back to this page.</p>';
}
?>