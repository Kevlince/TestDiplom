<?php
namespace Preference;

class Preference {
    public function __construct(
            public int $student_id,
            public int $topic_id,
            public ?int $priority
    ) {}
}