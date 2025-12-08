<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        return view('profile.show', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        
        $rules = [
            'name' => 'required|string|max:255',
            'username' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($user->id)],
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'nip' => 'nullable|string|max:255',
        ];

        // Add password validation only if password is being changed
        if ($request->filled('password')) {
            $rules['current_password'] = 'required';
            $rules['password'] = 'required|string|min:8|confirmed';
        }

        $validated = $request->validate($rules);

        // Check current password if changing password
        if ($request->filled('password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return redirect()->back()
                    ->withErrors(['current_password' => 'Password saat ini tidak sesuai'])
                    ->withInput();
            }
            $validated['password'] = Hash::make($validated['password']);
        }

        // Remove password fields if not being changed
        if (!$request->filled('password')) {
            unset($validated['password']);
        }
        unset($validated['current_password']);

        $user->update($validated);

        return redirect()->route('profile.show')
            ->with('success', 'Profile berhasil diperbarui!');
    }
}
