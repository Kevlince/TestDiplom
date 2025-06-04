<?php

namespace App\User;

class User {
    public function __construct(
            public int    $id,
            public string $name,
            public string $password,
            public string $role
    ) {
    }

}