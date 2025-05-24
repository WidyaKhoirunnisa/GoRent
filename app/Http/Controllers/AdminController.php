<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Customer;
use App\Models\Rental;
use App\Models\Vehicles;

class AdminController extends Controller
{

    public function index()
    {
        // Vehicle statistics
        $totalVehicles = Vehicles::count();
        $availableVehicles = Vehicles::where('ready', true)->where('condition', 'Normal')->count();
        $serviceVehicles = Vehicles::where('condition', 'Service')->count();
        
        // User statistics
        $totalUsers = User::where('role', '!=', 'admin')->orWhereNull('role')->count();
        $totalCustomers = Customer::count();
        $newUsersThisMonth = Customer::where('created_at', '>=', Carbon::now()->startOfMonth())->count();
        
        // Booking statistics
        $totalBookings = Rental::count();
        $activeRentals = Rental::whereIn('payment_status', ['paid', 'confirmed'])
            ->count();
        $pendingPayments = Rental::where('payment_status', 'pending')->count();
        
        // Revenue statistics
        $totalRevenue = Rental::whereIn('payment_status', ['paid', 'confirmed', 'completed'])->sum('total_payment');
        $revenueThisMonth = Rental::whereIn('payment_status', ['paid', 'confirmed', 'completed'])
            ->whereMonth('created_at', Carbon::now()->month)
            ->sum('total_payment');
        
        // Recent bookings
        $recentBookings = Rental::with(['user', 'vehicle'])
            ->latest()
            ->limit(5)
            ->get();
        
        // Popular vehicles (most booked)
        // Replace the popular vehicles query with this alternative approach
        // Popular vehicles (most booked)
        $popularVehicles = DB::table('vehicles')
            ->select('vehicles.*', DB::raw('COUNT(rentals.id) as rentals_count'))
            ->leftJoin('rentals', 'vehicles.id', '=', 'rentals.vehicle_id')
            ->whereIn('rentals.payment_status', ['paid', 'confirmed', 'completed'])
            ->groupBy('vehicles.id', 'vehicles.type', 'vehicles.brand', 'vehicles.no_plat', 'vehicles.color', 'vehicles.year', 'vehicles.ready', 'vehicles.price', 'vehicles.condition', 'vehicles.image', 'vehicles.created_at', 'vehicles.updated_at')
            ->orderByDesc('rentals_count')
            ->limit(5)
            ->get();
        
        // Monthly revenue for chart (last 6 months)
        $monthlyRevenue = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $revenue = Rental::whereIn('payment_status', ['paid', 'confirmed', 'completed'])
                ->whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->sum('total_payment');
            
            $monthlyRevenue[] = [
                'month' => $month->format('M'),
                'revenue' => $revenue
            ];
        }
        
        // Vehicle types distribution for chart
        $vehicleTypes = Vehicles::select('type', DB::raw('count(*) as count'))
            ->groupBy('type')
            ->get()
            ->map(function($item) use ($totalVehicles) {
                $item->percentage = $totalVehicles > 0 ? round(($item->count / $totalVehicles) * 100) : 0;
                return $item;
            });
        
        return view('admin.dashboard', compact(
            'totalVehicles', 'availableVehicles', 'serviceVehicles',
            'totalUsers', 'totalCustomers', 'newUsersThisMonth',
            'totalBookings', 'activeRentals', 'pendingPayments',
            'totalRevenue', 'revenueThisMonth',
            'recentBookings', 'popularVehicles',
            'monthlyRevenue', 'vehicleTypes'
        ));
    }

}