<?php 

declare(strict_types = 1);

class Database
{
    private static $host = "localhost";
    private static $dbname = "projectecom";
    private static $username = "homestead";
    private static $password = "secret";
    private static $readConnection;
    private static $writeConnection;
    
    /**
     * readDB
     * Connection to read database
     * 
     */
    public static function readDB()
    {
        if(self::$readConnection === null) {
            $dsn = 'mysql:host=' . self::$host . ';dbname=' . self::$dbname;
            self::$readConnection = new PDO($dsn, self::$username, self::$password);
            self::$readConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::$readConnection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        }
        return self::$readConnection;
    }    
    /**
     * writeDB
     * Connection to write database
     * 
     */
    public static function writeDB()
    {
        if(self::$writeConnection === null) {
            $dsn = 'mysql:host=' . self::$host . ';dbname=' . self::$dbname;
            self::$writeConnection = new PDO($dsn, self::$username, self::$password);
            self::$writeConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::$writeConnection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        }
        return self::$writeConnection;
    }

}



