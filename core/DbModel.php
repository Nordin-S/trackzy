<?php
/**
 * Created by PhpStorm
 * USER: Nordin Suleimani <nordin.suleimani@email.com>
 * DATE: 8/16/2022
 * TIME: 3:11 AM
 */

namespace app\core;

use app\models\GetUsers;
use app\models\Invite;
use app\models\RecoverPassword;
use PDO;

abstract class DbModel extends Model
{
    abstract public function tableName(): string;

    abstract public function attributes(): array;

    abstract public static function primaryKey(): string;

    public function newUser(): bool
    {
        $tableName = $this->tableName();
        $attributes = $this->attributes();

        $params = array_map(fn($a) => ":$a", $attributes);
        $statement = self::prepare("INSERT INTO $tableName (" . implode(", ", $attributes) . ") 
                VALUES(" . implode(', ', $params) . ")");
        foreach ($attributes as $attribute) {
            $statement->bindValue(":$attribute", $this->{$attribute});
        }
        $statement->execute();
        return true;
    }

    public function updateAttributesWhere($where): bool
    {
        $tableName = $this->tableName();
        $attributes = $this->attributes();
        $setParams = array_map(fn($a) => "$a = :$a", $attributes);
        $statement = self::prepare("UPDATE $tableName SET " . implode(", ", $setParams) . " WHERE $where = :were");
        foreach ($attributes as $attribute) {
            $statement->bindValue(":$attribute", $this->{$attribute});
        }
        $statement->bindValue(":were", $this->{$where});

        try {
            $statement->execute();
        } catch (\PDOException $e) {
            echo $e->getCode() . ' - ' . $e->getMessage();
        }
        return true;
    }

    public static function findUser($where)
    {
        $tableName = (new RecoverPassword)->tableName();
        $attributes = array_keys($where);
        $sql = implode("AND ", array_map(fn($attr) => "$attr = :$attr", $attributes));
        $statement = self::prepare("SELECT * FROM $tableName WHERE $sql");
        foreach ($where as $key => $item) {
            $statement->bindValue(":$key", $item);
        }

        $statement->execute();
        return $statement->fetchObject(static::class);
    }

    public static function getAllUsers()
    {
        $tableName = (new GetUsers)->tableName();
        $statement = self::prepare("SELECT * FROM $tableName");

        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_OBJ);
    }

    public function invite()
    {
        $tableName = (new Invite)->tableName();

        $statement = self::prepare("INSERT INTO $tableName (" . implode(", ", $attributes) . ") 
                VALUES(" . implode(', ', $params) . ")");
        foreach ($attributes as $attribute) {
            $statement->bindValue(":$attribute", $this->{$attribute});
        }


        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_OBJ);
    }

    public static function prepare($sql)
    {
        return Application::$app->db->pdo->prepare($sql);
    }



}