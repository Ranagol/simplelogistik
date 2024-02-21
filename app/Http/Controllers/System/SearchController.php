<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Models\TmsCustomer;
use App\Models\TmsOrder;
use App\Models\TmsAddress;
use App\Models\TmsForwarder;
use App\Models\TmsVehicle;
use Illuminate\Http\Request;

class SearchController extends Controller {
    public function __construct() {
        
    }


    public function search(Request $request) {
        $data = $request->only("resource", "q", "giveback");
        $model = $this->getResorceModel($data["resource"]);

        if ($model) {
            $results = $this->searchInModel($model, $data["q"]);
            $mapped = $this->mapData($results, $data["giveback"]);
            return response()->json($mapped);

            // return $results;
        } else {
            return response()->json(["message" => "Resource not found"], 401);
        }
    }

    private function searchInModel($model, $searchData) {
        $query = $model->query();
        foreach ($model->searchable as $column) {
            $query->orWhere($column, 'like', $searchData . '%');
        }
        $res = $query->get()->toArray();
        return $res;
    }


    private function mapData($results, $giveback) {
        $newResults = [];
        foreach($results as $result){
            $mapped = [];
            foreach($giveback as $key => $newKey){
                $mapped[$newKey] = $result[$key];
            }
            array_push($newResults, $mapped);
        }
        return $newResults;
    }

    private function getResorceModel(String $resource) {
        switch ($resource) {
            case 'customer':
                return new TmsCustomer();
            case 'order':
                return new TmsOrder();
            case 'address':
                return new TmsAddress();
            case 'forwarder':
                return new TmsForwarder();
            case 'vehicle':
                return new TmsVehicle();
            default:
                return null;
        }
    }

}