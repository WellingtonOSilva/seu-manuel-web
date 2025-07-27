<?php

namespace App\Services;

use App\Data\BodyStyle;
use App\Data\Brand;
use App\Data\Event;
use App\Data\EventType;
use App\Data\Id;
use App\Data\Vehicle;
use App\Http\Requests\CreateVehicleRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class EventService
{
    protected string $baseUrl;

    public function __construct()
    {
        //$this->baseUrl = config('services.vehicle_api.url');
        $this->baseUrl = 'fake.com';
        $this->events = [
            [
                'id' => 'eve-2',
                'type' => EventType::MAINTENANCE_CORRECTIVE,
                'km' => 5000,
                'vehicleId' => 'a',
                'vehicleName' => 'aaaa',
                'description' => '',
                'occurrenceDate' => Carbon::now()->format('Y-m-d'),
            ],
        ];
    }

    /**
     * @return Vehicle[]
     */
    public function getAll(): array
    {
        Http::fake([
            'fake.com/events*' => Http::response($this->events, 200),
        ]);

        $ownerId = auth()->id();
        $response = Http::get("{$this->baseUrl}/events", [ 'ownerId' => $ownerId  ]);
        $response->throw(); // dispara exception se erro

        return Event::collect($response->json());// retorna array ou collection
    }

    public function listAllByVehicleId(string $id): array
    {
        Http::fake([
            'fake.com/events*' => Http::response($this->events, 200),
        ]);

        $ownerId = auth()->id();
        $response = Http::get("{$this->baseUrl}/events", [ 'ownerId' => $ownerId  ]);
        $response->throw(); // dispara exception se erro

        return Event::collect($response->json());// retorna array ou collection
    }

    public function create(CreateVehicleRequest $request): Id
    {

        Http::fake([
            'fake.com/vehicles' => Http::response([
                'id' => 'veh-010',
            ], 200),
        ]);

        $vehicle = Vehicle::from([
            'id' => '',
            'name' => $request->name ?? 'My Vehicle',
            'licensePlate' => $request->licensePlate,
            'year' => $request->year,
            'km' => $request->km,
            'isNew' => $request->isNew,
            'owner' => [
                'id'  => $request->ownerId,
            ],
            'version' => [
                'id' => $request->version,
            ]
        ]);

        $response = Http::post("{$this->baseUrl}/vehicles", $vehicle);
        $response->throw();

        return Id::from(['value' => $response->json('id')]);
    }
}
