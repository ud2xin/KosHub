<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Complaint;
use App\Models\Rental;


class ComplaintController extends Controller
{
    // Halaman form pengaduan
    public function create()
    {
        $user = auth()->user();

        // Validasi: Pastikan tenant punya sewa aktif
        $activeRental = Rental::where('tenant_id', $user->id)
        ->where('status', 'active')
        ->with('room.property')
        ->first();

        if (!$activeRental) {
        return redirect()->route('dashboard')->with('error', 'Anda belum memiliki kamar sewa aktif untuk membuat pengaduan.');
        }

        return view('tenant.complaints.create', compact('activeRental'));
    }

    // Proses simpan pengaduan
    public function store(Request $request)
    {
        $user = auth()->user();

        $activeRental = Rental::where('tenant_id', $user->id)
        ->where('status', 'active')
        ->firstOrFail();

        $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
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

        return redirect()->route('dashboard')->with('success', 'Pengaduan berhasil dikirim ke pemilik kos.');
    }

    // Aksi Landlord: Update status laporan (misal dari open -> in_progress -> resolved)
    public function updateStatus(Request $request, Complaint $complaint)
    {
        // Pastikan hanya landlord pemilik kos yang bersangkutan yang bisa ubah status
        $landlordId = $complaint->room->property->landlord_id;
        if (auth()->id()!== $landlordId) {
        abort(403, 'Akses ditolak.');
        }

        $request->validate([
        'status' => 'required|in:open,in_progress,resolved',
        ]);

        $complaint->update(['status' => $request->status]);

        return redirect()->route('dashboard')->with('success', 'Status pengaduan berhasil diperbarui.');
    }
}
