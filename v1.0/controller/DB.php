<?php

class DB
{
    // For later scalability
    private static $writeDBConnection; // use for write database
    private static $readDBConnection; // ues for read database (usually multiple slaves if needed)

    public static function connectWriteDB()
    {
        if (self::$writeDBConnection === null) { // Singleton pattern for creating only single write connection
            self::$writeDBConnection = new PDO('mysql:host=localhost;dbname=bmsdev;charset=utf8', 'root', '');
            self::$writeDBConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // set the error mode of PDO
            self::$writeDBConnection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false); // mysql already handles prepare statements so no need to emulate it
        }
        return self::$writeDBConnection;
    }

    public static function connectReadDB()
    {
        if (self::$readDBConnection === null) { // Singleton pattern for creating only single write connection
            self::$readDBConnection = new PDO('mysql:host=localhost;dbname=bmsdev;charset=utf8', 'root', '');
            self::$readDBConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // set the error mode of PDO
            self::$readDBConnection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false); // mysql already handles prepare statements so no need to emulate it
        }
        return self::$readDBConnection;
    }
}