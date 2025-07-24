<?php

namespace App\Data;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class Version extends Data
{
    public function __construct(
        public string|Optional $id,
        public string|Optional $name,
        public string|Optional $engine,
        public string|Optional $data,
        public Model|Optional $model,
        public \DateTime|Optional $createdAt,
        public \DateTime|Optional $updatedAt,
    ){}
}
