<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Complaint;
use App\Models\Rental;
use Illuminate\Support\Facades\Storage;

class ComplaintController extends Controller
{
    /**
     * Form Pengaduan Fasilitas untuk Tenant
     */
    public function create()
    {
        $user = auth()->user();

        if ($user->role !== 'tenant') {
            return redirect()->route('dashboard')->with('error', 'Hanya penyewa yang dapat membuat pengaduan.');
        }

        // Validasi : Pastikan tenant punya sewa aktif
        $activeRental = Rental::where('tenant_id', $user->id)
            ->where('status', 'active')
            ->with(['room.property'])
            ->first();

        if (!$activeRental) {
            return redirect()->route('dashboard')->with('error', 'Anda harus memiliki kontrak sewa kamar yang aktif untuk membuat laporan pengaduan.');
        }

        return view('tenant.complaints.create', compact('activeRental'));
    }

    /**
     * Simpan Pengaduan Baru
     */
    public function store(Request $request)
    {
        $user = auth()->user();

        if ($user->role !== 'tenant') {
            abort(403, 'Akses ditolak.');
        }

        $activeRental = Rental::where('tenant_id', $user->id)
            ->where('status', 'active')
            ->first();

        if (!$activeRental) {
            return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki sewa aktif.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('complaints', 'public');
        }

        Complaint::create([
            'rental_id' => $activeRental->id,
            'room_id' => $activeRental->room_id,
            'tenant_id' => $user->id,
            'title' => $request->title,
            'description' => $request->description,
            'photo' => $photoPath,
            'status' => 'open',
        ]);

        return redirect()->route('dashboard')->with('success', 'Laporan pengaduan Anda berhasil dikirim ke pemilik kos. Pemilik akan segera menindaklanjuti.');
    }

    /**
     * Landlord Update Status Pengaduan (open, in_progress, resolved)
     */
    public function updateStatus(Request $request, Complaint $complaint)
    {
        $user = auth()->user();
        
        // Verifikasi kepemilikan kos oleh landlord
        $landlordId = $complaint->room->property->landlord_id;
        if ($user->id !== $landlordId) {
            abort(403, 'Akses ditolak. Anda bukan pemilik properti kos ini.');
        }

        $request->validate([
            'status' => 'required|in:open,in_progress,resolved',
        ]);

        $complaint->update([
            'status' => $request->status,
        ]);

        $statusLabel = [
            'open' => 'Baru (Open)',
            'in_progress' => 'Sedang Diproses',
            'resolved' => 'Selesai (Resolved)'
        ][$request->status] ?? $request->status;

        return redirect()->route('dashboard')->with('success', "Status pengaduan '{$complaint->title}' berhasil diubah menjadi: {$statusLabel}.");
    }
}
