<?php

namespace App\Http\Controllers\Api;

use App\Models\Strategy;
use App\Response\Message;
use Illuminate\Http\Request;
use App\Functions\GlobalFunction;
use App\Http\Controllers\Controller;
use Essa\APIToolKit\Api\ApiResponse;
use App\Http\Requests\StrategyRequest;

class StrategyController extends Controller
{
    use ApiResponse;
    public function index(Request $request){
        $status = $request->query('status');

        $users = Strategy::with('objective')
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
            return GlobalFunction::response_function(Message::STRATEGY_DISPLAY, $users);
    }

    public function store(StrategyRequest $request){ 
        $create_strategy = Strategy::create([
            "objective_id" => $request->objective_id,
            "strategy" => $request->strategy,
        ]);
        
        return GlobalFunction::response_function(Message::STRATEGY_SAVE, $create_strategy);
    }

    public function update(StrategyRequest $request, $id){
        $update_strategy = Strategy::find($id);

        if (!$update_strategy) {
            return GlobalFunction::not_found(Message::INVALID_ID);
        }

        $update_strategy->update([
            "objective_id" => $request->objective_id,
            "strategy" => $request->strategy,
        ]);
        return GlobalFunction::response_function(Message::STRATEGY_UPDATE, $update_strategy);
    }

    public function archived(Request $request, $id)
    {
        $strategy = Strategy::withTrashed()->find($id);
        // return $objective
        if (!$strategy) {
            return GlobalFunction::not_found(Message::INVALID_ID);  
        }
        
        if (!$strategy->deleted_at) {
            $strategy->update([
                'is_active' => 0
            ]);
            $strategy->delete();
            return GlobalFunction::response_function(Message::ARCHIVE_STATUS, $strategy);

        } else {
            $strategy->update([
                'is_active' => 1
            ]);
            $strategy->restore();
            return GlobalFunction::response_function(Message::RESTORE_STATUS, $strategy);
        }
    }
}
