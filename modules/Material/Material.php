<?php
namespace App\Material;

class Material {
    public function __construct(
            public int $id,
            public string $server_filename,
            public string $filename,
            public \DateTime $uploaded_at,
            public ?int $uploaded_by,
            public ?int $topic_id
    ) {}
}