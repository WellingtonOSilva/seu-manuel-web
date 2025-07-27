<?php

namespace App\Http\Controllers\Events;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateEventRequest;
use App\Http\Requests\CreateVehicleRequest;
use App\Services\EventService;
use App\Services\VehicleService;
use Illuminate\Http\JsonResponse;
use Inertia\Inertia;
use Inertia\Response;

class EventsController extends Controller
{
    public function __construct(public VehicleService $vehicleService, public EventService $eventService) {}

    public function index(): Response
    {
        return Inertia::render('events', ['events' => $this->eventService->getAll()]);
    }

    public function showCreatePage(): Response
    {
        $vehicles = $this->vehicleService->getAll();
        return Inertia::render('events/new',  ['vehicles' => $vehicles]);
    }

    public function store(CreateEventRequest $request)
    {
            //$id = $this->vehicleService->create($request);
            return to_route('vehicles.show', ['id' => $request->get('vehicle')])->with('success', 'Event created');
    }

}
