<?php

use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
});

test('index page shows vehicles list from service', function () {
    Http::fake([
        'fake.com/vehicles*' => Http::response([
            [
                'id' => 'veh-001',
                'name' => 'Meu Corolla',
                'licensePlate' => 'ABC1D23',
                'year' => 2022,
                'km' => 35000,
                'isNew' => false,
                'owner' => ['id' => $this->user->id],
                'version' => [
                    'id' => 'ver-001',
                    'name' => 'Corolla XEi',
                    'engine' => '2.0',
                    'model' => [
                        'id' => 'model-001',
                        'name' => 'Corolla',
                        'bodyStyle' => 'SEDAN',
                        'platform' => 'TNGA',
                        'brand' => [
                            'id' => 'brand-002',
                            'name' => 'Honda',
                            'logoUrl' => 'https://example.com/logos/honda.png',
                            'createdAt' => '2022-02-01T08:00:00Z',
                            'updatedAt' => '2023-02-01T08:00:00Z'
                        ],
                    ]
                ]
            ]
        ], 200),
    ]);

    $response = $this->get('/vehicles');
    $response->assertStatus(200);

    $response->assertInertia(fn ($page) =>
    $page->component('vehicles')
        ->has('vehicles', 1)
        ->where('vehicles.0.id', 'veh-001')
    );
});

test('create vehicle calls service and redirects', function () {
    Http::fake([
        'fake.com/vehicles' => Http::response(['id' => 'veh-999'], 200),
    ]);

    $response = $this->post('/vehicles', [
        'name' => 'Fake Car',
        'licensePlate' => 'ZZZ9999',
        'year' => 2024,
        'km' => 10,
        'isNew' => true,
        'ownerId' => $this->user->id,
        'brand' => 'brand-999',
        'model' => 'model-999',
        'version' => 'ver-999',
    ]);

    $response->assertStatus(302);
    $response->assertRedirect(route('vehicles.show', 'veh-999'));
});

test('vehicle detail page returns correct vehicle and events', function () {
    Http::fake([
        'fake.com/vehicles/veh-001' => Http::response([
            'id' => 'veh-001',
            'name' => 'Meu Corolla',
            'licensePlate' => 'ABC1D23',
            'year' => 2022,
            'km' => 35000,
            'isNew' => false,
            'owner' => ['id' => $this->user->id],
            'version' => [
                'id' => 'ver-001',
                'name' => 'Corolla XEi',
                'engine' => '2.0',
                'model' => [
                    'id' => 'model-001',
                    'name' => 'Corolla',
                    'bodyStyle' => 'SEDAN',
                    'platform' => 'TNGA',
                    'brand' => [
                        'id' => 'brand-002',
                        'name' => 'Honda',
                        'logoUrl' => 'https://example.com/logos/honda.png',
                        'createdAt' => '2022-02-01T08:00:00Z',
                        'updatedAt' => '2023-02-01T08:00:00Z'
                    ],
                ]
            ]
        ], 200),
        'fake.com/events?vehicleId=veh-001' => Http::response([
            [
                'id' => 'event-001',
                'event' => 'MAINTENANCE_PREVENTIVE',
                'date' => now()->toIso8601String(),
                'km' => 20000,
                'notes' => 'Troca de óleo'
            ]
        ], 200),
    ]);

    $response = $this->get('/vehicles/veh-001');
    $response->assertStatus(200);

    $response->assertInertia(fn ($page) =>
    $page->component('vehicles/detail')
        ->where('vehicle.id', 'veh-001')
        ->has('events', 1)
        ->where('events.0.id', 'event-001')
    );
});
