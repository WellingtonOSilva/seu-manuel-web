<?php

namespace App\Services;

use App\Data\BodyStyle;
use App\Data\Id;
use App\Data\Vehicle;
use App\Http\Requests\CreateVehicleRequest;
use Illuminate\Support\Facades\Http;

class VehicleService
{
    protected string $baseUrl;

    public function __construct()
    {
        //$this->baseUrl = config('services.vehicle_api.url');
        $this->baseUrl = 'fake.com';
        $this->vehicles = [
            [
                'id' => 'veh-001',
                'name' => 'Meu Corolla',
                'licensePlate' => 'ABC1D23',
                'year' => 2022,
                'km' => 35000,
                'owner' => [
                    'id' => 'owner-002',
                ],
                'isNew' => false,
                'version' => [
                    'id' => 'ver-001',
                    'name' => 'Corolla XEi 2.0 Flex',
                    'engine' => '2.0L Flex',
                    'model' => [
                        'bodyStyle' => BodyStyle::SUV,
                        'id' => 'model-002',
                        'name' => 'HR-V',
                        'platform' => 'Global Small Platform',
                        'brand' => [
                            'id' => 'brand-002',
                            'name' => 'Honda',
                            'logoUrl' => 'https://example.com/logos/honda.png',
                            'createdAt' => '2022-02-01T08:00:00Z',
                            'updatedAt' => '2023-02-01T08:00:00Z'
                        ],
                    ]
                ]
            ],
            [
                'id' => 'veh-002',
                'name' => 'City Novo',
                'licensePlate' => 'XYZ9F87',
                'year' => 2024,
                'km' => 1200,
                'isNew' => true,
                'owner' => [
                    'id' => 'owner-002',
                ],
                'version' => [
                    'id' => 'ver-002',
                    'name' => 'City EXL 1.5 CVT',
                    'engine' => '1.5L Flex',
                    'model' => [
                        'bodyStyle' => BodyStyle::SUV,
                        'id' => 'model-002',
                        'name' => 'HR-V',
                        'platform' => 'Global Small Platform',
                        'brand' => [
                            'id' => 'brand-002',
                            'name' => 'Honda',
                            'logoUrl' => 'https://example.com/logos/honda.png',
                            'createdAt' => '2022-02-01T08:00:00Z',
                            'updatedAt' => '2023-02-01T08:00:00Z'
                        ],
                    ]
                ]
            ],
            [
                'id' => 'veh-003',
                'name' => 'HR-V Turbo',
                'licensePlate' => 'KLM3N21',
                'year' => 2023,
                'km' => 15800,
                'isNew' => false,
                'owner' => [
                    'id' => 'owner-002',
                ],
                'version' => [
                    'id' => 'ver-003',
                    'name' => 'HR-V Touring Turbo',
                    'engine' => '1.5L Turbo',
                    'model' => [
                        'bodyStyle' => BodyStyle::SUV,
                        'id' => 'model-002',
                        'name' => 'HR-V',
                        'platform' => 'Global Small Platform',
                        'brand' => [
                            'id' => 'brand-002',
                            'name' => 'Honda',
                            'logoUrl' => 'https://example.com/logos/honda.png',
                            'createdAt' => '2022-02-01T08:00:00Z',
                            'updatedAt' => '2023-02-01T08:00:00Z'
                        ],
                    ]
                ]
            ],
            [
                'id' => 'veh-004',
                'name' => 'Tracker LTZ',
                'licensePlate' => 'DEF4G56',
                'year' => 2021,
                'km' => 29500,
                'isNew' => false,
                'owner' => [
                    'id' => 'owner-002',
                ],
                'version' => [
                    'id' => 'ver-004',
                    'name' => 'Tracker LTZ 1.0 Turbo',
                    'engine' => '1.0L Turbo',
                    'model' => [
                        'bodyStyle' => BodyStyle::SUV,
                        'id' => 'model-002',
                        'name' => 'HR-V',
                        'platform' => 'Global Small Platform',
                        'brand' => [
                            'id' => 'brand-002',
                            'name' => 'Honda',
                            'logoUrl' => 'https://example.com/logos/honda.png',
                            'createdAt' => '2022-02-01T08:00:00Z',
                            'updatedAt' => '2023-02-01T08:00:00Z'
                        ],
                    ]
                ]
            ],
            [
                'id' => 'veh-005',
                'name' => 'HB20 Comfort',
                'licensePlate' => 'GHI7J89',
                'year' => 2020,
                'km' => 41000,
                'isNew' => false,
                'owner' => [
                    'id' => 'owner-002',
                ],
                'version' => [
                    'id' => 'ver-005',
                    'name' => 'HB20 Comfort 1.0',
                    'engine' => '1.0L Flex',
                    'model' => [
                        'bodyStyle' => BodyStyle::SUV,
                        'id' => 'model-002',
                        'name' => 'HR-V',
                        'platform' => 'Global Small Platform',
                        'brand' => [
                            'id' => 'brand-002',
                            'name' => 'Honda',
                            'logoUrl' => 'https://example.com/logos/honda.png',
                            'createdAt' => '2022-02-01T08:00:00Z',
                            'updatedAt' => '2023-02-01T08:00:00Z'
                        ],
                    ]
                ]
            ],
            [
                'id' => 'veh-006',
                'name' => 'Onix Plus',
                'licensePlate' => 'JKL8M10',
                'year' => 2023,
                'km' => 7600,
                'isNew' => true,
                'owner' => [
                    'id' => 'owner-002',
                ],
                'version' => [
                    'id' => 'ver-006',
                    'name' => 'Onix Plus LTZ 1.0 Turbo',
                    'engine' => '1.0L Turbo',
                    'model' => [
                        'bodyStyle' => BodyStyle::SUV,
                        'id' => 'model-002',
                        'name' => 'HR-V',
                        'platform' => 'Global Small Platform',
                        'brand' => [
                            'id' => 'brand-002',
                            'name' => 'Honda',
                            'logoUrl' => 'https://example.com/logos/honda.png',
                            'createdAt' => '2022-02-01T08:00:00Z',
                            'updatedAt' => '2023-02-01T08:00:00Z'
                        ],
                    ]
                ]
            ],
            [
                'id' => 'veh-007',
                'name' => 'Argo Drive',
                'licensePlate' => 'MNO2P34',
                'year' => 2019,
                'km' => 60000,
                'isNew' => false,
                'owner' => [
                    'id' => 'owner-002',
                ],
                'version' => [
                    'id' => 'ver-007',
                    'name' => 'Argo Drive 1.3',
                    'engine' => '1.3L Flex',
                    'model' => [
                        'bodyStyle' => BodyStyle::SUV,
                        'id' => 'model-002',
                        'name' => 'HR-V',
                        'platform' => 'Global Small Platform',
                        'brand' => [
                            'id' => 'brand-002',
                            'name' => 'Honda',
                            'logoUrl' => 'https://example.com/logos/honda.png',
                            'createdAt' => '2022-02-01T08:00:00Z',
                            'updatedAt' => '2023-02-01T08:00:00Z'
                        ],
                    ]
                ]
            ],
            [
                'id' => 'veh-008',
                'name' => 'Kicks SL',
                'licensePlate' => 'PQR5S67',
                'year' => 2022,
                'km' => 21000,
                'isNew' => false,
                'owner' => [
                    'id' => 'owner-002',
                ],
                'version' => [
                    'id' => 'ver-008',
                    'name' => 'Kicks SL 1.6 CVT',
                    'engine' => '1.6L Flex',
                    'model' => [
                        'bodyStyle' => BodyStyle::SUV,
                        'id' => 'model-002',
                        'name' => 'HR-V',
                        'platform' => 'Global Small Platform',
                        'brand' => [
                            'id' => 'brand-002',
                            'name' => 'Honda',
                            'logoUrl' => 'https://example.com/logos/honda.png',
                            'createdAt' => '2022-02-01T08:00:00Z',
                            'updatedAt' => '2023-02-01T08:00:00Z'
                        ],
                    ]
                ]
            ],
            [
                'id' => 'veh-009',
                'name' => 'Renegade Sport',
                'licensePlate' => 'STU6V78',
                'year' => 2021,
                'km' => 39000,
                'isNew' => false,
                'owner' => [
                    'id' => 'owner-002',
                ],
                'version' => [
                    'id' => 'ver-009',
                    'name' => 'Renegade Sport 1.3 Turbo',
                    'engine' => '1.3L Turbo',
                    'model' => [
                        'bodyStyle' => BodyStyle::SUV,
                        'id' => 'model-002',
                        'name' => 'HR-V',
                        'platform' => 'Global Small Platform',
                        'brand' => [
                            'id' => 'brand-002',
                            'name' => 'Honda',
                            'logoUrl' => 'https://example.com/logos/honda.png',
                            'createdAt' => '2022-02-01T08:00:00Z',
                            'updatedAt' => '2023-02-01T08:00:00Z'
                        ],
                    ]
                ]
            ],
            [
                'id' => 'veh-010',
                'name' => 'Pulse Impetus',
                'licensePlate' => 'VWX9Y01',
                'year' => 2023,
                'km' => 5400,
                'isNew' => true,
                'owner' => [
                    'id' => 'owner-002',
                ],
                'version' => [
                    'id' => 'ver-010',
                    'name' => 'Pulse Impetus 1.0 Turbo',
                    'engine' => '1.0L Turbo',
                    'model' => [
                        'bodyStyle' => BodyStyle::SUV,
                        'id' => 'model-002',
                        'name' => 'HR-V',
                        'platform' => 'Global Small Platform',
                        'brand' => [
                            'id' => 'brand-002',
                            'name' => 'Honda',
                            'logoUrl' => 'https://example.com/logos/honda.png',
                            'createdAt' => '2022-02-01T08:00:00Z',
                            'updatedAt' => '2023-02-01T08:00:00Z'
                        ],
                    ],
                ]
            ]
        ];

    }

