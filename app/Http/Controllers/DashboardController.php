<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Property;
use App\Models\Room;
use App\Models\Rental;
use App\Models\Payment;
use App\Models\Complaint;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->role === 'landlord') {
            // Data Properti milik Landlord
            $properties = Property::where('landlord_id', $user->id)->with('rooms')->latest()->get();

            // Seluruh Kamar dari semua Properti milik Landlord
            $rooms = Room::whereHas('property', function ($query) use ($user) {
                $query->where('landlord_id', $user->id);
            })->with('property')->latest()->get();

            // Hitung Statistik
            $totalProperties = $properties->count();
            $totalRooms = $rooms->count();
            $occupiedRooms = $rooms->where('status', 'occupied')->count();
            $availableRooms = $rooms->where('status', 'available')->count();
            $maintenanceRooms = $rooms->where('status', 'maintenance')->count();
            $occupancyRate = $totalRooms > 0 ? round(($occupiedRooms / $totalRooms) * 100) : 0;

            // Total Pemasukan Lunas
            $totalRevenue = Payment::where('status', 'paid')
                ->whereHas('rental.room.property', function ($query) use ($user) {
                    $query->where('landlord_id', $user->id);
                })->sum('amount');

            // Tagihan yang Belum Dibayar
            $unpaidCount = Payment::where('status', 'unpaid')
                ->whereHas('rental.room.property', function ($query) use ($user) {
                    $query->where('landlord_id', $user->id);
                })->count();

            // Pengaduan Masuk dari Penyewa
            $complaints = Complaint::whereHas('room.property', function ($query) use ($user) {
                $query->where('landlord_id', $user->id);
            })->with(['tenant', 'room.property'])->latest()->get();

            // Transaksi Sewa Terbaru
            $recentRentals = Rental::whereHas('room.property', function ($query) use ($user) {
                $query->where('landlord_id', $user->id);
            })->with(['tenant', 'room.property', 'payments'])->latest()->take(6)->get();

            return view('landlord.dashboard', compact(
                'properties',
                'rooms',
                'totalProperties',
                'totalRooms',
                'occupiedRooms',
                'availableRooms',
                'maintenanceRooms',
                'occupancyRate',
                'totalRevenue',
                'unpaidCount',
                'complaints',
                'recentRentals'
            ));
        }

        // --- DASHBOARD TENANT ---
        // Kamar aktif yang sedang ditinggali
        $activeRental = Rental::where('tenant_id', $user->id)
            ->where('status', 'active')
            ->with(['room.property.landlord', 'payments'])
            ->latest()
            ->first();

        // Semua riwayat sewa (aktif, pending, selesai)
        $allRentals = Rental::where('tenant_id', $user->id)
            ->with(['room.property', 'payments'])
            ->latest()
            ->get();

        // Riwayat pengaduan yang pernah diajukan
        $complaints = Complaint::where('tenant_id', $user->id)
            ->with(['room.property'])
            ->latest()
            ->get();

        return view('tenant.dashboard', compact('activeRental', 'allRentals', 'complaints'));
    }
}
