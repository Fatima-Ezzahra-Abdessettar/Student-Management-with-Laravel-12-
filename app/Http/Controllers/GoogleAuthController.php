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
            'idToken' => 'required|string',
        ]);

        $idTokenString = $request->idToken;

        try {
            $auth = app('firebase.auth');
            $verifiedIdToken = $auth->verifyIdToken($idTokenString);

            $uid = $verifiedIdToken->claims()->get('sub');
            $userRecord = $auth->getUser($uid);

            $email = $userRecord->email;
            $name = $userRecord->displayName ?? 'User';
            $photo = $userRecord->photoUrl;

        } catch (\Throwable $e) {
            return response()->json(['status' => 'error', 'message' => 'Invalid Token: ' . $e->getMessage()], 401);
        }

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
        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => null, 
            'role' => 'student',
            'google_id' => $uid,
            'email_verified_at' => now(),
        ]);

        Student::create([
            'user_id' => $user->id,
            'full_name' => $name,
            'email' => $email,
            'photo' => null, 
        ]);

        Auth::login($user);

        return response()->json(['status' => 'success', 'redirect_url' => route('dashboard')]);
    }
}
