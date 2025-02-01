<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\BiteshipService;
use Illuminate\Http\Request;

class CourrierController extends Controller
{
    private $biteShipService;
    function __construct()
    {
        $this->biteShipService = new BiteshipService();
    }

    public function select(Request $request)
    {
        $data = $this->biteShipService::get_couriers();

        $collection = collect($data);

        $service_type = $request->service_type;
        $courier_code = $request->name;
        $results = $collection->filter(function ($filter) use ($service_type, $courier_code) {
            if ($courier_code) {
                $result_filter = $filter['service_type'] == $service_type && $filter['courier_code'] == $courier_code;
            } else {
                $result_filter = $filter['service_type'] == $service_type;
            }
            return $result_filter;
        });

        return response()->json([
            'recorsTotal' => count($results),
            'data' => $results
        ], 200);
    }

    public function select_with_rate(Request $request)
    {
        $body = [
            "origin_postal_code" => env('MAIN_POSTAL_CODE'),
            "destination_postal_code" => $request->postal_code,
            "couriers" => $request->courier,
            "items" => $request->product_items
        ];

        $response = $this->biteShipService::get_couriers_with_rates($body);

        $totalData = isset($response['pricing']) ? count($response['pricing']) : 0;

        return response()->json([
            'recorsTotal' => $totalData,
            'data' => $response,
        ], 200);
    }
}
