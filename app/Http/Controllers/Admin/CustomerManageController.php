<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Customer;
use App\Models\Rental;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class CustomerManageController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with('customer')
            ->where(function ($q) {
                $q->where('role', '!=', 'admin')
                    ->orWhereNull('role');
            });

        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->orWhere('email', 'like', "%{$search}%")
                    ->orWhereHas('customer', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%")
                            ->orWhere('phone', 'like', "%{$search}%")
                            ->orWhere('nik', 'like', "%{$search}%");
                    });
            });
        }

        $users = $query->latest()->paginate(10);

        $totalUsers = User::where(function ($q) {
            $q->where('role', '!=', 'admin')
                ->orWhereNull('role');
        })->count();

        $totalCustomers = Customer::count();

        $activeCustomers = Customer::whereHas('rentals', function ($query) {
            $query->whereIn('payment_status', ['paid', 'confirmed'])
                ->where('rental_date', '<=', now())
                ->where('return_date', '>=', now());
        })->count();

        return view('admin.customers.index', compact(
            'users',
            'totalUsers',
            'totalCustomers',
            'activeCustomers'
        ));
    }


    public function show($id)
    {
        $user = User::with(['customer', 'rentals' => function ($query) {
            $query->latest();
        }])->findOrFail($id);

        $activeRentals = $user->rentals()
            ->whereIn('payment_status', ['paid', 'confirmed'])
            ->where('rental_date', '<=', now())
            ->where('return_date', '>=', now())
            ->get();

        $completedRentals = $user->rentals()
            ->where('payment_status', 'completed')
            ->latest()
            ->limit(5)
            ->get();

        $pendingRentals = $user->rentals()
            ->whereIn('payment_status', ['pending', 'expired'])
            ->latest()
            ->limit(5)
            ->get();

        return view('admin.customers.show', compact('user', 'activeRentals', 'completedRentals', 'pendingRentals'));
    }

    public function create()
    {
        return view('admin.customers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'customer_name' => 'required|string|max:255',
            'nik' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'gender' => 'nullable|in:male,female',
        ]);

        // Start a database transaction
        DB::beginTransaction();

        try {
            // Create the user
            $user = User::create([
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'customer',
            ]);

            $user->save();

            Customer::create([
                'user_id' => $user->id,
                'name' => $request->customer_name,
                'nik' => $request->nik,
                'phone' => $request->phone,
                'address' => $request->address,
                'gender' => $request->gender,
            ]);

            DB::commit();

            return redirect()->route('customers.manage.index')->with('success', 'User created successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error creating user: ' . $e->getMessage())->withInput();
        }
    }

    public function edit($id)
    {
        $user = User::with('customer')->findOrFail($id);
        return view('admin.customers.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:8|confirmed',
            'customer_name' => 'nullable|string|max:255',
            'nik' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'gender' => 'nullable|in:male,female',
        ]);

        // Start a database transaction
        DB::beginTransaction();

        try {
            $user->email = $request->email;
            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }

            $user->save();

            if ($user->customer) {
                $user->customer->name = $request->customer_name ?? $user->customer->name;
                $user->customer->nik = $request->nik ?? $user->customer->nik;
                $user->customer->phone = $request->phone ?? $user->customer->phone;
                $user->customer->address = $request->address ?? $user->customer->address;
                $user->customer->gender = $request->gender ?? $user->customer->gender;
                $user->customer->save();
            }

            DB::commit();

            return redirect()->route('customers.manage.index')->with('success', 'User updated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error updating user: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Check if user has active rentals
        $activeRentals = $user->rentals()
            ->whereIn('payment_status', ['paid', 'confirmed'])
            ->where('return_date', '>=', now())
            ->exists();

        if ($activeRentals) {
            return redirect()->back()->with('error', 'Cannot delete user with active rentals.');
        }

        // Start a database transaction
        DB::beginTransaction();

        try {
            // Delete the user (this will cascade delete the customer profile due to foreign key constraint)
            $user->delete();

            DB::commit();

            return redirect()->route('customers.manage.index')->with('success', 'User deleted successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error deleting user: ' . $e->getMessage());
        }
    }
}
