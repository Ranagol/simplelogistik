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
        $this->vueIndexPath = 'Addresses/IndexAddress/Index';
        $this->vueCreateEditPath = 'Addresses/CreateEditAddress/CreateEditBase';
    }

    /**
     * This is used for dynamic validation. Which happens in the parent BaseController.
     *
     * @return string
     */
    protected function getRequestClass(): string
    {
        return TmsAddressRequest::class;
    }

    public function create(): Response
    {
        return Inertia::render(
            $this->vueCreateEditPath, 
            [
                // 'record' => $record,
                'mode' => 'create',
                'addressTypes' => TmsAddress::ADDRESS_TYPES,
            ]
        );
    }

    /**
     * Undocumented function
     *
     * @param string $id
     * @return Response
     */
    public function edit(string $id): Response
    {
        $record = $this->model::find($id);

        return Inertia::render(
            $this->vueCreateEditPath, 
            [
                'record' => $record,
                'mode' => 'edit',
                'addressTypes' => TmsAddress::ADDRESS_TYPES,
            ]
        );
    }
}