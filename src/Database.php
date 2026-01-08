<?php
/**
 * Database Connection Class (Singleton Pattern)
 */
class Database 
{
    private static ?PDO $instance = null;

    /**
     * Get the PDO database connection
     * 
     * @return PDO
     */
    public static function getConnection(): PDO
    {
        if (self::$instance === null) {
            $host = 'db';
            $db   = 'my_database';
            $user = 'user';
            $pass = 'password';
            $charset = 'utf8mb4';

            $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ];

            try {
                self::$instance = new PDO($dsn, $user, $pass, $options);
            } catch (PDOException $e) {
                // In a production app, don't leak the error message
                die("Database connection failed: " . $e->getMessage());
            }
        }

        return self::$instance;
    }
}
