<?php
/**
 * BY: Nordin Suleimani <nordin.suleimani@email.com>
 * DATE: 8/15/2022
 * TIME: 11:20 PM
 * COURSE: Webbprogrammering DT058G
 * SUPERVISOR: Mikael Hasselmalm
 */

namespace app\core;

use app\models\GetUsers;
use app\models\Invite;
use app\models\RecoverPassword;
use PDO;
use PDOException;

abstract class DbModel extends Model
{
    abstract public function tableName(): string;

    abstract public function attributes(): array;

    abstract public static function primaryKey(): string;

    public function insertNew(): bool
    {
        $tableName = $this->tableName();
        $attributes = $this->attributes();

        $params = array_map(fn($a) => ":$a", $attributes);
        $statement = self::prepare("INSERT INTO $tableName (" . implode(", ", $attributes) . ") 
                VALUES(" . implode(', ', $params) . ")");
        foreach ($attributes as $attribute) {
            $statement->bindValue(":$attribute", $this->{$attribute});
        }
        try {
            $statement->execute();
            return true;
        }catch (PDOException $e) {
           echo $e->getMessage();
           return false;
        }
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

    public static function findUser($where, $classType)
    {
        $tableName = $classType->tableName();
        $attributes = array_keys($where);
        $sql = implode("AND ", array_map(fn($attr) => "$attr = :$attr", $attributes));
        $statement = self::prepare("SELECT * FROM $tableName WHERE $sql");
        foreach ($where as $key => $item) {
            $statement->bindValue(":$key", $item);
        }

        $statement->execute();
        return $statement->fetchObject(static::class) ?? false;
    }

    public static function delete($where, $classType)
    {
        $tableName = $classType->tableName();
        $attributes = array_keys($where);
        $sql = implode("AND ", array_map(fn($attr) => "$attr = :$attr", $attributes));
        $statement = self::prepare("DELETE FROM $tableName WHERE $sql");
        foreach ($where as $key => $item) {
            $statement->bindValue(":$key", $item);
        }

        return $statement->execute();
    }
    public static function getAllRows($classType)
    {
        $tableName = $classType->tableName();
        $statement = self::prepare("SELECT * FROM $tableName");

        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_OBJ);
    }


    public static function prepare($sql)
    {
        return Application::$app->db->pdo->prepare($sql);
    }


}