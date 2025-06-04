<?php

namespace App\Core;
use JetBrains\PhpStorm\NoReturn;

class Response {
    public static function json(array $data, int $status = 200): void {
        http_response_code($status);
        header('Content-Type: application/json');
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    public static function error(string $message, int $status = 400): void {
        self::json(['error' => $message], $status);
    }

    #[NoReturn] public static function redirect(string $url): void {
        header("Location: $url");
        exit;
    }
}