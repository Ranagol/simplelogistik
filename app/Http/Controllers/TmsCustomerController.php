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
    }

    /**
     * This is used for dynamic validation. Which happens in the parent BaseController.
     *
     * @return string
     */
    protected function getRequestClass(): string
    {
        return TmsCustomerRequest::class;
    }
}
