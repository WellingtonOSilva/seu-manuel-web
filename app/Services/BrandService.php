<?php

namespace App\Services;

use App\Data\Brand;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class BrandService
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
            'fake.com/brands' => Http::response([
                [
                    'id' => 'brand-001',
                    'name' => 'Toyota',
                    'createdAt' => '2023-06-01T12:00:00Z',
                    'updatedAt' => '2024-05-01T10:30:00Z',
                ],
                [
                    'id' => 'brand-002',
                    'name' => 'Honda',
                    'createdAt' => '2023-06-01T12:00:00Z',
                    'updatedAt' => '2024-05-01T10:30:00Z',
                ],
                // ...
            ], 200),
        ]);

        return Cache::remember('brands:all', now()->addMinutes(10), function () {

            $response = Http::get("{$this->baseUrl}/brands");

            $response->throw(); // dispara exception se erro

            return Brand::collect($response->json());// retorna array ou collection
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
