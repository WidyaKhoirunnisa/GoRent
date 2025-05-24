<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rental;
use App\Models\User;
use App\Models\Vehicles;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class RentalManageController extends Controller
{
    public function index(Request $request)
    {
        $query = Rental::with(['user', 'vehicle']);

        // Filter by payment status
        if ($request->has('status') && $request->status != 'all') {
            $query->where('payment_status', $request->status);
        }

        // Filter by date range
        if ($request->has('date_from') && $request->date_from) {
            $query->whereDate('rental_date', '>=', $request->date_from);
        }

        if ($request->has('date_to') && $request->date_to) {
            $query->whereDate('return_date', '<=', $request->date_to);
        }

        // Search by customer name, phone, or vehicle
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('customer_name', 'like', "%{$search}%")
                    ->orWhere('customer_phone', 'like', "%{$search}%")
                    ->orWhere('payment_order_id', 'like', "%{$search}%")
                    ->orWhereHas('vehicle', function ($q) use ($search) {
                        $q->where('brand', 'like', "%{$search}%")
                            ->orWhere('no_plat', 'like', "%{$search}%");
                    });
            });
        }

        $rentals = $query->latest()->paginate(10);

        // Get statistics
        $totalRentals = Rental::count();
        $activeRentals = Rental::whereIn('payment_status', ['paid', 'confirmed'])
            ->where('rental_date', '<=', now())
            ->where('return_date', '>=', now())
            ->count();
        $pendingPayments = Rental::where('payment_status', 'pending')->count();
        $completedRentals = Rental::where('payment_status', 'completed')->count();

        // Get payment status options for filter
        $paymentStatuses = [
            'all' => 'All Statuses',
            'pending' => 'Pending',
            'expired' => 'Expired',
            'paid' => 'Paid',
            'confirmed' => 'Confirmed',
            'completed' => 'Completed',
            'cancelled' => 'Cancelled'
        ];

        return view('admin.bookings.index', compact(
            'rentals',
            'totalRentals',
            'activeRentals',
            'pendingPayments',
            'completedRentals',
            'paymentStatuses'
        ));
    }

    public function userSelection(Request $request)
    {
        $query = User::with('customer')->where(function ($q) {
            $q->where('role', '!=', 'admin')->orWhereNull('role');
        });

        // Apply search filter if provided
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('email', 'like', "%{$search}%")
                    ->orWhereHas('customer', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%")
                            ->orwhere('phone', 'like', "%{$search}%")
                            ->orWhere('nik', 'like', "%{$search}%");
                    });
            });
        }

        $users = $query->paginate(10);
        return view('admin.bookings.create.user-selection', compact('users'));
    }

    public function dateSelection(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $user = User::findOrFail($request->user_id);

        return view('admin.bookings.create.date-selection', compact('user'));
    }

    public function vehicleSelection(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'rental_date' => 'required|date',
            'return_date' => 'required|date|after_or_equal:rental_date',
        ]);

        $user = User::findOrFail($request->user_id);
        $rentalDate = $request->rental_date;
        $returnDate = $request->return_date;
        $type = $request->type ?? 'all';

        // Calculate rental duration
        $startDate = Carbon::parse($rentalDate);
        $endDate = Carbon::parse($returnDate);
        $rentalDuration = $startDate->diffInDays($endDate) + 1; // Include first day

        // Start with all vehicles in normal condition
        $query = Vehicles::where('condition', 'Normal');

        // Apply type filter if not 'all'
        if ($type !== 'all') {
            $query->where('type', $type);
        }

        $vehicles = $query->where('ready', true)
            ->whereDoesntHave('rentals', function ($q) use ($rentalDate, $returnDate) {
                $q->whereIn('payment_status', ['paid', 'confirmed'])
                    ->where(function ($q) use ($rentalDate, $returnDate) {
                        $q->where('rental_date', '<=', $returnDate)
                            ->where('return_date', '>=', $rentalDate);
                    });
            })->get();


        // Get all vehicle types for filter
        $vehicleTypes = Vehicles::select('type')
            ->distinct()
            ->pluck('type')
            ->toArray();

        $activeType = $type;

        return view('admin.bookings.create.vehicle-selection', compact(
            'user',
            'vehicles',
            'rentalDate',
            'returnDate',
            'rentalDuration',
            'vehicleTypes',
            'activeType'
        ));
    }

    public function completeBooking(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'vehicle_id' => 'required|exists:vehicles,id',
            'rental_date' => 'required|date',
            'return_date' => 'required|date|after_or_equal:rental_date',
        ]);

        $user = User::with('customer')->findOrFail($request->user_id);
        $vehicle = Vehicles::findOrFail($request->vehicle_id);
        $rentalDate = Carbon::parse($request->rental_date);
        $returnDate = Carbon::parse($request->return_date);

        // Calculate rental duration and total payment
        $days = $rentalDate->diffInDays($returnDate) + 1; // Include first day
        $totalPayment = $vehicle->price * $days;

        return view('admin.bookings.create.complete-booking', compact(
            'user',
            'vehicle',
            'rentalDate',
            'returnDate',
            'days',
            'totalPayment',
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'vehicle_id' => 'required|exists:vehicles,id',
            'customer_name' => 'required|string|max:255',
            'customer_nik' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:255',
            'customer_address' => 'required|string',
            'customer_gender' => 'required|in:male,female',
            'rental_date' => 'required|date|after_or_equal:today',
            'return_date' => 'required|date|after_or_equal:rental_date',
            'payment_status' => 'required|in:pending,expired,paid,confirmed,completed,cancelled',
        ]);

        // Calculate total payment based on vehicle price and rental duration
        $vehicle = Vehicles::findOrFail($request->vehicle_id);
        $rentalDate = new \DateTime($request->rental_date);
        $returnDate = new \DateTime($request->return_date);
        $days = $rentalDate->diff($returnDate)->days + 1; // Include the first day
        $totalPayment = $vehicle->price * $days;


        $today = now()->format('Ymd');
        $lastRental = Rental::orderBy('id', 'desc')->first();
        $nextId = $lastRental ? $lastRental->id + 1 : 1;
        // Start a database transaction
        DB::beginTransaction();

        try {
            // Create the rental
            $rental = Rental::create([
                'user_id' => $request->user_id,
                'vehicle_id' => $request->vehicle_id,
                'customer_name' => $request->customer_name,
                'customer_nik' => $request->customer_nik,
                'customer_phone' => $request->customer_phone,
                'customer_address' => $request->customer_address,
                'customer_gender' => $request->customer_gender,
                'rental_date' => $request->rental_date,
                'return_date' => $request->return_date,
                'total_payment' => $totalPayment,
                'payment_status' => $request->payment_status,
                'payment_order_id' => 'ORD-' . $today . '-' . str_pad($nextId, 4, '0', STR_PAD_LEFT),
            ]);

            // If payment status is paid or confirmed, update vehicle availability
            if (in_array($request->payment_status, ['paid', 'confirmed'])) {
                $vehicle->ready = false;
                $vehicle->save();
            }

            DB::commit();

            return redirect()->route('bookings.manage.index')->with('success', 'Booking created successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error creating booking: ' . $e->getMessage())->withInput();
        }
    }

    public function show(Rental $rental)
    {
        $rental->load(['user', 'vehicle']);
        return view('admin.bookings.show', compact('rental'));
    }

    public function edit(Rental $rental)
    {
        $vehicles = Vehicles::where(function ($query) use ($rental) {
            $query->where('ready', true)
                ->where('condition', 'Normal')
                ->orWhere('id', $rental->vehicle_id);
        })->get();

        $users = User::all();

        return view('admin.bookings.edit', compact('rental', 'vehicles', 'users'));
    }

    public function update(Request $request, Rental $rental)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'vehicle_id' => 'required|exists:vehicles,id',
            'customer_name' => 'required|string|max:255',
            'customer_nik' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:255',
            'customer_address' => 'required|string',
            'customer_gender' => 'required|in:male,female',
            'rental_date' => 'required|date',
            'return_date' => 'required|date|after:rental_date',
            'payment_status' => 'required|in:pending,expired,paid,confirmed,completed,cancelled',
        ]);

        // Calculate total payment based on vehicle price and rental duration
        $vehicle = Vehicles::findOrFail($request->vehicle_id);
        $rentalDate = new \DateTime($request->rental_date);
        $returnDate = new \DateTime($request->return_date);
        $days = $rentalDate->diff($returnDate)->days + 1; // Include the first day
        $totalPayment = $vehicle->price * $days;

        // Start a database transaction
        DB::beginTransaction();

        try {
            $oldStatus = $rental->payment_status;
            $oldVehicleId = $rental->vehicle_id;

            // Update the rental
            $rental->update([
                'user_id' => $request->user_id,
                'vehicle_id' => $request->vehicle_id,
                'customer_name' => $request->customer_name,
                'customer_nik' => $request->customer_nik,
                'customer_phone' => $request->customer_phone,
                'customer_address' => $request->customer_address,
                'customer_gender' => $request->customer_gender,
                'rental_date' => $request->rental_date,
                'return_date' => $request->return_date,
                'total_payment' => $totalPayment,
                'payment_status' => $request->payment_status,
            ]);

            // Handle vehicle availability changes
            if ($oldVehicleId != $request->vehicle_id) {
                // If vehicle changed, make the old one available again if it was this rental that made it unavailable
                if (in_array($oldStatus, ['paid', 'confirmed'])) {
                    $oldVehicle = Vehicles::find($oldVehicleId);
                    if ($oldVehicle) {
                        $oldVehicle->ready = true;
                        $oldVehicle->save();
                    }
                }

                // Make the new vehicle unavailable if status is paid or confirmed
                if (in_array($request->payment_status, ['paid', 'confirmed'])) {
                    $vehicle->ready = false;
                    $vehicle->save();
                }
            } else {
                // Same vehicle but status changed
                if (
                    !in_array($oldStatus, ['paid', 'confirmed']) &&
                    in_array($request->payment_status, ['paid', 'confirmed'])
                ) {
                    // Status changed to paid/confirmed, make vehicle unavailable
                    $vehicle->ready = false;
                    $vehicle->save();
                } elseif (
                    in_array($oldStatus, ['paid', 'confirmed']) &&
                    !in_array($request->payment_status, ['paid', 'confirmed'])
                ) {
                    // Status changed from paid/confirmed to something else, make vehicle available
                    $vehicle->ready = true;
                    $vehicle->save();
                }
            }

            DB::commit();

            return redirect()->route('bookings.manage.index')->with('success', 'Booking updated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error updating booking: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy(Rental $rental)
    {
        // Start a database transaction
        DB::beginTransaction();

        try {
            // If rental was paid or confirmed, make the vehicle available again
            if (in_array($rental->payment_status, ['paid', 'confirmed'])) {
                $vehicle = Vehicles::find($rental->vehicle_id);
                if ($vehicle) {
                    $vehicle->ready = true;
                    $vehicle->save();
                }
            }

            // Delete the rental
            $rental->delete();

            DB::commit();

            return redirect()->route('bookings.manage.index')->with('success', 'Booking deleted successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error deleting booking: ' . $e->getMessage());
        }
    }

    public function updateStatus(Request $request, Rental $rental)
    {
        $request->validate([
            'payment_status' => 'required|in:pending,expired,paid,confirmed,completed,cancelled',
        ]);

        // Start a database transaction
        DB::beginTransaction();

        try {
            $oldStatus = $rental->payment_status;
            $newStatus = $request->payment_status;

            $rental->payment_status = $newStatus;
            $rental->save();

            // Handle vehicle availability based on status change
            $vehicle = Vehicles::find($rental->vehicle_id);

            if ($vehicle) {
                if (
                    !in_array($oldStatus, ['paid', 'confirmed']) &&
                    in_array($newStatus, ['paid', 'confirmed'])
                ) {
                    // Status changed to paid/confirmed, make vehicle unavailable
                    $vehicle->ready = false;
                    $vehicle->save();
                } elseif (
                    in_array($oldStatus, ['paid', 'confirmed']) &&
                    !in_array($newStatus, ['paid', 'confirmed'])
                ) {
                    // Status changed from paid/confirmed to something else, make vehicle available
                    $vehicle->ready = true;
                    $vehicle->save();
                }
            }

            DB::commit();

            return redirect()->back()->with('success', 'Status Pembayaran berhasil diperbarui!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error memperbarui status pembayaran: ' . $e->getMessage());
        }
    }
}
