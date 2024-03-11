<?php

namespace App\Http\Resources\OrderResources;

use Illuminate\Http\Request;
use App\Models\TmsNativeOrder;
use App\Models\TmsPamyraOrder;
use Doctrine\DBAL\Schema\Index;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\OrderResources\IndexResource;

/**
 * Formats one order model for order edit/show page.
 */
class ShowEditResource extends IndexResource
{
   
}