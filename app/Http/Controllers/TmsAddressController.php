<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;
use App\Models\TmsAddress;
use App\Models\TmsCustomer;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Http\Requests\TmsAddressRequest;
use Illuminate\Pagination\LengthAwarePaginator;

class TmsAddressController extends BaseController
{
    public function __construct()
    {
        $this->model = new TmsAddress();
        $this->vueIndexPath = 'Addresses/Index';
        $this->vueCreateEditPath = 'Addresses/CreateEditBase';
    }
}