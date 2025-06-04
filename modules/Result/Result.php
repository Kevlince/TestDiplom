<?php
namespace App\Result;

class Result {
    public function __construct(
            public int $id,
            public ?int $student_id,
            public ?string $part_number,
            public string $server_filename,
            public string $filename,
            public \DateTime $uploaded_at
    ) {}
}