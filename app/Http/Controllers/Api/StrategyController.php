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
        $objective_id = $request->query('objective');
        $store_id = $request->query('store');

        $strategy = Strategy::with(['objective.location'])
        ->when($status === "inactive", function ($query) {
            $query->onlyTrashed();
        })
        ->when($objective_id, function ($query) use ($objective_id) {
            $query->whereHas('objective', function ($locationQuery) use ($objective_id) {
                $locationQuery->where('id', $objective_id);
            });
        })
        ->when($store_id, function ($query) use ($store_id) {
            $query->whereHas('objective', function ($locationQuery) use ($store_id) {
                $locationQuery->where('location_id', $store_id);
            });
        })
        ->orderBy('created_at', 'desc')
        ->UseFilters()
        ->dynamicPaginate();
        
        $is_empty = $strategy->isEmpty();
        

        if ($is_empty) {
            return GlobalFunction::response_function(Message::NOT_FOUND, $strategy);
        }
            // UserResource::collection($strategy); 
            return GlobalFunction::response_function(Message::STRATEGY_DISPLAY, $strategy);
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
