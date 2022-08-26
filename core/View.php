<?php
/**
 * BY: Nordin Suleimani <nordin.suleimani@email.com>
 * DATE: 8/15/2022
 * TIME: 11:20 PM
 * COURSE: Webbprogrammering DT058G
 * SUPERVISOR: Mikael Hasselmalm
 */

namespace app\core;

class View
{
    public string $title = '';
    public string $email = '';
    public string $recovery_token = '';

    protected function layoutContent($params = [])
    {
        $layout = Application::$app->layout;
        if(Application::$app->controller){
            $layout = Application::$app->controller->layout;
        }
        ob_start();
        foreach ($params as $key => $value) {
            $$key = $value;
        }
        include_once $_ENV['ROOT_DIR'] . "views/layouts/$layout.php";
        return ob_get_clean();
    }
    protected function renderViewOnly($view, $params = [])
    {
        ob_start();
        foreach ($params as $key => $value) {
            $$key = $value;
        }
        include_once $_ENV['ROOT_DIR'] . "views/$view.php";
        return ob_get_clean();
    }
    public function renderView($view, $params = [])
    {
        $viewContent = $this->renderViewOnly($view, $params);
        $layoutContent = $this->layoutContent($params);
        return str_replace('{{content}}', $viewContent, $layoutContent);
    }
}