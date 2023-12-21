<?php

namespace App\Http\Controllers\Api;

use App\Response\Message;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Functions\GlobalFunction;

use App\Http\Controllers\Controller;
use Essa\APIToolKit\Api\ApiResponse;

use Illuminate\Support\Facades\Http;
use App\Http\Resources\DepartmentResource;

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
        // Retrieve data from the external API
        $api = "http://10.10.2.76:8000/api/admin/departments?status=all&paginate=0&api_for=genus_etd";
        $token = "3713|9WncN0XEccchl6CHqHBGGRCY57Pfn7XpxvdNzbEt";
    
        // Assuming you are using Laravel HTTP client to make the API request
        $response = Http::withToken($token)->get($api);
    
        // Check if the API request was successful
        if ($response->successful()) {
            $data = $response->json();
    
            // Extract the necessary data from the API response
            $departmentData = $data['result']['departments'];
    
            // Transform the external API data to match your local database structure
            $sync = collect($departmentData)->map(function ($item) {
                $formattedDeletedAt = $item['deleted_at'] ? \Carbon\Carbon::parse($item['deleted_at'])->toDateTimeString() : null;

                return [
                    'sync_id' => $item['id'],
                    'code' => $item['code'],
                    'name' => $item['name'], // Adjusted to use 'name' instead of 'department'
                    'company_sync_id' => $item['company']['id'],
                    'is_active' => is_null($item['deleted_at']),
                    'deleted_at' => $formattedDeletedAt, // Use the formatted value
                ];
            })->toArray();

    
            // Get the sync_id values from the API response
            $syncIdsFromApi = array_column($sync, 'sync_id');
    
            // Delete records from the Department model where sync_id is not in the obtained sync_id values
            Department::whereNotIn('sync_id', $syncIdsFromApi)->delete();
    
            // Upsert the data into the local database
            $department = Department::upsert(
                $sync, ['sync_id'], ['code', 'name', 'company_sync_id', 'is_active', 'deleted_at']
            );
    
            if ($department) {
                return response()->json([
                    'status_code' => 200,
                    'message' => 'Sync Successfully',
                ], 200);
            }
    
            // Return a failure response if something went wrong
            return response()->json([
                'status_code' => 400,
                'message' => 'Failed to sync departments',
            ], 400);
        }
    
        // Return a failure response if something went wrong
        return response()->json([
            'status_code' => 400,
            'message' => 'Failed to sync departments',
        ], 400);
    }
    
}
