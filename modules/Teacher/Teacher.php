<?php

namespace Teacher;

class Teacher {
    public function __construct(
            public int     $id,
            public ?string $department,
            public ?string $position
    ) {
    }

}