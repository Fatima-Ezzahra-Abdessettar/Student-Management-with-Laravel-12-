<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class GoogleAuthController extends Controller
{
    public function callback(Request $request)
    {
        $request->validate([
            'uid' => 'required|string',
            'email' => 'required|email',
            'displayName' => 'required|string',
            'photoURL' => 'nullable|string',
        ]);

        $uid = $request->uid;
        $email = $request->email;
        $name = $request->displayName;
        $photo = $request->photoURL;

        // 1. Try to find user by google_id
        $user = User::where('google_id', $uid)->first();

        if ($user) {
            Auth::login($user);
            return response()->json(['status' => 'success', 'redirect_url' => route('dashboard')]);
        }

        // 2. Try to find user by email
        $user = User::where('email', $email)->first();

        if ($user) {
            // Link Google ID
            $user->google_id = $uid;
            $user->save();
            Auth::login($user);
            return response()->json(['status' => 'success', 'redirect_url' => route('dashboard')]);
        }

        // 3. Create new user and student
        // Force role 'student'
        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => null, // No password for Google Auth users
            'role' => 'student',
            'google_id' => $uid,
            'email_verified_at' => now(),
        ]);

        Student::create([
            'user_id' => $user->id,
            'full_name' => $name,
            'email' => $email,
            'photo' => null, // Or try to download/link the Google photo if needed, but keeping it simple/local for now. Could set to $photo if field is URL friendly or download it.
            // Keeping photo null for now as we store paths, not URLs usually, unless we adapt accessor.
        ]);

        Auth::login($user);

        return response()->json(['status' => 'success', 'redirect_url' => route('dashboard')]);
    }
}
