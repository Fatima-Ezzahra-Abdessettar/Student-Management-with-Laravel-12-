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
        
        // Ensure student record exists (if created via seeder might be missing if not careful, but logic handles it)
        if (!$student) {
             // Fallback or create? Better to fail loud or redirect.
             // For this app, we assume 1-1 check.
             abort(404, 'Student profile not found.');
        }

        return view('student.profile', compact('vector', 'user', 'student'));
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
