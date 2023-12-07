<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\RoleManagement;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\RoleResource;
use App\Http\Requests\RoleManagementRequest;

use App\Functions\GlobalFunction;
use App\Response\Message;

use Essa\APIToolKit\Api\ApiResponse;

class RoleManagementController extends Controller
{
    use ApiResponse;

    public function index(Request $request)
    {
        $status = $request->query('status');
        
        $RoleManagement = RoleManagement::
        when($status === "inactive", function ($query) {
            $query->onlyTrashed();
        })
        ->useFilters()
        ->dynamicPaginate();
        
        $is_empty = $RoleManagement->isEmpty();

        if ($is_empty) {
            return GlobalFunction::not_found(Message::NOT_FOUND);
        }
            RoleResource::collection($RoleManagement);
            return GlobalFunction::response_function(Message::ROLE_DISPLAY, $RoleManagement);

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
        
        return GlobalFunction::response_function(Message::ROLE_SAVE, $create_role);
        
    }

    public function update(RoleManagementRequest $request, $id)
    {
        $access_permission = $request->access_permission;
        $access_permissionConvertedToString = implode(", ", $access_permission);

        $update_role = RoleManagement::find($id);

        if (!$update_role) {
            return GlobalFunction::not_found(Message::NOT_FOUND);
        }

        $update_role->update([
            "name" => $request->name,
            "access_permission" => $access_permissionConvertedToString
        ]);
        return GlobalFunction::response_function(Message::ROLE_UPDATE, $update_role);
    }

    public function destroy(Request $request, $id)
    {
    }

    public function archived(Request $request, $id)
    {
        $role = RoleManagement::withTrashed()->find($id);
        // return $role
        if (!$role) {
            return GlobalFunction::not_found(Message::NOT_FOUND);
        }

        if (User::where('role_id', $id)->exists()) {
            return GlobalFunction::invalid(Message::ROLE_ALREADY_USE);
        }
        if (!$role->deleted_at) {
            $role->update([
                'is_active' => 0
            ]);
            $role->delete();
            return GlobalFunction::response_function(Message::ARCHIVE_STATUS);

        } else {
            $role->update([
                'is_active' => 1
            ]);
            $role->restore();
            return GlobalFunction::response_function(Message::RESTORE_STATUS);
        }
    }
}
