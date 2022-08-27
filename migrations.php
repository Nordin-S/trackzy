<?php
/**
 * BY: Nordin Suleimani <nordin.suleimani@gmail.com>
 * DATE: 8/15/2022
 * TIME: 11:20 PM
 * COURSE: Webbprogrammering DT058G
 * SUPERVISOR: Mikael Hasselmalm
 * DESCRIPTION: Used to migrate files manually in CLI, run "php migrations.php" from project root
 */

use app\core\Application;

// set project root path
$_ENV['ROOT_DIR'] = __DIR__ . '/';

require_once __DIR__ . '/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$app = new Application();

$app->db->applyMigrations();