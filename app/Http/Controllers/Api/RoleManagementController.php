<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\RoleManagement;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\RoleResource;
use App\Http\Requests\RoleManagementRequest;

class RoleManagementController extends Controller
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

        $RoleManagement = RoleManagement::withTrashed()
            ->where(function ($query) use ($status) {
                $query->where('is_active', $status);
            })
            ->where(function ($query) use ($search) {
                $query->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('access_permission', 'LIKE', "%{$search}%");
            })
            ->orderBy('created_at', 'DESC')
            ->paginate($per_page); // Use orderBy instead of orderby


        // Append the access_permission attribute
        $RoleManagement->each(function ($access) {
            $access_permission = explode(", ", $access->access_permission);
            $access->access_permission = $access_permission;
        });

        RoleResource::collection($RoleManagement);
        return $RoleManagement;
    }

    public function show(REQUEST $request, $id)
    {
        $role_id = RoleManagement::where('id', $id)->get()->first();

        if ($role_id) { //dito naman ichecheck ko muna if existing yung id
            return response()->json([
                'status' => "200",
                'message' => "Data",
                'result' => $role_id
            ], 200);
        } else { //kapag hindi sasabihin naten na id not fount
            return response()->json([
                'status' => "404",
                'message' => "ID not found"
            ], 404);
        }
    }


    public function store(RoleManagementRequest $request)
    {
        $access_permission = $request->access_permission;
        $access_permissionConvertedToString = implode(", ", $access_permission);
        $create_role = RoleManagement::create([
            "name" => $request->name,
            "access_permission" => $access_permissionConvertedToString,
            "is_active" => 1
        ]);


        return response()->json([
            'message' => "Role Created Successfully"
        ], 200);
    }

    public function update(RoleManagementRequest $request, $id)
    {


        $access_permission = $request->access_permission;
        $access_permissionConvertedToString = implode(", ", $access_permission);

        $update_role = RoleManagement::find($id);

        if (!$update_role) {
            return response()->json([
                'message' => "Role Not Found"
            ]);
        }

        $update_role->update([
            "name" => $request->name,
            "access_permission" => $access_permissionConvertedToString
        ]);


        return response()->json([
            'message' => "Role Updated Successfully"
        ]);
    }

    public function destroy(Request $request, $id)
    {
    }

    public function archived(Request $request, $id)
    {
        $role = RoleManagement::withTrashed()->find($id);
        // return $role
        if (!$role) {
            return response()->json([
                'message' => "Role not found"
            ]);
        }

        if (User::where('role_id', $id)->exists()) {
            return response()->json([
                'message' => "Unable to Archive, Role already in used!"
            ]);
        }
        if (!$role->deleted_at) {
            $role->update([
                'is_active' => 0
            ]);
            $role->delete();
            return response()->json([
                'message' => "Role Archived Successfully"
            ]);
        } else {
            $role->update([
                'is_active' => 1
            ]);
            $role->restore();
            return response()->json([
                'message' => "Role Restore Successfully"
            ]);
        }
    }
}
