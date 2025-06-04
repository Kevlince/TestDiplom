<?php
namespace Notification;

class Notification {
    public function __construct(
            public int $id,
            public ?int $user_id,
            public ?string $message,
            public \DateTime $sent_at,
            public ?\DateTime $read_at
    ) {}
}