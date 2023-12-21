<?php

namespace App\Http\Controllers\Api;

use App\Models\Objective;
use App\Response\Message;
use Illuminate\Http\Request;
use App\Functions\GlobalFunction;
use App\Http\Controllers\Controller;
use Essa\APIToolKit\Api\ApiResponse;
use App\Http\Requests\ObjectiveRequest;

class ObjectiveController extends Controller
{
    use ApiResponse;
    public function index(Request $request){
        $status = $request->query('status');

        $users = Objective::with('location')
        ->when($status === "inactive", function ($query) {
            $query->onlyTrashed();
        })
        ->UseFilters()
        ->dynamicPaginate();
        
        $is_empty = $users->isEmpty();
        

        if ($is_empty) {
            return GlobalFunction::not_found(Message::NOT_FOUND);
        }
            // UserResource::collection($users); 
            return GlobalFunction::response_function(Message::OBJECTIVE_DISPLAY, $users);
    }

    public function store(ObjectiveRequest $request){ 
        $create_objectives = Objective::create([
            "objective" => $request->objective,
            "location_id" => $request->location_id,
            "is_active" => 1
        ]);
        
        return GlobalFunction::response_function(Message::OBJECTIVE_SAVE, $create_objectives);
    }

    public function update(ObjectiveRequest $request, $id){
        $update_objectives = Objective::find($id);

        if (!$update_objectives) {
            return GlobalFunction::not_found(Message::INVALID_ID);
        }

        $update_objectives->update([
            "objective" => $request->objective,
            "location_id" => $request->location_id,
            "is_active" => 1
        ]);
        return GlobalFunction::response_function(Message::OBJECTIVE_UPDATE, $update_objectives);
    }
}
