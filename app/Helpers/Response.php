<?php
declare(strict_types=1);

namespace App\Helpers;

/**
 * Simple JSON response helper.
 */
class Response
{
    /**
     * Send a JSON response and exit.
     *
     * @param mixed $data Data to encode as JSON.
     * @param int   $status HTTP status code.
     * @return void
     */
    public static function json($data, int $status = 200): void
    {
        http_response_code($status);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        exit;
    }

    /**
     * Send an error JSON response and exit.
     *
     * @param string $message Error message.
     * @param int    $status HTTP status code.
     * @return void
     */
    public static function error(string $message, int $status = 400): void
    {
        http_response_code($status);
        echo json_encode(['error' => $message]);
        throw new \Exception($message, $status);
    }
}
