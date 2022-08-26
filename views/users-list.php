<?php
/**
 * BY: Nordin Suleimani <nordin.suleimani@email.com>
 * DATE: 8/15/2022
 * TIME: 11:20 PM
 * COURSE: Webbprogrammering DT058G
 * SUPERVISOR: Mikael Hasselmalm
 */
/** @var $model \app\models\GetUsers */
/** @var $title \app\core\View */
$this->title = $title;
?>

<div class="col-md-12 col-lg-8 m-auto px-2 pt-4">
    <img src="/img/trackzy-loader.svg" class="float-right" id="invite-loader" alt="invite loading indicator">
    <h1><?php echo $title ?></h1>
    <hr>
    <h2>Invite new user</h2>
    <form action="/invite" method="post">
        <div class="d-flex flex-row px-2">
            <label for="email" class="vis-hidden">Invite email: </label>
            <input type="text" class="mr-2 w-50 p-2" value="" name="email" placeholder="Invite email">
            <label for="role" class="vis-hidden">Role: </label>
            <select class="form-control mr-2 w-25 p-2" id="role" name="role">
                <option value="admin">Admin</option>
                <option value="moderator">Moderator</option>
                <option value="author">Author</option>
            </select>
            <button type="submit" name="submit"
                    class="btn ml-auto w-auto btn-primary rounded-lg float-right loading-btns">Invite user
            </button>
        </div>
    </form>
    <hr>
    <h2>Members</h2>
    <div class="card-table">
        <div class="table-responsive">
            <table class="table table-dark table-hover">
                <caption class="d-none">Users list</caption>
                <thead class="">
                <tr class="">
                    <th scope="col" class="text-muted">Username</th>
                    <th scope="col" class="text-muted d-none d-md-table-cell">Email</th>
                    <th scope="col" class="text-muted">Role</th>
                    <th scope="col" class="text-muted">Created</th>
                    <th scope="col" class="text-muted text-right px-2">Delete</th>
                </tr>
                </thead>
                <tbody class="">
                <?php
                foreach ($model['members'] as $key => $user) {
                    if ($user->role == 0) {
                        $userRole = 'Admin';
                    } else if ($user->role == 1) {
                        $userRole = 'Moderator';
                    } else if ($user->role == 2) {
                        $userRole = 'Author';
                    }

                    printf(' 
                    <tr class="">
                        <td class="">
                            <span class=""><a href="/profile?id=%s">%s</a></span>
                        </td>
                        <td class="d-none d-md-table-cell">
                            <span class="">%s</span>
                        </td>
                        <td class="">
                            <span class="">%s</span>
                        </td>
                        <td class="">
                            <span class="">%s</span>
                        </td>
                        <td class="text-right px-2">
                            <a href="/delete-user?id=%s" class="btn text-danger btn-lg btn-circle ml-2 loading-btns">
                            <span class="vis-hidden">delete %s</span>
                            <i class="fa-solid fa-circle-minus"></i> 
                            </a>
                        </td>
                    </tr>',
                        $user->id,
                        $user->username,
                        $user->email,
                        $userRole,
                        date("Y-m-d", strtotime($user->created_at)),
                        $user->id,
                        $user->username
                    );
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php if ($model['invitations']): ?>
        <h2 class="mt-5">Invited</h2>
        <div class="card-table">
            <div class="table-responsive">
                <table class="table no-wrap mb-0 table-dark table-hover">
                    <caption class="d-none">Users list</caption>
                    <thead class="">
                    <tr class="">
                        <th scope="col" class="text-muted d-md-table-cell">Email</th>
                        <th scope="col" class="text-muted">Role</th>
                        <th scope="col" class="text-muted text-right px-2">Revoke</th>
                    </tr>
                    </thead>
                    <tbody class="">
                    <?php
                    foreach ($model['invitations'] as $key => $user) {
                        if ($user->role == 0) {
                            $userRole = 'Admin';
                        } else if ($user->role == 1) {
                            $userRole = 'Moderator';
                        } else if ($user->role == 2) {
                            $userRole = 'Author';
                        }

                        printf(' 
                    <tr class="row-item">
                        <td class="d-md-table-cell w-50">
                            <span class="">%s</span>
                        </td>
                        <td class="d-table-cell w-auto">
                            <span class="">%s</span>
                        </td>
                        <td class="text-right px-2">
                            <a href="/revoke-invitation?id=%s" class="btn text-danger btn-lg btn-circle ml-2 loading-btns">
                                <span class="vis-hidden">revoke invitation for %s</span>
                                <i class="fa-solid fa-circle-minus"></i> 
                            </a>
                        </td>
                    </tr>',
                            $user->email,
                            $userRole,
                            $user->id,
                            $user->email
                        );
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endif; ?>
</div>