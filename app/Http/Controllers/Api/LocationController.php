<?php

namespace App\Http\Controllers\Api;

use App\Models\Location;
use App\Response\Message;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Functions\GlobalFunction;

use App\Http\Controllers\Controller;
use Essa\APIToolKit\Api\ApiResponse;

use Illuminate\Support\Facades\Http;
use App\Http\Resources\LocationResource;

class LocationController extends Controller
{
    use ApiResponse;

    public function index(Request $request)
    {
        $status = $request->query('status');

        $location = Location::with('department')
        ->when($status === "inactive", function ($query) {
            $query->onlyTrashed();
        })
        ->UseFilters()
        ->dynamicPaginate();
        
        $is_empty = $location->isEmpty();

        if ($is_empty) {
            return GlobalFunction::not_found(Message::NOT_FOUND);
        }
            LocationResource::collection($location);
            return $this->responseSuccess('Location Display Successfully', $location);

    }
    
    public function sync_location(Request $request) {
        $api = "http://10.10.2.76:8000/api/admin/locations?status=all&paginate=0&api_for=genus_etd";
        $token = "3713|9WncN0XEccchl6CHqHBGGRCY57Pfn7XpxvdNzbEt";
    
        // Assuming you are using Laravel HTTP client to make the API request
        $response = Http::withToken($token)->get($api);
    
        if ($response->successful()) {
            $data = $response->json()['result']['locations']; // Access the 'locations' array
    
            foreach ($data as $locationData) {
                $formattedDeletedAt = $locationData['deleted_at'] ? \Carbon\Carbon::parse($locationData['deleted_at'])->toDateTimeString() : null;
                $location = Location::updateOrCreate(
                    ['sync_id' => $locationData['id']],
                    [
                        'code' => $locationData['code'],
                        'name' => $locationData['name'], // Adjusted to use 'name' instead of 'location'
                        'is_active' => is_null($locationData['deleted_at']),
                        'deleted_at' => $formattedDeletedAt, // Use the formatted value
                    ]
                );
    
                // If you want to update pivot data for each department individually
                foreach ($locationData['departments'] as $department) {
                    $location->department()->syncWithoutDetaching([$department['id']]);
                }
            }   
    
            return response()->json([
                'status_code' => 200,
                'message' => 'Sync Successfully'
            ], 200);
        } else {
            // Handle unsuccessful API response here
            return response()->json([
                'status_code' => $response->status(),
                'message' => 'Failed to sync locations'
            ], $response->status());
        }
    }
}
