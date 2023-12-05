<?php

namespace App\Http\Controllers\Api;

use App\Models\Companies;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\CompanyResource;

use App\Functions\GlobalFunction;
use App\Response\Message;

use Essa\APIToolKit\Api\ApiResponse;

class CompaniesController extends Controller
{
    use ApiResponse;

    public function index(Request $request){
        $status = $request->query('status');

        $companies = Companies::
        when($status === "inactive", function ($query) {
            $query->onlyTrashed();
        })
        ->useFilters()
        ->dynamicPaginate();
        
        $is_empty = $companies->isEmpty();

        if ($is_empty) {
            return GlobalFunction::not_found(Message::NOT_FOUND);
        }
        CompanyResource::collection($companies);
        return GlobalFunction::response_function(Message::COMPANY_DISPLAY, $companies);
    }

    public function sync_companies(Request $request) {
        $sync = $request->all();
    
        // Extract the "code" values from the array of items
        $codes = array_column($sync, 'code');
    
        // Check for duplicate codes in the request data
        $duplicateCodes = array_unique(array_diff_assoc($codes, array_unique($codes)));
        if (!empty($duplicateCodes)) {
            return response()->json([
                'status_code' => "400",
                'message' => "Duplicate codes found in the request data: " . implode(', ', $duplicateCodes),
            ], 400);
        }
    
        $sync_id = array_column($sync, 'sync_id');
    
        // Check for duplicate codes in the request data
        $duplicatesyncID = array_unique(array_diff_assoc($sync_id, array_unique($sync_id)));
        if (!empty($duplicatesyncID)) {
            return response()->json([
                'status_code' => "400",
                'message' => "Duplicate sync_id found in the request data: " . implode(', ', $duplicatesyncID),
            ], 400);
        }
        
        // Perform upsert for non-duplicate codes
        $companies = Companies::upsert(
            $sync, ['sync_id'], ['code', 'name', 'is_active']
        );
    
        if ($companies) {
            return response()->json([
                'status_code' => "200",
                'message' => "Successfully",
            ], 200);
        }
    
        return response()->json([
            'status_code' => "400",
            'message' => "Failed",
        ], 400);
    }
    
    
    
    
}

