<?php
namespace Meeting;

use DateTime;

class Meeting {
    public function __construct(
            public int       $id,
            public ?int      $student_id,
            public ?int      $teacher_id,
            public ?DateTime $scheduled_at,
            public ?string   $location,
            public ?string   $reason,
            public bool      $is_happened = false
    ) {}
}