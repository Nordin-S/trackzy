<?php
/** @var $model \app\models\GetUsers */
/** @var $title \app\core\View */
$this->title = $title;
?>

<div class="col-sm-12 col-md-10 m-auto p-0 pt-4">
    <h2>Invite new user</h2>
    <form action="/invite" method="post">
        <div class="d-flex flex-row px-2">
            <input type="text" class="mr-2 w-50 p-2" value="" name="email" placeholder="Invite email">
            <select class="form-control mr-2 w-25 p-2" id="roles-select" name="role">
                <option value="0">Admin</option>
                <option value="1">Moderator</option>
                <option value="2">User</option>
            </select>
            <button type="submit" class="btn ml-auto w-auto btn-primary rounded-lg float-right">Invite</button>
        </div>
    </form>
    <hr>
    <h2>Members</h2>
    <div class="card-table">
        <div class="table-responsive">
            <table class="table no-wrap mb-0 table-dark table-hover">
                <caption class="d-none">Users list</caption>
                <thead class="">
                <tr class="">
                    <th scope="col" class="text-muted">Username</th>
                    <th scope="col" class="text-muted d-none d-md-table-cell">Email</th>
                    <th scope="col" class="text-muted">Role</th>
                    <th scope="col" class="text-muted">Created</th>
                    <th scope="col" class="text-muted">Delete</th>
                </tr>
                </thead>
                <tbody class="">
                <?php
                foreach ($model as $key => $user) {
                    if ($user->role == 0) {
                        $userRole = 'Admin';
                    } else if ($user->role == 1) {
                        $userRole = 'Moderator';
                    } else if ($user->role == 2) {
                        $userRole = 'Author';
                    }

                    printf(' 
                    <tr class="row-item">
                        <td class="w-25 d-md-table-cell">
                            <span class=""><a href="/profile?id=%s">%s</a></span>
                        </td>
                        <td class="d-none d-md-table-cell w-25">
                            <span class="">%s</span>
                        </td>
                        <td class="d-table-cell w-25">
                            <span class="">%s</span>
                        </td>
                        <td class="">
                            <span class="">%s</span>
                        </td>
                        <td class="w-auto">
                            <a href="/delete-user?id=%s" class="btn text-danger btn-lg btn-circle ml-2"><i
                                        class="fa-solid fa-circle-minus"></i> </a>
                        </td>
                    </tr>',
                        $user->id,
                        $user->username,
                        $user->email,
                        $userRole,
                        date("Y-m-d", strtotime($user->created_at)),
                        $user->id,

                    );
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
    <!--            <h2 class="mt-5">Invited</h2>-->
    <!--                <div class="card-table">-->
    <!--                    <div class="table-responsive">-->
    <!--                        <table class="table no-wrap mb-0 table-dark table-hover">-->
    <!--                            <caption class="d-none">Invited list</caption>-->
    <!--                            <thead class="">-->
    <!--                            <tr class="">-->
    <!--                                <th scope="col" class="text-muted">Email</th>-->
    <!--                                <th scope="col" class="text-muted">Role</th>-->
    <!--                                <th scope="col" class="text-muted">Revoke</th>-->
    <!--                            </tr>-->
    <!--                            </thead>-->
    <!--                            <tbody class="">-->
    <!--                            <tr class="row-item">-->
    <!--                                <td class="w-75">-->
    <!--                                    <span class="">daniel@website.com</span>-->
    <!--                                </td>-->
    <!--                                <td class="w-25">-->
    <!--                                    <select class="form-control category-select" id="roles-select">-->
    <!--                                        <option value="admin">Admin</option>-->
    <!--                                        <option value="moderator">Moderator</option>-->
    <!--                                        <option value="user">User</option>-->
    <!--                                    </select>-->
    <!--                                </td>-->
    <!--                                <td class="w-auto">-->
    <!--                                    <a href="/revoke-invitation?what=invitation&id=1" class="btn text-danger btn-lg btn-circle ml-2"><i-->
    <!--                                                class="fa-solid fa-circle-minus"></i> </a>-->
    <!--                                </td>-->
    <!--                            </tr>-->
    <!--                            </tbody>-->
    <!--                        </table>-->
    <!--                    </div>-->
    <!--                </div>-->
</div>