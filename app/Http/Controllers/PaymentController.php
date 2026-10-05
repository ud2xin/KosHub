<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Rental;
use App\Models\Room;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    /**
     * Halaman Rincian Invoice & Pembayaran
     */
    public function show(Payment $payment)
    {
        $user = auth()->user();
        $rental = $payment->rental->load(['room.property.landlord', 'tenant']);

        // Verifikasi hak akses (Tenant pemilik sewa ATAU Landlord pemilik kos)
        $isTenantOwner = ($user->id === $rental->tenant_id);
        $isLandlordOwner = ($user->id === $rental->room->property->landlord_id);

        if (!$isTenantOwner && !$isLandlordOwner) {
            abort(403, 'Anda tidak memiliki hak akses untuk melihat tagihan ini.');
        }

        return view('payments.show', compact('payment', 'rental', 'isTenantOwner', 'isLandlordOwner'));
    }

    /**
     * Simulasi Pembayaran Berhasil (Realtime)
     */
    public function pay(Request $request, Payment $payment)
    {
        $user = auth()->user();
        $rental = $payment->rental;

        if ($user->id !== $rental->tenant_id) {
            abort(403, 'Akses ditolak.');
        }

        if ($payment->status === 'paid') {
            return redirect()->route('payments.show', $payment->id)
                ->with('info', 'Tagihan ini sudah lunas sebelumnya.');
        }

        $request->validate([
            'payment_channel' => 'required|string|max:50',
        ]);

        DB::transaction(function () use ($payment, $rental, $request) {
            // 1. Tandai pembayaran lunas
            $payment->update([
                'status' => 'paid',
                'payment_channel' => $request->payment_channel,
                'paid_at' => now(),
            ]);

            // 2. Aktifkan kontrak sewa
            $rental->update([
                'status' => 'active',
            ]);

            // 3. Ubah status kamar menjadi terisi (occupied)
            $rental->room->update([
                'status' => 'occupied',
            ]);
        });

        return redirect()->route('payments.show', $payment->id)
            ->with('success', 'Selamat! Pembayaran berhasil diverifikasi. Status kamar Anda kini aktif dan siap ditempati.');
    }

    /**
     * Laporan Transaksi Sewa & Keuangan untuk Landlord
     */
    public function landlordReports()
    {
        $user = auth()->user();
        if ($user->role !== 'landlord') {
            abort(403, 'Akses ditolak.');
        }

        $payments = Payment::whereHas('rental.room.property', function ($query) use ($user) {
            $query->where('landlord_id', $user->id);
        })->with(['rental.tenant', 'rental.room.property'])
          ->latest()
          ->paginate(15);

        $totalRevenue = Payment::where('status', 'paid')
            ->whereHas('rental.room.property', function ($query) use ($user) {
                $query->where('landlord_id', $user->id);
            })->sum('amount');

        $pendingAmount = Payment::where('status', 'unpaid')
            ->whereHas('rental.room.property', function ($query) use ($user) {
                $query->where('landlord_id', $user->id);
            })->sum('amount');

        return view('landlord.reports.index', compact('payments', 'totalRevenue', 'pendingAmount'));
    }
}
