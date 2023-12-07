<?php

namespace App\Http\Controllers\Api;

use App\Response\Message;
use Illuminate\Http\Request;
use App\Functions\GlobalFunction;
use Illuminate\Support\Facades\Validator;


use App\Models\StoreEngagementForm;
use App\Http\Controllers\Controller;

use Essa\APIToolKit\Api\ApiResponse;
use App\Http\Requests\StoreEngagementFormRequest;

class StoreEngagementFormsController extends Controller
{
    use ApiResponse;

    public function index(Request $request){
        
       $status = $request->query('status');

        $StoreEngagementForm = StoreEngagementForm::
        when($status === "inactive", function ($query) {
            $query->onlyTrashed();
        })
        ->useFilters()
        ->dynamicPaginate();
        
        $is_empty = $StoreEngagementForm->isEmpty();

        if ($is_empty) {
            return GlobalFunction::not_found(Message::NOT_FOUND);
        }
            // RoleResource::collection($StoreEngagementForm);
            return GlobalFunction::response_function(Message::STORE_DISPLAY, $StoreEngagementForm);
    }
    // ["admin", "Manager"]
    public function store(StoreEngagementFormRequest $request){
        
        $objectives = $request->objectives;
        $objectivesArray = json_decode($objectives, true);

        $strategies = $request->strategies;
        $strategiesArray = json_decode($strategies, true);

        $findings = $request->findings;
        $findingsArray = json_decode($findings, true);

        $notes = $request->notes;
        $notesArray = json_decode($notes, true);
    
        $objectivesConvertedToString = implode(", ", $objectivesArray);
        $strategiesConvertedToString = implode(", ", $strategiesArray);
        $findingsConvertedToString = implode(", ", $findingsArray);
        $notesConvertedToString = implode(", ", $notesArray);


        $e_signature = $request->file('e_signature');
        $originalName = pathinfo($e_signature->getClientOriginalName(), PATHINFO_FILENAME);
            
        $name = $originalName . '_' . time() . "." . $e_signature->getClientOriginalExtension();
        
        $path = public_path('signature');
    
        $location = $e_signature->move($path, $name);

        $createform =  StoreEngagementForm::create([
            "visit_number" => $request["visit_number"],
            "name" => $request["name"],
            "contact" => $request["contact"],
            "store_name" => $request["store_name"],
            "leader" => $request["leader"],
            "date" => $request["date"],
            "objectives" => $objectivesConvertedToString,
            "strategies" => $strategiesConvertedToString,
            "activities" => $request["activities"],
            "findings" => $findingsConvertedToString,
            "notes" => $notesConvertedToString,
            "e_signature" => $location,
            "is_update" => 0,
            "is_active" => 1,
        ]);

        return GlobalFunction::response_function(Message::STORE_SAVE, $createform);
    }  

    public function followup(StoreEngagementFormRequest $request, $id){
        


        $StoreEngagementForm = StoreEngagementForm::find($id);

        if (!$StoreEngagementForm) {
            return GlobalFunction::not_found(Message::NOT_FOUND);
        }

        $findings = $request->findings;
        $findingsArray = json_decode($findings, true);
        
        $notes = $request->notes;
        $notesArray = json_decode($notes, true);
        
        $findingsConvertedToString = implode(", ", $findingsArray);
        $notesConvertedToString = implode(", ", $notesArray);
        
        $e_signature = $request->file('e_signature');
        $originalName = pathinfo($e_signature->getClientOriginalName(), PATHINFO_FILENAME);
        
        $name = $originalName . '_' . time() . "." . $e_signature->getClientOriginalExtension();
        
        $path = public_path('signature');
        
        $location = $e_signature->move($path, $name);
        
        $StoreEngagementForm->update([
            "activities" => $request["activities"],
            "findings" => $findingsConvertedToString, 
            "notes" => $notesConvertedToString, 
            "e_signature" => $location,
            "is_update" => 1,
        ]);

        return GlobalFunction::response_function(Message::STORE_UPDATE, $StoreEngagementForm);
        
    }

    public function archived(Request $request, $id){
        $StoreEngagementForm = StoreEngagementForm::withTrashed()->find($id);
        // return $StoreEngagementForm
        if (!$StoreEngagementForm) {
            return GlobalFunction::not_found(Message::NOT_FOUND);
        }
        if (!$StoreEngagementForm->deleted_at) {
            $StoreEngagementForm->update([
                'is_active' => 0
            ]);
            $StoreEngagementForm->delete();
            return GlobalFunction::response_function(Message::ARCHIVE_STATUS);

        } else {
            $StoreEngagementForm->update([
                'is_active' => 1
            ]);
            $StoreEngagementForm->restore();
            return GlobalFunction::response_function(Message::RESTORE_STATUS);
        }
    }
}
