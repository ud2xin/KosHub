<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\Rental;
use App\Models\Complaint;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->role === 'landlord') {
        // Ambil seluruh kamar dari semua properti milik landlord ini
        $rooms = Room::whereHas('property', function ($query) use ($user) {
        $query->where('landlord_id', $user->id);
        })->with('property')->get();

        // Hitung ringkasan status kamar
        $totalRooms = $rooms->count();
        $occupiedRooms = $rooms->where('status', 'occupied')->count();
        $availableRooms = $rooms->where('status', 'available')->count();

        // Ambil daftar pengaduan yang masuk ke kamar milik landlord
        $complaints = Complaint::whereHas('room.property', function ($query) use ($user) {
        $query->where('landlord_id', $user->id);
        })->with(['tenant', 'room'])->latest()->get();

        return view('landlord.dashboard', compact(
        'rooms',
        'totalRooms',
        'occupiedRooms',
        'availableRooms',
        'complaints'
        ));
        }

        // Jika rolenya Tenant
        $activeRental = Rental::where('tenant_id', $user->id)
        ->where('status', 'active')
        ->with(['room.property', 'payments'])
        ->first();

        $complaints = Complaint::where('tenant_id', $user->id)
        ->with('room')
        ->latest()
        ->get();

        return view('tenant.dashboard', compact('activeRental', 'complaints'));
    }
}
