<?php

namespace App\Data;

use Spatie\LaravelData\Data;

class Owner extends Data
{
    public  function __construct(
        public string $id,
    ) {}
}
