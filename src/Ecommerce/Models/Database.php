<?php 

declare(strict_types = 1);

namespace Ecommerce\Models;

use PDO;
use PDOStatement;

class Database
{
    private string $host = "localhost";

    private string $dbname = "projectecom";

    private string $username = "homestead";

    private string $password = "secret";

    private static PDO $db;

    private string $table;

    private string $class;

    /**
     * Database constructor.
     * @param string $class the class with namespace: App\\Models\\User.
     * @param string $table table name.
     */
    public function __construct(string $class, string $table)
    {
        if (!isset(self::$db))
        {
            $dsn = sprintf('mysql:host=%s;dbname=%s', $this->host, $this->dbname);
            self::$db = new PDO($dsn, $this->username, $this->password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_EMULATE_PREPARES => false
            ]);
        }
        $this->class = $class;
        $this->table = $table;
    }

    private function prepare(string $query) : PDOStatement
    {
        return self::$db->prepare($query);
    }

    private function execute(PDOStatement $statement, array $params): bool
    {
        //Select id from user where id = :id
        //[:id => 1, :name =>
        return $statement->execute($params);
    }

    private function populate(array $data, string $prefix, string $style): array
    {
        if (empty($data)) {
            return [$data, []];
        }
        $keys = array_keys($data);
        $values = array_values($data);
        $temps = preg_filter('/^/', "$prefix", $keys);
        $content = [];
        foreach ($keys as $num => $key)
        {
            $content[] = sprintf($style, $key, $temps[$num]);
        }
        return [$content, array_combine($temps, $values)];
    }

    /**
     * @param array $keys array columns only.
     * @param array $wheres where key value pair
     * @param string $operator
     * @return array
     */
    public function readDB(array $keys = ['*'], array $wheres = [], string $operator = "AND"): array
    {
        $operator = trim($operator);
        $query = implode(" ", ["SELECT", "%s FROM", "$this->table %s"]);
        list($content, $data) = $this->populate($wheres, ':', "%s = %s");
        $query = sprintf($query, implode(', ', $keys), implode(" $operator ", $content));
        $statement = $this->prepare($query);
        if (!$this->execute($statement, $data)) {
            return [];
        }
        return $statement->fetchAll(PDO::FETCH_CLASS, $this->class);
    }

    public function writeDB(array $params)
    {
        $statement = $this->prepare("");
    }
}



