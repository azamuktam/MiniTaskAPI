<?php
declare(strict_types=1);

namespace App\Core;

/**
 * Database
 *
 * Singleton class to handle the PDO database connection.
 * Prevents multiple connections from being opened during a single request.
 */
class Database
{
    /** @var \PDO|null */
    private static ?\PDO $instance = null;

    /**
     * Get the active database connection.
     *
     * Initializes the connection if it does not exist yet.
     *
     * @return \PDO
     */
    public static function getConnection(): \PDO
    {
        if (self::$instance === null) {
            $host = getenv('DB_HOST');
            $db   = getenv('DB_NAME');
            $user = getenv('DB_USER');
            $pass = getenv('DB_PASS');
            $charset = 'utf8mb4';

            $dsn = "mysql:host={$host};dbname={$db};charset={$charset}";

            self::$instance = new \PDO($dsn, $user, $pass, [
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
                \PDO::ATTR_EMULATE_PREPARES => false,
            ]);
        }
        return self::$instance;
    }
}