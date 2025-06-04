<?php
namespace Student;

class Student {
    public function __construct(
            public int $id,
            public ?string $group_name,
            public ?int $rating
    ) {}
}