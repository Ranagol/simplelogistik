<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;
use App\Models\TmsCargoOrder;
use Illuminate\Http\Request;

class TmsCargoOrderController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('CargoOrders/Index', [
            'cargoOrders' => TmsCargoOrder::all(),
        ]);
    }
}
