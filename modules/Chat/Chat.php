<?php
namespace App\Chat;

use DateTime;

class Chat {
    public function __construct(
            public int $id,
            public ?string $title,
            public DateTime $created_at
    ) {}
}