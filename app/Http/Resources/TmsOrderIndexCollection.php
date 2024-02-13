<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

/**
 * Here we can transform the data structure of the whole collection of order model objects, that
 * is sent to the order index page. 
 * So, this TmsOrderIndexCollection.php is using TmsOrderIndexResource.php to format the data.
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


        ];
    }
}
