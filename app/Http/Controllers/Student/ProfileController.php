<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    /**
     * Display the student's profile.
     */
    public function show()
    {
        $user = Auth::user();
        $student = $user->student; 
        
        if (!$student) {
             // If for some reason the student record is missing, we could create it or show an error.
             // For now, let's create a stub if it's missing to avoid the 404 during this recovery phase.
             $student = \App\Models\Student::create([
                'user_id' => $user->id,
                'full_name' => $user->name,
                'email' => $user->email,
             ]);
        }

        return view('student.profile', compact('user', 'student'));
    }

    /**
     * Update the student's profile.
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        $student = $user->student;

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
            'photo' => ['nullable', 'image', 'max:2048'],
        ]);

        DB::transaction(function () use ($request, $user, $student) {
            $user->update([
                'name' => $request->name,
            ]);

            if ($request->hasFile('photo')) {
                if ($student->photo) {
                    Storage::disk('public')->delete($student->photo);
                }
                $photoPath = $request->file('photo')->store('students', 'public');
                $student->photo = $photoPath;
            }

            $student->update([
                'full_name' => $request->name,
                'phone' => $request->phone,
                'photo' => $student->photo ?? $request->photo_path, // Handle case if photo not uploaded but logic above handles it
            ]);
        });
        
        return redirect()->route('student.profile')->with('success', 'Profile updated successfully.');
    }
}
