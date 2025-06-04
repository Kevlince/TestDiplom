<?php

namespace App\Core;

class Request {
    public static function method(): string {
        return $_SERVER['REQUEST_METHOD'];
    }

    public static function uri(): string {
        return $_SERVER['REQUEST_URI'];
    }

    public static function input(string $key, $default = null) {
        return $_REQUEST[$key] ?? $default;
    }

    public static function json(): array {
        return json_decode(file_get_contents('php://input'), true) ?? [];
    }
}