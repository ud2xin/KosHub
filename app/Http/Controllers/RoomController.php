<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\Property;

class RoomController extends Controller
{
    /**
     * Form Tambah Unit Kamar Baru (Landlord)
     */
    public function create(Request $request)
    {
        $user = auth()->user();
        if ($user->role !== 'landlord') {
            abort(403, 'Hanya pemilik kos yang dapat menambah unit kamar.');
        }

        $properties = Property::where('landlord_id', $user->id)->get();
        if ($properties->isEmpty()) {
            return redirect()->route('properties.create')->with('error', 'Anda harus membuat data properti kos terlebih dahulu sebelum menambah kamar.');
        }

        $selectedPropertyId = $request->query('property_id');

        return view('landlord.rooms.create', compact('properties', 'selectedPropertyId'));
    }

    /**
     * Simpan Unit Kamar Baru
     */
    public function store(Request $request)
    {
        $user = auth()->user();
        if ($user->role !== 'landlord') {
            abort(403, 'Akses ditolak.');
        }

        $request->validate([
            'property_id' => 'required|exists:properties,id',
            'room_number' => 'required|string|max:50',
            'type' => 'required|string|max:100',
            'price' => 'required|numeric|min:0',
            'facilities' => 'nullable|string',
            'status' => 'required|in:available,occupied,maintenance',
        ]);

        // Pastikan properti benar-benar milik landlord yang sedang login
        $property = Property::where('id', $request->property_id)
            ->where('landlord_id', $user->id)
            ->firstOrFail();

        Room::create([
            'property_id' => $property->id,
            'room_number' => $request->room_number,
            'type' => $request->type,
            'price' => $request->price,
            'facilities' => $request->facilities,
            'status' => $request->status,
        ]);

        return redirect()->route('dashboard')->with('success', "Unit kamar {$request->room_number} berhasil ditambahkan ke kos {$property->name}.");
    }

    /**
     * Form Edit Unit Kamar
     */
    public function edit(Room $room)
    {
        $user = auth()->user();
        if ($user->role !== 'landlord' || $room->property->landlord_id !== $user->id) {
            abort(403, 'Akses ditolak.');
        }

        return view('landlord.rooms.edit', compact('room'));
    }

    /**
     * Update Data Unit Kamar
     */
    public function update(Request $request, Room $room)
    {
        $user = auth()->user();
        if ($user->role !== 'landlord' || $room->property->landlord_id !== $user->id) {
            abort(403, 'Akses ditolak.');
        }

        $request->validate([
            'room_number' => 'required|string|max:50',
            'type' => 'required|string|max:100',
            'price' => 'required|numeric|min:0',
            'facilities' => 'nullable|string',
            'status' => 'required|in:available,occupied,maintenance',
        ]);

        $room->update($request->only(['room_number', 'type', 'price', 'facilities', 'status']));

        return redirect()->route('dashboard')->with('success', "Data kamar {$room->room_number} berhasil diperbarui.");
    }

    /**
     * Hapus Unit Kamar
     */
    public function destroy(Room $room)
    {
        $user = auth()->user();
        if ($user->role !== 'landlord' || $room->property->landlord_id !== $user->id) {
            abort(403, 'Akses ditolak.');
        }

        $roomNumber = $room->room_number;
        $room->delete();

        return redirect()->route('dashboard')->with('success', "Unit kamar {$roomNumber} berhasil dihapus.");
    }
}
