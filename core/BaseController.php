<?php
namespace App\Core;

abstract class BaseController {
    protected function success($data = null, int $status = 200): array {
        return [
                'success' => true,
                'data' => $data,
                'status' => $status
        ];
    }

    protected function error(string $message, int $status = 400): array {
        return [
                'success' => false,
                'error' => $message,
                'status' => $status
        ];
    }
}