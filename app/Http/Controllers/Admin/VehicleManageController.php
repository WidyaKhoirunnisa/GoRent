<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vehicles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VehicleManageController extends Controller
{
    public function index(Request $request)
    {
        $activeType = $request->input('type', 'all');
        $query = Vehicles::query();

        // Filter berdasarkan tipe
        if ($activeType !== 'all') {
            $query->where('type', $activeType);
        }

        // Filter pencarian
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('brand', 'like', "%{$search}%")
                    ->orWhere('no_plat', 'like', "%{$search}%")
                    ->orWhere('type', 'like', "%{$search}%");
            });
        }

        // Filter berdasarkan kondisi
        if ($request->filled('condition')) {
            $query->where('condition', $request->condition);

            // Jika kondisi adalah Service, maka paksakan ready = 0
            if ($request->condition === 'Service') {
                $query->where('ready', 0);
            } else {
                // Hanya filter ready jika bukan Service
                if ($request->has('ready') && $request->ready !== '') {
                    $query->where('ready', $request->ready);
                }
            }
        } else {
            // Jika tidak ada kondisi, filter ready tetap berlaku
            if ($request->has('ready') && $request->ready !== '') {
                $query->where('ready', $request->ready);
            }
        }

        // Pagination
        $perPage = $request->input('per_page', 12);
        $vehicles = $query->paginate($perPage);

        return view('admin.vehicles.index', compact('vehicles', 'activeType'));
    }


    public function create()
    {
        return view('admin.vehicles.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'brand' => 'required',
            'type' => 'required',
            'price' => 'required|numeric',
            'no_plat' => 'required|string|unique:vehicles',
            'condition' => 'required',
            'year' => 'required|integer',
            'color' => 'required',
            'ready' => 'required|boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('vehicles', 'public');
            $validatedData['image'] = $imagePath;
        }

        Vehicles::create($validatedData);

        return redirect()->route('vehicles.manage.index')->with('success', 'Vehicle added successfully.');
    }

    // public function show($id)
    // {
    //     $vehicle = Vehicles::findOrFail($id);

    //     // Get rental history for this vehicle
    //     $rentalHistory = $vehicle->rentals()
    //         ->with('user')
    //         ->latest()
    //         ->paginate(10);

    //     // Calculate statistics
    //     $totalRentals = $vehicle->rentals()->count();
    //     $totalRevenue = $vehicle->rentals()
    //         ->whereIn('payment_status', ['paid', 'confirmed', 'completed'])
    //         ->sum('total_payment');
    //     $activeRental = $vehicle->rentals()
    //         ->whereIn('payment_status', ['paid', 'confirmed'])
    //         ->where('rental_date', '<=', now())
    //         ->where('return_date', '>=', now())
    //         ->first();

    //     return view('admin.vehicles.show', compact('vehicle', 'rentalHistory', 'totalRentals', 'totalRevenue', 'activeRental'));
    // }

    public function edit($id)
    {
        $vehicle = Vehicles::findOrFail($id);

        if (!$vehicle) {
            return redirect()->route('admin.vehicles.index')->with('error', 'Vehicle not found.');
        }

        return view('admin.vehicles.edit', compact('vehicle'));
    }

    public function update(Request $request, $id)
    {
        $vehicle = Vehicles::findOrFail($id);

        $validatedData = $request->validate([
            'brand' => 'required',
            'type' => 'required',
            'price' => 'required|numeric',
            'condition' => 'required',
            'year' => 'required|integer',
            'color' => 'required',
            'ready' => 'required|boolean',
            'no_plat' => [
                'required',
                'string',
                \Illuminate\Validation\Rule::unique('vehicles')->ignore($vehicle->id),
            ],
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($vehicle->image && Storage::disk('public')->exists($vehicle->image)) {
                Storage::disk('public')->delete($vehicle->image);
            }

            $imagePath = $request->file('image')->store('vehicles', 'public');
            $validatedData['image'] = 'vehicles/' . basename($imagePath);
        }

        $vehicle->update($validatedData);
        return redirect()->route('vehicles.manage.index')->with('success', 'Vehicle updated successfully');
    }

    public function destroy(Vehicles $vehicle)
    {
        try {
            $vehicle->delete();

            return redirect()->back()->with('success', 'Vehicle deleted successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete vehicle: ' . $e->getMessage());
        }
    }

    public function changeStatus(Request $request, $id)
    {
        $vehicle = Vehicles::findOrFail($id);

        $request->validate([
            'ready' => 'required|boolean',
            'condition' => 'required|in:Normal,Service',
        ]);

        // Check if vehicle has active rentals before making unavailable
        if ($request->ready == false) {
            $hasActiveRentals = $vehicle->rentals()
                ->whereIn('payment_status', ['paid', 'confirmed'])
                ->where('return_date', '>=', now())
                ->exists();

            if ($hasActiveRentals) {
                return redirect()->back()->with('error', 'Cannot mark vehicle as unavailable while it has active rentals.');
            }
        }

        $vehicle->ready = $request->ready;
        $vehicle->condition = $request->condition;
        $vehicle->save();

        return redirect()->back()->with('success', 'Vehicle status updated successfully');
    }
}
