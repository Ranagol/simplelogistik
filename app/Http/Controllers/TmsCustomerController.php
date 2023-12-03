<?php

namespace App\Http\Controllers;

// use Inertia\Inertia;
// use Inertia\Response;
use App\Models\TmsCustomer;
// use Illuminate\Http\Request;
// use App\Http\Controllers\BaseController;
// use Illuminate\Pagination\LengthAwarePaginator;

class TmsCustomerController extends BaseController
{
    public function __construct()
    {
        $this->model = new TmsCustomer();
        $this->vueIndexPath = 'Customers/Index';
        $this->vueCreateEditPath = 'Customers/CreateEditBase';
    }
}
