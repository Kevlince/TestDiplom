<?php

namespace Topic;

class Topic {
    public function __construct(
            public int $id,
            public string $title,
            public string $description,
            public int $teacher_id,
            public int $is_active,
    ){}
}