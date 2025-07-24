<?php

namespace App\Data;

use Illuminate\Support\Optional;
use Spatie\LaravelData\Data;

class Vehicle extends Data
{
    public function __construct(
        public string|Optional $id,
        public string $name,
        public string $licensePlate,
        public int $year,
        public int $km,
        public bool $isNew,
        public Version $version,
        public Owner $owner,
    ){}

}
