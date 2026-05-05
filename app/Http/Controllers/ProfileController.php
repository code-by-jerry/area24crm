<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * GET /profile
     */
    public function show(): View
    {
        return view('pages.profile', [
            'title' => 'My Profile',
            'user'  => auth()->user(),
        ]);
    }

    /**
     * PUT /profile
     * Update name, email, phone, bio.
     */
    public function update(Request $request): RedirectResponse
    {
        $user = auth()->user();

        $validated = $request->validate([
            'name'  => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone' => ['nullable', 'string', 'max:50'],
            'bio'   => ['nullable', 'string', 'max:255'],
        ]);

        $user->fill($validated)->save();

        return back()->with('success', 'Profile updated successfully.');
    }

    /**
     * PUT /profile/password
     * Change password.
     */
    public function updatePassword(Request $request): RedirectResponse
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password'         => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        auth()->user()->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Password changed successfully.');
    }
}
