<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;
use App\Models\TmsAddress;
use Illuminate\Http\Request;

class TmsAddressController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Addresses/Index', [
            'addresses' => TmsAddress::all(),
        ]);
    }
}