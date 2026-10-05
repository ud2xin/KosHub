<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\Property;

class RoomController extends Controller
{
    // Form tambah kamar
    public function create()
    {
        $user = auth()->user();
        if ($user->role!== 'landlord') {
        abort(403, 'Hanya landlord yang diizinkan mengakses halaman ini.');
        }

        $properties = Property::where('landlord_id', $user->id)->get();
        if ($properties->isEmpty()) {
        return redirect()->route('dashboard')->with('error', 'Anda harus memiliki properti kos terlebih dahulu.');
        }

        return view('landlord.rooms.create', compact('properties'));
    }

    // Simpan kamar baru
    public function store(Request $request)
    {
        $user = auth()->user();
        if ($user->role!== 'landlord') {
        abort(403, 'Hanya landlord yang diizinkan.');
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

        return redirect()->route('dashboard')->with('success', 'Unit kamar berhasil ditambahkan.');
    }

    // Form edit kamar
    public function edit(Room $room)
    {
        $user = auth()->user();
        if ($user->role!== 'landlord' || $room->property->landlord_id!== $user->id) {
        abort(403, 'Akses ditolak.');
        }

        return view('landlord.rooms.edit', compact('room'));
        }

        // Update data kamar
        public function update(Request $request, Room $room)
        {
        $user = auth()->user();
        if ($user->role!== 'landlord' || $room->property->landlord_id!== $user->id) {
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

        return redirect()->route('dashboard')->with('success', 'Data unit kamar berhasil diperbarui.');
    }
}
