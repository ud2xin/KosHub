<x-app-layout>
    <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
    Tambah Unit Kamar Baru
    </h2>
    </x-slot>

    <div class="py-12">
    <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

    <form action="{{ route('rooms.store') }}" method="POST" class="space-y-4">
    @csrf

    <div>
    <label class="block text-sm font-medium text-gray-700">Pilih Properti Kos</label>
    <select name="property_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
    @foreach($properties as $property)
    <option value="{{ $property->id }}">{{ $property->name }} ({{ $property->city }})</option>
    @endforeach
    </select>
    @error('property_id') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
    <label class="block text-sm font-medium text-gray-700">Nomor / Nama Kamar</label>
    <input type="text" name="room_number" required placeholder="Contoh: B-01 / Lantai 2 No. 5" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
    @error('room_number') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
    <label class="block text-sm font-medium text-gray-700">Tipe Kamar</label>
    <input type="text" name="type" required placeholder="Contoh: Standar / Deluxe AC" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
    @error('type') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
    </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
    <label class="block text-sm font-medium text-gray-700">Harga Sewa / Bulan (Rp)</label>
    <input type="number" name="price" required placeholder="Contoh: 1200000" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
    @error('price') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
    <label class="block text-sm font-medium text-gray-700">Status Awal</label>
    <select name="status" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
    <option value="available">Tersedia (Available)</option>
    <option value="occupied">Terisi (Occupied)</option>
    <option value="maintenance">Dalam Perbaikan (Maintenance)</option>
    </select>
    @error('status') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
    </div>
    </div>

    <div>
    <label class="block text-sm font-medium text-gray-700">Fasilitas Kamar</label>
    <textarea name="facilities" rows="3" placeholder="Contoh: Kasur busa, Lemari 2 pintu, Meja kerja, WiFi, Kamar mandi dalam" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm"></textarea>
    @error('facilities') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
    </div>

    <div class="flex justify-end space-x-3 pt-4 border-t">
    <a href="{{ route('dashboard') }}" class="px-4 py-2 border rounded-md text-sm text-gray-600 hover:bg-gray-50">Batal</a>
    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md text-sm font-semibold hover:bg-indigo-700">Simpan Kamar</button>
    </div>
    </form>

    </div>
    </div>
    </div>
</x-app-layout>
