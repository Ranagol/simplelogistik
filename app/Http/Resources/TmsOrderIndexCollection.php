<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

/**
 * Here we can transform the data structure of the whole collection of order model objects, that
 * is sent to the order index page. 
 */
class TmsOrderIndexCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [

            /**
             * This is the actual data (collection of order model objects) that we send to the
             * order index page. The data is formatted in TmsOrderIndexResource.php.
             */
            'data' => $this->collection,

            /**
             * This is the way how to add some properties additionally, on the level of the whole
             * collection. This is not the same as adding properties to each order model object.
             */
            'pagination' => [
                'total' => $this->total(),
                'count' => $this->count(),
                'per_page' => $this->perPage(),
                'current_page' => $this->currentPage(),
                'total_pages' => $this->lastPage(),
            ],

        ];
    }
}
