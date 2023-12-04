<?php

namespace App\Http\Controllers\Api;
 
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;

class UserController extends Controller
{
    public function index(Request $request){
        $search = $request->query('search');
        $status = $request->query('status');
        $per_page = $request->query('per_page', 10);

        $status = $request->query('status') === 'deactivated' ? 0 : 1;
        $searchableFields = ['id_prefix', 'id_no', 'first_name', 'middle_name', 'last_name', 'location_id', 'department_id', 'company_id'];

        $users = User::with('location', 'department', 'companies', 'role')->withTrashed()
        ->where('is_active', $status)
        ->where(function ($query) use ($searchableFields, $search) {
            foreach ($searchableFields as $field) {
                $query->orWhere($field, 'LIKE', "%{$search}%");
            }
        })
        ->orderBy('created_at', 'DESC')
        ->paginate($per_page);

        $users = UserResource::collection($users);
        
        return response()->json([
            'status_code' => "200",
            'message' => "Data",
            'result' => $users
            ], 200);
    }

    public function store(UserRequest $request){
        $create_user = User::create([
            
            "id_prefix" => $request["personal_info"]["id_prefix"],
            "id_no" => $request["personal_info"]["id_no"],
            "first_name" => $request["personal_info"]["first_name"],
            "middle_name" => $request["personal_info"]["middle_name"],
            "last_name" => $request["personal_info"]["last_name"],
            "sex" => $request["personal_info"]["sex"],

            "username" => $request["username"],
            "password" => $request["password"],

            "location_id" => $request["location_id"],
            "department_id" => $request["department_id"],
            "company_id" => $request["company_id"],
            "role_id" => $request["role_id"],
            "is_active" => 1

        ]);
        return response()->json([
            'status_code' => "200",
            'message' => "User Created Successfully"
            ], 200);
            
    }
    

    public function update(UserRequest $request, $id) {
        $users = User::with("role")->find($id);

        if (!$users) {
            return response()->json([
                'status_code' => "404",
                'message' => "User not found"
                ], 404);
        }

        $users->update([
            "username" => $request["username"],
            "role_id" => $request["role_id"]
        ]);
        return response()->json([
            'status_code' => '200',
            'message' => 'Users Updated Successfully'
            ], 200);
    }


    public function destroy(Request $request, $id){ 
       
    }

    public function archived(Request $request, $id){
        $user = User::withTrashed()->find($id);
    
        if (!$user) {
            return response()->json([
                'status_code' => "404",
                'message' => "User not found"
                ], 404);
        }
    
        if (!$user->deleted_at) {
            $user->update([
                'is_active' => 0
            ]);
            $user->delete();
            return response()->json([
                'status_code' => "200",
                'message' => "User Archived Successfully"
                ], 200);
        } else {
            $user->update([
                'is_active' => 1
            ]);
            $user->restore();
            return response()->json([
                'status_code' => "200",
                'message' => "User Restore Successfully"
                ], 200);
        }
    }
}
