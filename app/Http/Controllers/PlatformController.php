<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Platform;
use App\Models\User;

class PlatformController extends Controller
{
    // Show all platforms and the selected user (admin can choose users)
    public function index(Request $request)
    {
        $selectedUser = Auth::user();

        // Admin can select a user to edit their platforms
        if (Auth::user()->is_admin && $request->has('user_id')) {
            $selectedUser = User::findOrFail($request->get('user_id'));
        }

        $platforms = Platform::all();
        $activePlatforms = $selectedUser->activePlatforms()->pluck('platform_id')->toArray();

        return view("platforms.index", [
            'platforms' => $platforms,
            'user' => $selectedUser,
            'userPlatforms' => $activePlatforms,
            'users' => Auth::user()->is_admin ? User::all() : null
        ]);
    }

    // Admin-only toggle for platform access for any user
    public function toggle(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'platforms' => 'array',
            'platforms.*' => 'exists:platforms,id',
        ]);
    
        $user = \App\Models\User::findOrFail($request->user_id);
    
        // Sync platforms (replace existing with new selection)
        $user->activePlatforms()->sync($request->platforms ?? []);
    
        return redirect()->route('platforms.index', ['user_id' => $user->id])
                         ->with('status', 'Platforms updated successfully.');
    }
}
