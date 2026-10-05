<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Property;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class PropertyController extends Controller
{
    /**
     * Halaman Publik Marketplace Pencarian Kos
     */
    public function index(Request $request)
    {
        $query = Property::query()->with(['rooms', 'landlord']);

        // Filter kata kunci (nama kos, kota, alamat)
        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('city', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%");
            });
        }

        // Filter tipe kos (putra, putri, campur)
        if ($request->filled('type') && in_array($request->type, ['putra', 'putri', 'campur'])) {
            $query->where('type', $request->type);
        }

        // Filter kota spesifik
        if ($request->filled('city')) {
            $query->where('city', $request->city);
        }

        // Filter rentang harga kamar
        if ($request->filled('max_price')) {
            $maxPrice = (float) $request->max_price;
            $query->whereHas('rooms', function ($q) use ($maxPrice) {
                $q->where('price', '<=', $maxPrice)->where('status', 'available');
            });
        }

        // Sorting
        if ($request->sort === 'price_asc') {
            $query->withMin('rooms as min_price', 'price')->orderBy('min_price', 'asc');
        } elseif ($request->sort === 'price_desc') {
            $query->withMax('rooms as max_price', 'price')->orderBy('max_price', 'desc');
        } else {
            $query->latest();
        }

        $properties = $query->paginate(9)->withQueryString();

        // Ambil daftar kota unik untuk dropdown filter
        $availableCities = Property::select('city')->distinct()->pluck('city');

        return view('properties.index', compact('properties', 'availableCities'));
    }

    /**
     * Halaman Detail Properti Kos dan Daftar Unit Kamar
     */
    public function show(Property $property)
    {
        $property->load(['rooms', 'landlord']);
        
        $availableRooms = $property->rooms->where('status', 'available');
        $occupiedRooms = $property->rooms->where('status', 'occupied');
        $maintenanceRooms = $property->rooms->where('status', 'maintenance');

        return view('properties.show', compact('property', 'availableRooms', 'occupiedRooms', 'maintenanceRooms'));
    }

    /**
     * Form Tambah Properti Kos Baru (Landlord)
     */
    public function create()
    {
        $user = auth()->user();
        if ($user->role !== 'landlord') {
            abort(403, 'Hanya pemilik kos (landlord) yang dapat menambahkan properti.');
        }

        return view('landlord.properties.create');
    }

    /**
     * Simpan Properti Kos Baru
     */
    public function store(Request $request)
    {
        $user = auth()->user();
        if ($user->role !== 'landlord') {
            abort(403, 'Akses ditolak.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'address' => 'required|string',
            'type' => 'required|in:putra,putri,campur',
            'description' => 'nullable|string',
            'rules' => 'nullable|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
        ]);

        $slugBase = Str::slug($request->name);
        $slug = $slugBase;
        $counter = 1;
        while (Property::where('slug', $slug)->exists()) {
            $slug = $slugBase . '-' . $counter;
            $counter++;
        }

        $thumbnailPath = null;
        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')->store('properties', 'public');
        }

        $property = Property::create([
            'landlord_id' => $user->id,
            'name' => $request->name,
            'slug' => $slug,
            'city' => $request->city,
            'address' => $request->address,
            'type' => $request->type,
            'description' => $request->description,
            'rules' => $request->rules,
            'thumbnail' => $thumbnailPath,
        ]);

        return redirect()->route('dashboard')->with('success', "Properti kos '{$property->name}' berhasil ditambahkan. Silakan tambahkan unit kamar.");
    }

    /**
     * Form Edit Properti Kos (Landlord)
     */
    public function edit(Property $property)
    {
        $user = auth()->user();
        if ($user->role !== 'landlord' || $property->landlord_id !== $user->id) {
            abort(403, 'Akses ditolak.');
        }

        return view('landlord.properties.edit', compact('property'));
    }

    /**
     * Update Data Properti Kos
     */
    public function update(Request $request, Property $property)
    {
        $user = auth()->user();
        if ($user->role !== 'landlord' || $property->landlord_id !== $user->id) {
            abort(403, 'Akses ditolak.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'address' => 'required|string',
            'type' => 'required|in:putra,putri,campur',
            'description' => 'nullable|string',
            'rules' => 'nullable|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
        ]);

        $data = $request->only(['name', 'city', 'address', 'type', 'description', 'rules']);

        if ($request->hasFile('thumbnail')) {
            if ($property->thumbnail && Storage::disk('public')->exists($property->thumbnail)) {
                Storage::disk('public')->delete($property->thumbnail);
            }
            $data['thumbnail'] = $request->file('thumbnail')->store('properties', 'public');
        }

        $property->update($data);

        return redirect()->route('dashboard')->with('success', "Properti '{$property->name}' berhasil diperbarui.");
    }

    /**
     * Hapus Properti Kos
     */
    public function destroy(Property $property)
    {
        $user = auth()->user();
        if ($user->role !== 'landlord' || $property->landlord_id !== $user->id) {
            abort(403, 'Akses ditolak.');
        }

        $propertyName = $property->name;
        $property->delete();

        return redirect()->route('dashboard')->with('success', "Properti '{$propertyName}' beserta seluruh unit kamarnya berhasil dihapus.");
    }
}
