<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Tampilkan form profil pengguna.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Perbarui informasi profil pengguna.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();

        // Reset verifikasi email jika email berubah
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        // Jika bukan admin, lanjut update data pelanggan
        if ($user->role !== 'admin') {
            $validatedData = $request->validate([
                'image'   => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'name'    => 'nullable|string|max:255',
                'nik'     => 'nullable|string|unique:customers,nik,' . $user->id . ',user_id',
                'phone'   => 'nullable|string|max:15',
                'address' => 'nullable|string',
                'gender'  => 'nullable|in:male,female',
            ]);

            if ($request->hasFile('image')) {
                // Delete old image if exists
                if ($user->customer->image && Storage::disk('public')->exists($user->customer->image)) {
                    Storage::disk('public')->delete($user->customer->image);
                }
                
                $imagePath = $request->file('image')->store('customer', 'public');
                $validatedData['image'] = 'customer/'.basename($imagePath);
            }

            // Buat atau update data customer
            if (!$user->customer) {
                $user->customer()->create($validatedData);
            } else {
                $user->customer->update($validatedData);
            }
        }

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Hapus akun pengguna.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
