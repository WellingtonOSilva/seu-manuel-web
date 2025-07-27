<?php

namespace App\Data;

use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Attributes\WithTransformer;
use Spatie\LaravelData\Casts\DateTimeInterfaceCast;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;
use Spatie\LaravelData\Transformers\DateTimeInterfaceTransformer;

class Event extends Data
{
    public function __construct(
        public string $id,
        public EventType $type,
        public string $vehicleId,
        public string $vehicleName,
        public int $km,
        public string $occurrenceDate,
        public string $description,
    ){}
}
