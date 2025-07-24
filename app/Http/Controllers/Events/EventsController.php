<?php

namespace App\Http\Controllers\Events;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Inertia\Response;

class EventsController extends Controller
{

    public function index(): Response
    {
        return Inertia::render('events');
    }

    public function store(): Response
    {
        return Inertia::render('events/new');
    }

}
