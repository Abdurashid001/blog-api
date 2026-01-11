<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;


class AdminController extends Controller
{
    public function revoke($id)
{
    $user = User::findOrFail($id);

    if ($user->id === auth()->id()) {
        return response()->json([
            'message' => 'You cannot revoke yourself'
        ], 403);
    }

    $user->is_admin = false;
    $user->save();

    admin_log(
    'REVOKE_ADMIN',
    'user_id='.$user->id,
    'Admin rights revoked'
    );

    return response()->json([
        'message' => 'Admin revoked successfully'
    ]);
}

public function destroy($id)
{
    $user = User::findOrFail($id);

    if (!auth()->user()->is_super_admin) {
        return response()->json([
            'message' => 'Only super admin can delete admins'
        ], 403);
    }

    if ($user->is_super_admin) {
        return response()->json([
            'message' => 'Super admin cannot be deleted'
        ], 403);
    }

    $user->tokens()->delete();
    $user->delete();

    admin_log(
        'DELETE_ADMIN',
        'user_id='.$id,
        'Admin deleted'
    );

    return response()->json([
        'message' => 'Admin deleted successfully'
    ]);
}


}
