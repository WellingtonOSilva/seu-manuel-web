<?php

namespace App\Data;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class Brand extends Data
{
    public function __construct(
        public string $id,
        public string $name,
        public string|Optional $logoUrl,
        public \DateTime|Optional $createdAt,
        public \DateTime|Optional $updatedAt,
    ){}
}
