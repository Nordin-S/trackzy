<?php
/**
 * Created by PhpStorm
 * USER: Nordin Suleimani <nordin.suleimani@email.com>
 * DATE: 8/15/2022
 * TIME: 11:20 PM
 */

namespace app\core;

use PDOException;

class Database
{
    public \PDO $pdo;

    public function __construct(array $config)
    {
        $host = $config['host'] ?? '';
        $user = $config['user'] ?? '';
        $password = $config['password'] ?? '';
        $this->pdo = new \PDO($host, $user, $password);
        $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
//        $this->pdo->setAttribute(\PDO::MYSQL_ATTR_SSL_CA, dirname(__DIR__) . 'DigiCertGlobalRootCA.crt.pem');
//        $this->pdo->setAttribute(\PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT, false);
//        $this->applyMigrations();
    }

    public function applyMigrations()
    {
        $this->createMigrationsTable();
        $appliedMigrations = $this->getAppliedMigrations();

        $files = scandir(Application::$ROOT_DIR . '/migrations');
        $migrationsToApply = array_diff($files, $appliedMigrations);
        foreach ($migrationsToApply as $migration) {
            if ($migration === '.' || $migration === '..') {
                continue;
            }
            require_once Application::$ROOT_DIR . '/migrations/' . $migration;
            $className = pathinfo($migration, PATHINFO_FILENAME);
            $instance = new $className();

            $this->log("Applying $migration" . PHP_EOL);
            $instance->up();
            $this->log("Applied $migration" . PHP_EOL);
            $newMigrations[] = $migration;
        }
        if (!empty($newMigrations)) {
            $this->saveMigrations($newMigrations);
        } else {
            $this->log("All available migrations are applyied");
        }
    }

    public function createMigrationsTable()
    {
        $this->pdo->exec("CREATE TABLE IF NOT EXISTS migrations (
            id INT AUTO_INCREMENT PRIMARY KEY,
            migration VARCHAR(255),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP 
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
    }

    public function getAppliedMigrations()
    {
        try {
            $statement = $this->pdo->prepare("SELECT migration FROM migrations");
            $statement->execute();
        } catch (PDOException $e) {
            echo $e->getMessage();
            return null;
        }

        return $statement->fetchAll(\PDO::FETCH_COLUMN) ?? null;
    }

    public function saveMigrations(array $newMigrations)
    {
        $str = implode(',', array_map(fn($m) => "('$m')", $newMigrations));
        $statement = $this->pdo->prepare("INSERT INTO migrations (migration) VALUES $str");

        $statement->execute();
    }


    public function getAllUsersEmail()
    {
        try {
            $statement = $this->pdo->prepare("SELECT email FROM users");
            $statement->execute();
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
        return $statement->fetchAll(\PDO::FETCH_COLUMN);
    }


    public function prepare($sql)
    {
        return $this->pdo->prepare($sql);
    }


    public function log($message)
    {
        echo '[' . date('Y-m-d H:i:s') . '] - ' . $message . PHP_EOL;
    }
}