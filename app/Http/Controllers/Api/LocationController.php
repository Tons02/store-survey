<?php

namespace App\Http\Controllers\Api;

use App\Models\Location;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\LocationResource;

class LocationController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');
        $status = $request->query('status');
        $per_page = $request->query('per_page', 10);
    
        switch ($status) {
            case "active":
            case null:
            default:
                $status = 1;
                break;
            case "deactivated":
                $status = 0;
                break;
        }
        $location = Location::with('department')->where('is_active', $status)
        ->where(function ($query) use ($search) {
            $query->where('code', 'LIKE', "%{$search}%")
                ->orWhere('name', 'LIKE', "%{$search}%");
        })
        ->orderBy('created_at', 'DESC')
        ->paginate($per_page);
        
        $location = LocationResource::collection($location);
        
        return response()->json([
            'status_code' => "200",
            'message' => "Display all locations",
            'result' => $location
            ], 200);

    }
    

    

    public function sync_location(Request $request) {
        $data = $request->all();

        // Extract the "code" values from the array of items
        $codes = array_column($data, 'code');

        // Check for duplicate codes in the request data
        $duplicateCodes = array_unique(array_diff_assoc($codes, array_unique($codes)));
        if (!empty($duplicateCodes)) {
            return response()->json([
                'status_code' => "400",
                'message' => "Duplicate codes found in the request data: " . implode(', ', $duplicateCodes),
            ], 400);
        }
 
        foreach ($data as $locationData) {
            $location = Location::updateOrCreate(
                ['sync_id' => $locationData['id']],
                [
                    'code' => $locationData['code'],
                    'name' => $locationData['name'],
                    'is_active' => $locationData['status']
                ]
            );
    
            // Initialize an array to store department sync data
            $departmentsSyncData = [];
    
            // Loop through each department in $locationData['departments']
            foreach ($locationData['departments'] as $department) {
                // Add department id to the sync data array with 'is_active' status
                $departmentsSyncData[$department['id']] = ['is_active' => $locationData['status']];
            }
    
            // Sync multiple departments without detaching existing relationships
            $location->department()->sync($departmentsSyncData);
    
            // If you want to update pivot data for each department individually
            foreach ($locationData['departments'] as $department) {
                $location->department()->updateExistingPivot(
                    $department['id'],
                    ['is_active' => $locationData['status']]
                );
            }
        }
    
        return response()->json([
            'status_code' => "200",
            'message' => "Sync Successfully"
        ], 200);
    }
    
}
