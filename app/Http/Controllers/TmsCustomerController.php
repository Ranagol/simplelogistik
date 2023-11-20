<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;
use App\Models\TmsCustomer;
use Illuminate\Http\Request;


class TmsCustomerController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Customers/Index', [
            'customers' => TmsCustomer::all(),
        ]);
    }
}
