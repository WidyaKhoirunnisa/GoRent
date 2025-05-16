<?php

namespace App\Http\Controllers;

use App\Helpers\NotificationHelper;
use App\Models\Customer;
use App\Models\Rental;
use Carbon\Carbon;
use App\Models\Vehicles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RentalController extends Controller
{
    public function index()
    {
        return view('booking.index');
    }

    public function checkAvailability(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'rental_date' => 'required|date|after_or_equal:today',
            'return_date' => 'required|date|after_or_equal:rental_date',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $rentalDate = Carbon::parse($request->input('rental_date'));
        $returnDate = Carbon::parse($request->input('return_date'));
        $type = $request->query('type');

        // Calculate rental duration in days
        $rentalDuration = $rentalDate->diffInDays($returnDate) + 1; // +1 to include the rental day

        // Get all available vehicles
        $availableVehicles = $this->getAvailableVehicles($rentalDate, $returnDate);

        // Filter by vehicle type if specified
        if ($type && $type !== 'all') {
            $availableVehicles = $availableVehicles->filter(function ($vehicle) use ($type) {
                return $vehicle->type === $type;
            });
        }

        $vehicleTypes = Vehicles::distinct()->pluck('type')->toArray();

        return view('booking.available-vehicles', [
            'vehicles' => $availableVehicles,
            'rental_date' => $rentalDate->format('Y-m-d'),
            'return_date' => $returnDate->format('Y-m-d'),
            'rental_duration' => $rentalDuration,
            'vehicleTypes' => $vehicleTypes,
            'activeType' => $type ?? 'all'
        ]);
    }

    /**
     * Show the rental form for a specific vehicle.
     */
    public function rentVehicle(Request $request, Vehicles $vehicle)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'rental_date' => 'required|date|after_or_equal:today',
            'return_date' => 'required|date|after_or_equal:rental_date',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $rentalDate = Carbon::parse($request->input('rental_date'));
        $returnDate = Carbon::parse($request->input('return_date'));

        // Check if the vehicle is available for the selected dates
        if (!$this->isVehicleAvailable($vehicle->id, $rentalDate, $returnDate)) {
            return redirect()->back()
                ->with('error', 'Sorry, this vehicle is not available for the selected dates.')
                ->withInput();
        }

        // Calculate rental duration and total price
        $rentalDuration = $rentalDate->diffInDays($returnDate) + 1; // +1 to include the rental day
        $totalPayment = $vehicle->price * $rentalDuration;

        // Ambil data customer jika user login
        $customer = null;
        if (Auth::check()) {
            $customer = Customer::where('user_id', Auth::id())->first();
        }

        return view('booking.create', [
            'vehicle' => $vehicle,
            'rental_date' => $rentalDate->format('Y-m-d'),
            'return_date' => $returnDate->format('Y-m-d'),
            'rental_duration' => $rentalDuration,
            'total_payment' => $totalPayment,
            'customer' => $customer,
        ]);
    }

    public function store(Request $request)
    {

        // Validasi input
        $validated = $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'rental_date' => 'required|date|after_or_equal:today',
            'return_date' => 'required|date|after_or_equal:rental_date',
            'name' => 'required|string|max:255',
            'nik' => 'required|string|max:20',
            'phone' => 'required|string|max:15',
            'gender' => 'required|in:male,female',
            'address' => 'required|string',
            'terms' => 'required|accepted',
        ]);

        try {
            DB::beginTransaction();

            $user = Auth::user();
            if (!$user) {
                return redirect()->route('login')->with('error', 'Please login to make a booking.');
            }

            // Update or create customer
            $customer = Customer::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'name' => $validated['name'],
                    'nik' => $validated['nik'],
                    'phone' => $validated['phone'],
                    'gender' => $validated['gender'],
                    'address' => $validated['address'],
                ]
            );

            // Ambil kendaraan & hitung total
            $vehicle = Vehicles::findOrFail($validated['vehicle_id']);
            $rentalDate = Carbon::parse($validated['rental_date']);
            $returnDate = Carbon::parse($validated['return_date']);
            $duration = $rentalDate->diffInDays($returnDate) + 1;
            $totalPayment = $vehicle->price * $duration;

            $today = now()->format('Ymd');
            $lastRental = Rental::orderBy('id', 'desc')->first();
            $nextId = $lastRental ? $lastRental->id + 1 : 1;

            // Simpan data sewa
            $rental = Rental::create([
                'user_id' => $user->id,
                'customer_id' => $customer->id,
                'vehicle_id' => $vehicle->id,
                'customer_name' => $validated['name'],
                'customer_nik' => $validated['nik'],
                'customer_phone' => $validated['phone'],
                'customer_gender' => $validated['gender'],
                'customer_address' => $validated['address'],
                'rental_date' => $rentalDate,
                'return_date' => $returnDate,
                'total_payment' => $totalPayment,
                'payment_status' => 'pending',
                'payment_order_id' => 'ORD-' . $today. '-' . str_pad($nextId, 4, '0', STR_PAD_LEFT),

            ]);

            DB::commit();

            NotificationHelper::notifyAdmins(
                'Pemesanan Baru',
                "Pemesanan baru telah dibuat oleh {$rental->customer_name}.",
                'booking',
                route('bookings.manage.show', $rental->id)
            );

            return redirect()->route('booking.confirmation', $rental->id)
                ->with('success', 'Booking successful. Please proceed to payment.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Rental booking failed: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'An error occurred. Please try again.');
        }
    }
    /**
     * Display the rental confirmation page.
     */
    public function confirmation(Rental $rental)
    {
        // Make sure the rental belongs to the authenticated user
        if ($rental->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('booking.confirmation', [
            'rental' => $rental
        ]);
    }

    /**
     * Show the payment page for a specific rental.
     */
    public function showPayment(Rental $rental)
    {
        // Make sure the rental belongs to the authenticated user
        if ($rental->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Check if the rental is already paid
        if ($rental->payment_status !== 'pending') {
            return redirect()->route('customer.history')
                ->with('error', 'This booking has already been processed.');
        }

        // Check if the rental is expired
        if ($rental->is_expired) {
            return redirect()->route('customer.history')
                ->with('error', 'This booking has expired. Please make a new booking.');
        }

        return view('booking.payment', [
            'rental' => $rental
        ]);
    }

    public function processPayment(Request $request, Rental $rental)
    {
        // Make sure the rental belongs to the authenticated user
        if ($rental->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Check if the rental is already paid
        if ($rental->payment_status !== 'pending') {
            return redirect()->route('customer.history')
                ->with('error', 'This booking has already been processed.');
        }

        // Check if the rental is expired
        if ($rental->is_expired) {
            // Update the status to expired if it's still pending
            if ($rental->payment_status === 'pending') {
                $rental->payment_status = 'expired';
                $rental->save();
            }
            
            return redirect()->route('customer.history')
                ->with('error', 'This booking has expired. Please make a new booking.');
        }

        // Validate payment information
        $validated = $request->validate([
            'payment_method' => 'required|in:credit_card,paypal,bank_transfer',
        ]);

        try {
            DB::beginTransaction();

            // In a real application, you would process the payment with a payment gateway here
            // For this example, we'll just mark the payment as successful

            // Update the rental status to confirmed
            $rental->payment_status = 'paid';
            $rental->save();

            DB::commit();

            return redirect()->route('customer.history')
                ->with('success', 'Payment successful! Your booking has been confirmed.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Payment processing failed: ' . $e->getMessage());
            
            return redirect()->back()
                ->with('error', 'Payment processing failed. Please try again.');
        }
    }

    /**
     * Get all available vehicles for the specified date range.
     */
    private function getAvailableVehicles(Carbon $rentalDate, Carbon $returnDate)
    {
        // Get all vehicles that are ready for rental
        $vehicles = Vehicles::where('ready', true)->get();

        // Filter out vehicles that are already booked for the specified date range
        return $vehicles->filter(function ($vehicle) use ($rentalDate, $returnDate) {
            return $this->isVehicleAvailable($vehicle->id, $rentalDate, $returnDate);
        });
    }

    /**
     * Check if a vehicle is available for the specified date range.
     */
    private function isVehicleAvailable($vehicleId, Carbon $rentalDate, Carbon $returnDate)
    {
        // Check if there are any overlapping rentals for this vehicle
        $overlappingRentals = Rental::where('vehicle_id', $vehicleId)
            ->whereNotIn('payment_status', ['cancelled', 'expired'])
            ->where(function ($query) use ($rentalDate, $returnDate) {
                // Rental period overlaps with the requested period
                $query->where(function ($q) use ($rentalDate, $returnDate) {
                    $q->where('rental_date', '<=', $returnDate->format('Y-m-d'))
                        ->where('return_date', '>=', $rentalDate->format('Y-m-d'));
                });
            })
            ->count();

        return $overlappingRentals === 0;
    }
}
