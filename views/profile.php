<?php
/**
 * BY: Nordin Suleimani <nordin.suleimani@gmail.com>
 * DATE: 8/15/2022
 * TIME: 11:20 PM
 * COURSE: Webbprogrammering DT058G
 * SUPERVISOR: Mikael Hasselmalm
 */
/** @var $model \app\models\User */
/** @var $title \app\core\View */
$this->title = $title;

$userRole = '';
if ($model->role == 0) {
    $userRole = 'Admin';
} else if ($model->role == 1) {
    $userRole = 'Moderator';
} else if ($model->role == 2) {
    $userRole = 'Author';
}
$avatarImgAlt = $userRole . ' avatar';
?>


<div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-12 col-md-8 col-lg-5 col-xl-4 text-center">
            <h2 class="d-block text-truncate mb-3"><?php echo $userRole ?></h2>
            <div class="card text-white">
                <div class="text-center py-2 profile-avatar profile-<?php echo strtolower($userRole) ?>-avatar">
                    <img src="img/<?php echo strtolower($userRole) ?>-avatar.jpg" class="img-responsiverounded" width="120" alt="<?php echo $avatarImgAlt ?>">
                </div>
                <div class="p-4 text-left">
                    <div class="mb-md-2 pb-1">
                        <div class="mt-3 flex-row justify-content-center text-center">
                            <h5><?php echo $model->username ?></h5>
                            <span>Member since <?php echo date("F d, Y", strtotime($model->created_at)) ?></span>
                        </div>
                        <div class="mt-3 text-center">
                            <a href="<?php echo $model->email ?>" class="btn mt-5 btn-primary rounded-lg">Contact</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
