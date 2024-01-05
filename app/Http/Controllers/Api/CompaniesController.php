<?php

namespace App\Http\Controllers\Api;

use App\Models\Companies;
use App\Response\Message;
use Illuminate\Http\Request;
use App\Functions\GlobalFunction;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\Controller;
use Essa\APIToolKit\Api\ApiResponse;

use Illuminate\Support\Facades\Http;
use App\Http\Resources\CompanyResource;

class CompaniesController extends Controller
{
    use ApiResponse;

    public function index(Request $request){
        $status = $request->query('status');

        $companies = Companies::
        when($status === "inactive", function ($query) {
            $query->onlyTrashed();
        })
        ->orderBy('created_at', 'desc')
        ->useFilters()
        ->dynamicPaginate();
        
        $is_empty = $companies->isEmpty();

        if ($is_empty) {
            return GlobalFunction::response_function(Message::NOT_FOUND, $companies);
        }
        CompanyResource::collection($companies);
        return GlobalFunction::response_function(Message::COMPANY_DISPLAY, $companies);
    }

    public function sync_companies(Request $request) {
        // Retrieve data from the external API
        $api = "http://10.10.2.76:8000/api/admin/companies?status=all&paginate=0&api_for=genus_etd";
        $token = "3713|9WncN0XEccchl6CHqHBGGRCY57Pfn7XpxvdNzbEt";
    
        // Assuming you are using Laravel HTTP client to make the API request
        $response = Http::withToken($token)->get($api);
    
        // Check if the API request was successful
        if ($response->successful()) {
            $data = $response->json();
    
            // Extract the necessary data from the API response
            $companiesData = $data['result']['companies'];

            
            // Transform data to match the Companies model fields
            $sync = collect($companiesData)->map(function ($company) {
                $formattedDeletedAt = $company['deleted_at'] ? \Carbon\Carbon::parse($company['deleted_at'])->toDateTimeString() : null;
                return [
                    'sync_id' => $company['id'],
                    'code' => $company['code'],
                    'name' => $company['name'], 
                    'is_active' => is_null($company['deleted_at']), 
                    'deleted_at' =>  $formattedDeletedAt, 
                ];
            })->toArray();
    
            // Get the sync_id values from the API response
            $syncIdsFromApi = array_column($sync, 'sync_id');
    
            // Delete records from the Companies model where sync_id is not in the obtained sync_id values
            Companies::whereNotIn('sync_id', $syncIdsFromApi)->delete();
    
            // Perform upsert for non-duplicate sync_ids
            $result = Companies::upsert(
                $sync, ['sync_id'], ['code', 'name', 'is_active', 'deleted_at']
            );
    
            if ($result) {
                return response()->json([
                    'status_code' => 200,
                    'message' => 'Successfully synced companies.',
                ], 200);
            }
    
            // Return a failure response if something went wrong
            return response()->json([
                'status_code' => 400,
                'message' => 'Failed to sync companies.',
            ], 400);
        }
    
        // Return a failure response if something went wrong with the API request
        return response()->json([
            'status_code' => 400,
            'message' => 'Failed to fetch companies from the API.',
        ], 400);
    }    
    
}

