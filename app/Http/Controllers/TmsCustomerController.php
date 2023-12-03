<?php

namespace App\Http\Controllers;

use App\Models\TmsCustomer;
use App\Http\Requests\TmsCustomerRequest;

class TmsCustomerController extends BaseController
{
    public function __construct()
    {
        $this->model = new TmsCustomer();
        $this->vueIndexPath = 'Customers/Index';
        $this->vueCreateEditPath = 'Customers/CreateEditBase';
        $this->validator = new TmsCustomerRequest();
    }
}
