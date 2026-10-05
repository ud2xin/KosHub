<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\Rental;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    /**
     * Form Booking Kamar untuk Calon Penyewa
     */
    public function create(Room $room)
    {
        $user = auth()->user();

        if ($user->role !== 'tenant') {
            return redirect()->route('properties.show', $room->property->slug)
                ->with('error', 'Hanya akun penyewa (tenant) yang dapat melakukan sewa unit kamar.');
        }

        if ($room->status !== 'available') {
            return redirect()->route('properties.show', $room->property->slug)
                ->with('error', 'Maaf, unit kamar ini sedang tidak tersedia untuk disewa.');
        }

        return view('tenant.bookings.create', compact('room'));
    }

    /**
     * Proses Pemesanan Kamar & Buat Tagihan Pembayaran
     */
    public function store(Request $request, Room $room)
    {
        $user = auth()->user();

        if ($user->role !== 'tenant') {
            abort(403, 'Akses ditolak.');
        }

        $request->validate([
            'start_date' => 'required|date|after_or_equal:today',
            'duration_months' => 'required|integer|in:1,3,6,12',
            'notes' => 'nullable|string|max:500',
        ]);

        return DB::transaction(function () use ($request, $room, $user) {
            // Lock record kamar untuk menghindari race condition
            $lockedRoom = Room::where('id', $room->id)->lockForUpdate()->first();

            if ($lockedRoom->status !== 'available') {
                return redirect()->route('properties.show', $room->property->slug)
                    ->with('error', 'Kamar ini baru saja disewa oleh pengguna lain atau sedang tidak tersedia.');
            }

            $duration = (int) $request->duration_months;
            $startDate = Carbon::parse($request->start_date);
            $endDate = (clone $startDate)->addMonths($duration)->subDay();

            $totalAmount = $lockedRoom->price * $duration;

            // 1. Buat record rental baru status pending
            $rental = Rental::create([
                'tenant_id' => $user->id,
                'room_id' => $lockedRoom->id,
                'start_date' => $startDate->toDateString(),
                'end_date' => $endDate->toDateString(),
                'total_amount' => $totalAmount,
                'status' => 'pending',
            ]);

            // 2. Buat invoice tagihan pembayaran
            $invoiceNumber = 'INV-' . date('Ymd') . '-' . strtoupper(Str::random(5));
            $payment = Payment::create([
                'rental_id' => $rental->id,
                'invoice_number' => $invoiceNumber,
                'amount' => $totalAmount,
                'status' => 'unpaid',
                'snap_token' => 'SNAP-' . Str::random(24),
            ]);

            return redirect()->route('payments.show', $payment->id)
                ->with('success', 'Pemesanan berhasil dibuat! Silakan selesaikan pembayaran untuk mengaktifkan sewa kamar.');
        });
    }

    /**
     * Daftar Riwayat Sewa Tenant
     */
    public function myRentals()
    {
        $user = auth()->user();
        if ($user->role !== 'tenant') {
            abort(403, 'Akses ditolak.');
        }

        $rentals = Rental::where('tenant_id', $user->id)
            ->with(['room.property', 'payments'])
            ->latest()
            ->paginate(10);

        return view('tenant.bookings.index', compact('rentals'));
    }
}
