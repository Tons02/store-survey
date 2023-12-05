<?php

namespace App\Http\Controllers\Api;

use App\Models\Department;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\DepartmentResource;

use App\Functions\GlobalFunction;
use App\Response\Message;

use Essa\APIToolKit\Api\ApiResponse;

class DepartmentController extends Controller
{
    use ApiResponse;

    public function index(Request $request) {

        $status = $request->query('status');

        $department = Department::with("company")
        ->when($status === "inactive", function ($query) {
            $query->onlyTrashed();
        })
        ->useFilters()
        ->dynamicPaginate();
        
        $is_empty = $department->isEmpty();

        if ($is_empty) {
            return GlobalFunction::not_found(Message::NOT_FOUND);
        }
        DepartmentResource::collection($department);
        return GlobalFunction::response_function(Message::DEPARTMENT_DISPLAY, $department);

    }

    public function sync_department(Request $request) {
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
        
        $department = Department::upsert(
            $sync, ['sync_id'], ['code', 'name', 'company_sync_id', 'is_active']
        );

        if($department){
        return response()->json([
            'status_code' => "200",
            'message' => "Sync Successfully"
        ], 200);
        }
        return response()->json([
            'status_code' => "400",
            'message' => "Failed"
        ], 400);
    }
}
