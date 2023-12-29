<?php

namespace App\Http\Controllers\Api;
 
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;

use App\Functions\GlobalFunction;
use App\Response\Message;
  
use Essa\APIToolKit\Api\ApiResponse;


class UserController extends Controller
{
    use ApiResponse;

    public function index(Request $request){
        
        $status = $request->query('status');

        $users = User::with('location', 'department', 'companies', 'role')
        ->when($status === "inactive", function ($query) {
            $query->onlyTrashed();
        })
        ->UseFilters()
        ->dynamicPaginate();
        
        $is_empty = $users->isEmpty();
        

        if ($is_empty) {
            return GlobalFunction::response_function(Message::NOT_FOUND, $users);
        }
            UserResource::collection($users); 
            return GlobalFunction::response_function(Message::USER_DISPLAY, $users);
    }

    public function store(UserRequest $request){

        $create_user = User::create([
            
            "id_prefix" => $request["personal_info"]["id_prefix"],
            "id_no" => $request["personal_info"]["id_no"],
            "first_name" => $request["personal_info"]["first_name"],
            "middle_name" => $request["personal_info"]["middle_name"],
            "last_name" => $request["personal_info"]["last_name"],
            "contact_details" => $request["personal_info"]["contact_details"],
            "sex" => $request["personal_info"]["sex"],

            "username" => $request["username"],
            "password" => $request["username"],

            "location_id" => $request["location_id"],
            "department_id" => $request["department_id"],
            "company_id" => $request["company_id"],
            "role_id" => $request["role_id"],
            "is_active" => 1

        ]);

            return GlobalFunction::save(Message::USER_SAVE, $create_user);
        
    }
    

    public function update(UserRequest $request, $id) {

        $userID = User::with("role")->find($id);

        if (!$userID) {
            return response()->json([
                'status_code' => "404",
                'message' => "User not found"
                ], 404);
        }

        $userID->update([
            "username" => $request["username"],
            "role_id" => $request["role_id"]
        ]);
       
        return GlobalFunction::response_function(Message::USER_UPDATE, $userID);
    }


    public function destroy(Request $request, $id){ 
       
    }

    public function archived(Request $request, $id){
        
        $auth_id = auth('sanctum')->user()->id;
        if($id == $auth_id){
            return response()->json(['message' => 'Unable to Archive, User already in used!'],409);
        }

        $invalid_id = User::where("id", $id)
            ->withTrashed()
            ->get();

        if ($invalid_id->isEmpty()) {
            return GlobalFunction::not_found(Message::NOT_FOUND);
        }
        $user = User::withTrashed()->find($id);
        $is_active = User::withTrashed()
            ->where("id", $id)
            ->first();
        if (!$is_active) {
            return $is_active;
        } elseif (!$is_active->deleted_at) {
            $user->update([
                'is_active' => 0
            ]);
            $user->delete();
            return GlobalFunction::response_function(Message::ARCHIVE_STATUS);
        } else {
            $user->update([
                'is_active' => 1
            ]);
            $user->restore();
            return GlobalFunction::response_function(Message::RESTORE_STATUS);
        }

    }

}
