<?php

namespace App\Http\Controllers;

use App\Models\Vehicles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VehicleController extends Controller
{

    // Menampilkan daftar mobil dengan filter
    /**
     * Display a listing of the vehicles.
     */
    public function index(Request $request)
    {
        $type = $request->query('type', 'all');

        $query = Vehicles::query()->where('ready', true);

        // Filter by vehicle type if specified
        if ($type && $type !== 'all') {
            $query->where('type', $type);
        }

        $vehicles = $query->get();

        // Filter pencarian
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('brand', 'like', "%{$search}%")
                    ->orWhere('type', 'like', "%{$search}%");
            });
        }

        // Get unique vehicle types for the filter buttons
        $vehicleTypes = Vehicles::distinct()->pluck('type')->toArray();

        // Pagination
        $perPage = $request->input('per_page', 12);
        $vehicles = $query->paginate($perPage);
        
        return view('vehicles.index', [
            'vehicles' => $vehicles,
            'vehicleTypes' => $vehicleTypes,
            'activeType' => $type
        ]);
    }

    /**
     * Display the specified vehicle.
     */
    public function detail(Vehicles $vehicle)
    {
        // Get random vehicles excluding the current one
        $randomVehicles = Vehicles::where('id', '!=', $vehicle->id)
            ->where('ready', true)
            ->inRandomOrder()
            ->take(3)
            ->get();

        return view('vehicles.details', [
            'vehicle' => $vehicle,
            'randomVehicles' => $randomVehicles
        ]);
    }

    public function homepagecar(Vehicles $vehicle)
    {
        if (Auth::check() && Auth::user()->role === 'admin') {
            return redirect()->route('admin');
        }

        // Get random vehicles excluding the current one
        $randomVehicles = Vehicles::where('id', '!=', $vehicle->id)
            ->where('ready', true)
            ->inRandomOrder()
            ->take(6)
            ->get();

        return view('homepage', [
            'randomVehicles' => $randomVehicles
        ]);
    }
}
