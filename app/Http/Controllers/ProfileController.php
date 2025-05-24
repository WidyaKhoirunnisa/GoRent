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
                'name'    => 'nullable|string|max:255',
                'nik'     => 'nullable|string|unique:customers,nik,' . $user->id . ',user_id',
                'phone'   => 'nullable|string|max:15',
                'address' => 'nullable|string',
                'gender'  => 'nullable|in:male,female',
                // Hapus validasi image karena kita akan menangani secara manual
            ]);

            // Cek apakah ada data gambar yang di-crop (dari input tersembunyi)
            if ($request->has('image') && !empty($request->image)) {
                // Data URL dari hasil crop (base64)
                $image_data = $request->input('image');

                // Konversi data URL menjadi file
                if (preg_match('/^data:image\/(\w+);base64,/', $image_data, $type)) {
                    $image_data = substr($image_data, strpos($image_data, ',') + 1);
                    $type = strtolower($type[1]); // jpg, png, gif

                    if (!in_array($type, ['jpg', 'jpeg', 'png', 'gif'])) {
                        return back()->withErrors(['image' => 'Format gambar tidak valid']);
                    }

                    $image_data = str_replace(' ', '+', $image_data);
                    $image_data = base64_decode($image_data);

                    if ($image_data === false) {
                        return back()->withErrors(['image' => 'Gagal decode gambar']);
                    }

                    // Hapus gambar lama jika ada
                    if ($user->customer && $user->customer->image && Storage::disk('public')->exists($user->customer->image)) {
                        Storage::disk('public')->delete($user->customer->image);
                    }

                    // Buat nama file unik
                    $filename = 'profile-' . $user->id . '-' . time() . '.' . $type;
                    $path = 'customer/' . $filename;

                    // Simpan file ke storage
                    Storage::disk('public')->put($path, $image_data);

                    // Set path gambar untuk disimpan ke database
                    $validatedData['image'] = $path;
                }
            } else if ($request->hasFile('image_upload')) {
                // Ini untuk menangani jika ada upload file tradisional (sebagai fallback)
                // Delete old image if exists
                if ($user->customer && $user->customer->image && Storage::disk('public')->exists($user->customer->image)) {
                    Storage::disk('public')->delete($user->customer->image);
                }

                $imagePath = $request->file('image_upload')->store('customer', 'public');
                $validatedData['image'] = $imagePath;
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
