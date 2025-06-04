<?php
namespace App\Core\Exceptions;

use Exception;

class ValidationException extends Exception {
    public $errors;

    public function __construct(array $errors) {
        $this->errors = $errors;
        parent::__construct('Validation failed');
    }
}