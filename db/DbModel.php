<?php

declare(strict_types=1);

namespace natoxCore\db;

use natoxCore\Model;
use natoxCore\Application;

abstract class DbModel extends Model
{
    abstract public static function tableName(): string;

    abstract public function attributes(): array;

    public static function primaryKey(): string
    {
        return 'id';
    }

    public function save()
    {
        $tableName = $this->tableName();
        $attributes = $this->attributes();

        $params = array_map(fn ($attr) => ":$attr", $attributes);
        $statement = self::prepare("INSERT INTO $tableName (" . implode(",", $attributes) . ") 
                VALUES (" . implode(",", $params) . ")");
        foreach ($attributes as $attribute) {
            $statement->bindValue(":$attribute", $this->{$attribute});
        }
        $statement->execute();
        return true;
    }

    public static function findOne($where)
    {
        $tableName = static::tableName();
        $attributes = array_keys($where);
        $sql = implode("AND", array_map(fn ($attr) => "$attr = :$attr", $attributes));
        $statement = self::prepare("SELECT * FROM $tableName WHERE $sql");
        foreach ($where as $key => $item) {
            $statement->bindValue(":$key", $item);
        }
        $statement->execute();
        return $statement->fetchObject(static::class);
    }

    public static function prepare($sql): \PDOStatement
    {
        return Application::$app->db->pdo->prepare($sql);
    }

    // =============== MY QUERY FORMAT =====================

    public function all(): array
    {
        $tableName = $this->tableName();

        return $this->query("SELECT * FROM {$tableName} ORDER BY created_at DESC");
    }


    /**
     * FindById function
     *
     *This Function is used to select all data based on ID;
     *set fetchMode to be able to use class as return
     * @param integer $id
     * @return Model
     */
    public function findById(int $id): Model
    {
        $tableName = $this->tableName();

        return $this->query("SELECT * FROM {$tableName} WHERE id = :id", [':id' => $id], true);
    }

    public function create(array $data, ?array $relations = null)
    {
        $tableName = $this->tableName();

        $firstParenthesis = "";
        $secondParenthesis = "";
        $i = 1;

        foreach ($data as $key => $value) {
            $comma = $i === count($data) ? "" : ", ";
            $firstParenthesis .= "{$key}{$comma}";
            $secondParenthesis .= ":{$key}{$comma}";
            $i++;
        }

        return $this->query("INSERT INTO {$tableName} ($firstParenthesis)
        VALUES($secondParenthesis)", $data);
    }

    public function update(int $id, array $data, ?array $relations = null)
    {
        $tableName = $this->tableName();
        $sqlRequestPart = "";
        $i = 1;

        foreach ($data as $key => $value) {
            $comma = $i === count($data) ? "" : ', ';
            $sqlRequestPart .= "{$key} = :{$key}{$comma}";
            $i++;
        }

        $data['id'] = $id;

        return $this->query("UPDATE {$tableName} SET {$sqlRequestPart} WHERE id = :id", $data);
    }

    public function query(string $sql, array $param = null, bool $single = null)
    {
        $method = is_null($param) ? 'query' : 'prepare';

        if (
            strpos($sql, 'DELETE') === 0
            || strpos($sql, 'UPDATE') === 0
            || strpos($sql, 'INSERT') === 0
        ) {

            $stmt = Application::$app->db->pdo->$method($sql);
            return $stmt->execute($param);
        }

        $fetch = is_null($single) ? 'fetchAll' : 'fetch';

        $stmt = Application::$app->db->pdo->$method($sql);
        if ($method === 'query') {
            return $stmt->$fetch();
        } else {
            $stmt->execute($param);
            return $stmt->$fetch();
        }
    }
}