    /**
     * @return Vehicle[]
     */
    public function getAll(): array
    {
        Http::fake([
            'fake.com/vehicles*' => Http::response($this->vehicles, 200),
        ]);

        $ownerId = auth()->id();
        $response = Http::get("{$this->baseUrl}/vehicles", [ 'ownerId' => $ownerId  ]);
        $response->throw(); // dispara exception se erro

        return Vehicle::collect($response->json());// retorna array ou collection
    }

    public function find(string $id): Vehicle
    {
        $ownerId = auth()->id();

        Http::fake([
            'fake.com/vehicles/*' => Http::response( [
                'id' => 'veh-001',
                'name' => 'Meu Corolla',
                'licensePlate' => 'ABC1D23',
                'year' => 2022,
                'km' => 35000,
                'owner' => [
                    'id' => 'owner-002',
                ],
                'isNew' => false,
                'version' => [
                    'id' => 'ver-001',
                    'name' => 'Corolla XEi 2.0 Flex',
                    'engine' => '2.0L Flex',
                    'model' => [
                        'bodyStyle' => BodyStyle::SUV,
                        'id' => 'model-002',
                        'name' => 'HR-V',
                        'platform' => 'Global Small Platform',
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
        ]);

        $response = Http::get("{$this->baseUrl}/vehicles/{$id}");
        $response->throw();
        return Vehicle::from($response->json());
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
