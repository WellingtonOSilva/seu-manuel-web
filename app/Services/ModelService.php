<?php

namespace App\Services;

use App\Data\BodyStyle;
use App\Data\Brand;
use App\Data\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class ModelService
{
    protected string $baseUrl;

    public function __construct()
    {
        //$this->baseUrl = config('services.vehicle_api.url');
        $this->baseUrl = 'fake.com';
    }

    /**
     * @return Brand[]
     */
    public function getAll(): array
    {
        Http::fake([
            'fake.com/models' => Http::response([
                [
                    'id' => 'model-001',
                    'name' => 'Corolla',
                    'platform' => 'TNGA',
                    'versions' => [
                        [
                            'id' => 'version-001',
                            'name' => 'Corolla XEi 2.0 Flex',
                            'engine' => '2.0L Flex',
                            'data' => 'CVT - 177cv',
                            'createdAt' => '2023-01-10T08:00:00Z',
                            'updatedAt' => '2024-01-10T08:00:00Z',
                        ],
                        [
                            'id' => 'version-002',
                            'name' => 'Corolla Altis Hybrid',
                            'engine' => '1.8L Hybrid',
                            'data' => 'CVT - 122cv',
                            'createdAt' => '2023-01-11T08:00:00Z',
                            'updatedAt' => '2024-01-11T08:00:00Z',
                        ]
                    ],
                    'brand' => [
                        'id' => 'brand-001',
                        'name' => 'Toyota',
                        'logoUrl' => 'https://example.com/logos/toyota.png',
                        'createdAt' => '2022-01-01T08:00:00Z',
                        'updatedAt' => '2023-01-01T08:00:00Z'
                    ],
                    'bodyStyle' =>  BodyStyle::SEDAN,
                    'createdAt' => '2023-02-01T08:00:00Z',
                    'updatedAt' => '2024-02-01T08:00:00Z'
                ],
                [
                    'id' => 'model-002',
                    'name' => 'HR-V',
                    'platform' => 'Global Small Platform',
                    'versions' => [
                        [
                            'id' => 'version-003',
                            'name' => 'HR-V EXL Turbo',
                            'engine' => '1.5L Turbo',
                            'data' => 'CVT - 173cv',
                            'createdAt' => '2023-03-10T08:00:00Z',
                            'updatedAt' => '2024-03-10T08:00:00Z'
                        ]
                    ],
                    'brand' => [
                        'id' => 'brand-002',
                        'name' => 'Honda',
                        'logoUrl' => 'https://example.com/logos/honda.png',
                        'createdAt' => '2022-02-01T08:00:00Z',
                        'updatedAt' => '2023-02-01T08:00:00Z'
                    ],
                    'bodyStyle' => BodyStyle::SUV,
                    'createdAt' => '2023-04-01T08:00:00Z',
                    'updatedAt' => '2024-04-01T08:00:00Z'
                ]
            ], 200),
        ]);

        Cache::delete('models:all');

        return Cache::remember('models:all', now()->addMinutes(10), function () {

            $response = Http::get("{$this->baseUrl}/models");

            $response->throw(); // dispara exception se erro

            return Model::collect($response->json());// retorna array ou collection
        });
    }

    public function find(string $id): Brand

    {
        return Cache::remember("vehicles:{$id}", now()->addMinutes(10), function () use ($id) {
            $response = Http::get("{$this->baseUrl}/vehicles/{$id}");
            $response->throw();

            return Brand::from($response->json());
        });
    }

    public function create(array $data): Brand
    {
        $response = Http::post("{$this->baseUrl}/vehicles", $data);
        $response->throw();

        return Brand::from($response->json());
    }
}
