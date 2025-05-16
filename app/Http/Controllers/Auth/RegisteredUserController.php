<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\NotificationHelper;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Customer;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'customer',
        ]);

        $generatedName = 'customer' . $user->id;

        Customer::create([
            'user_id' => $user->id,
            'name' => $generatedName,
            'nik' => null,
            'phone' => null,
            'address' => null,
            'gender' => null,
        ]);

        NotificationHelper::notifyAdmins(
            'User Baru Terdaftar',
            "User {$user->email} telah mendaftar.",
            'user',
            route('customers.manage.show', $user->id)
        );

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('home', absolute: false));
    }
}
