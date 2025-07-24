<?php

namespace App\Data;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class Model extends Data
{
    public function __construct(
        public string $id,
        public string $name,
        public string $platform,
        /**
         * @var Version[] $versions
         */
        public array|Optional $versions,
        public Brand $brand,
        public BodyStyle $bodyStyle,
        public \DateTime|Optional $createdAt,
        public \DateTime|Optional $updatedAt,
    ){}
}
