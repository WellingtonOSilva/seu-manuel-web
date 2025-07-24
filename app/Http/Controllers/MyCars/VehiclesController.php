<?php

namespace App\Http\Controllers\MyCars;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateVehicleRequest;
use App\Services\BrandService;
use App\Services\ModelService;
use App\Services\VehicleService;
use Inertia\Inertia;
use Inertia\Response;

class VehiclesController extends Controller
{
    public function __construct(
        public BrandService $brandService,
        public ModelService $modelService,
        public VehicleService $vehicleService,
    ) {}

    public function index(): Response
    {
        $vehicles = $this->vehicleService->getAll();
        return Inertia::render('vehicles', [ 'vehicles' => $vehicles ]);
    }

    public function showCreate(): Response
    {
        return Inertia::render('vehicles/new', [
            'brands' => $this->brandService->getAll(),
            'models' => $this->modelService->getAll(),
        ]);
    }

    public function store(CreateVehicleRequest $request): \Illuminate\Http\RedirectResponse
    {
        try {
            $id = $this->vehicleService->create($request);
            return to_route('vehicles.show', $id->value)->with('success', 'Vehicle created');
        } catch (\Throwable $th) {
            return response()->withErrors($th->getMessage());
        }
    }

    public function destroy(string $id): \Illuminate\Http\Response
    {
        return \response()->make();
    }

    public function edit(): Response
    {
        return Inertia::render('vehicles/new');
    }

    public function detail(string $id): Response
    {
        $vehicle = $this->vehicleService->find($id);

        return Inertia::render('vehicles/detail', [
            'vehicle' => $vehicle,
        ]);
    }

}
