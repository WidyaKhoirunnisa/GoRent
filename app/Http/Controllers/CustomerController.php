<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Models\Rental;

class CustomerController extends Controller
{
    /**
     * Display the rental history for the authenticated user.
     */
    public function history(Request $request)
    {
        // First, update any expired pending bookings
        $this->updateExpiredBookings();
        
        // Get all rentals for the authenticated user
        $query = Rental::where('user_id', Auth::id())
            ->with('vehicle');
        
        // Apply filter if provided
        $filter = $request->query('filter');
        if ($filter && in_array($filter, ['pending', 'paid', 'confirmed', 'completed', 'cancelled'])) {
            $query->where('payment_status', $filter);
        }
        
        // Apply search if provided
        $search = $request->query('search');
        if ($search) {
            $query->whereHas('vehicle', function($q) use ($search) {
                $q->where('brand', 'like', "%{$search}%")
                  ->orWhere('type', 'like', "%{$search}%")
                  ->orWhere('no_plat', 'like', "%{$search}%");
            });
        }
        
        // Apply sorting
        $sort = $request->query('sort', 'newest');
        switch ($sort) {
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'price_high':
                $query->orderBy('total_payment', 'desc');
                break;
            case 'price_low':
                $query->orderBy('total_payment', 'asc');
                break;
            case 'newest':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }
        
        // Execute the query
        $rentals = $query->get();
        
        // Get all rentals for the stats at the top (this needs to be all rentals regardless of filter)
        $allRentals = Rental::where('user_id', Auth::id())->get();
        
        return view('customer.history', [
            'rentals' => $rentals,
            'allRentals' => $allRentals,
            'activeFilter' => $filter ?: 'all',
            'activeSort' => $sort,
            'search' => $search
        ]);
    }

    /**
     * Display the details of a specific rental.
     */
    public function historyDetail(Rental $rental)
    {
        // Make sure the rental belongs to the authenticated user
        if ($rental->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('customer.history-detail', [
            'rental' => $rental
        ]);
    }

    /**
     * Cancel a booking.
     */
    public function cancelBooking(Rental $rental)
    {
        // Make sure the rental belongs to the authenticated user
        if ($rental->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Check if the rental can be cancelled
        if (!$rental->can_be_cancelled) {
            return redirect()->back()
                ->with('error', 'This booking cannot be cancelled.');
        }

        // Update the rental status
        $rental->payment_status = 'cancelled';
        $rental->save();

        return redirect()->route('customer.history')
            ->with('success', 'Your booking has been cancelled successfully.');
    }

    /**
     * Update expired bookings to expired status.
     */
    private function updateExpiredBookings()
    {
        $oneHourAgo = Carbon::now()->subHour();

        // Find pending bookings older than 1 hour for the current user
        $expiredBookings = Rental::where('user_id', Auth::id())
            ->where('payment_status', 'pending')
            ->where('created_at', '<', $oneHourAgo)
            ->get();

        foreach ($expiredBookings as $booking) {
            // Update status to expired
            $booking->payment_status = 'expired';
            $booking->save();

            Log::info("Expired booking #{$booking->id} has been marked as expired.");
        }
    }

    public function downloadReceipt($id)
    {
        // Load rental beserta relasinya
        $rental = Rental::with(['vehicle', 'user'])->findOrFail($id);

        // Cek apakah user yang login berhak akses receipt ini
        if ($rental->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access.');
        }

        // Cek status pembayaran
        if (!in_array($rental->payment_status, ['paid', 'confirmed', 'completed'])) {
            abort(403, 'Payment not completed.');
        }

        // Load view dan kirim ke PDF
        $pdf = Pdf::loadView('pdf.receipt', [
            'rental' => $rental
        ]);

        $pdf->setPaper('a4', 'portrait');

        return $pdf->download('rental_receipt_' . $rental->id . '.pdf');
    }
}
