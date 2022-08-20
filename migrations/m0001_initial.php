<?php

use app\core\Application;

/**
 * Created by PhpStorm
 * USER: Nordin Suleimani <nordin.suleimani@email.com>
 * DATE: 8/15/2022
 * TIME: 11:16 PM
 */

class m0001_initial
{
    public function up()
    {
        $db = Application::$app->db;
        $SQL = "CREATE TABLE users (
                id INT AUTO_INCREMENT PRIMARY KEY,
                email VARCHAR(100) NOT NULL UNIQUE KEY,
                username VARCHAR(30) NOT NULL,
                password VARCHAR(250) NOT NULL,
                bio VARCHAR(512) NOT NULL,
                role TINYINT NOT NULL,
                avatar VARCHAR(255) NOT NULL,
                status TINYINT NOT NULL DEFAULT 0,
                verified TINYINT NOT NULL,
                recovery_token VARCHAR(255) NOT NULL,
                token_expiration TIMESTAMP DEFAULT CURRENT_TIMESTAMP, 
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
        $db->pdo->exec($SQL);

        $SQL = "CREATE TABLE invitations (
                id INT AUTO_INCREMENT PRIMARY KEY,
                email VARCHAR(100) NOT NULL UNIQUE KEY,
                role TINYINT NOT NULL,
                invitecode VARCHAR(255) NOT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
        $db->pdo->exec($SQL);
    }
    public function down()
    {
        $db = Application::$app->db;
        $SQL = "DROP TABLE users;";
        $db->pdo->exec($SQL);

        $SQL = "DROP TABLE invitations;";
        $db->pdo->exec($SQL);
    }
}