<?php

namespace App\Data;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class Id extends Data
{
    public function __construct(
        public string $value,
    ){}
}
