<?php
/**
 * Created by PhpStorm
 * USER: Nordin Suleimani <nordin.suleimani@email.com>
 * DATE: 8/17/2022
 * TIME: 1:13 PM
 */

namespace app\core\middlewares;

use app\core\Application;
use app\core\exceptions\ForbiddenException;

class AuthMiddleware extends BaseMiddleware
{
    public array $guestActions = [];
    public array $userActions = [];
    public array $moderatorActions = [];

    /**
     * @param array $guestActions
     */
    public function __construct(array $guestActions = [], array $userActions = [], array $moderatorActions = [])
    {
        $this->guestActions = $guestActions;
        $this->userActions = $userActions;
        $this->moderatorActions = $moderatorActions;
    }

    public function execute()
    {
        if (Application::isGuest()) {
            if (in_array(Application::$app->controller->action, $this->guestActions)) {
                throw new ForbiddenException;
            }
        } else {
            if (Application::$app->user->getRole() === 1) {
                if (in_array(Application::$app->controller->action, $this->userActions)) {
                    throw new ForbiddenException;
                }
            }
            if (Application::$app->user->getRole() === 2) {
                if (in_array(Application::$app->controller->action, $this->moderatorActions)) {
                    throw new ForbiddenException;
                }
            }
        }
    }
}