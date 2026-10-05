<x-app-layout>
    <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
    Edit Unit Kamar {{ $room->room_number }}
    </h2>
    </x-slot>

    <div class="py-12">
    <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

    <form action="{{ route('rooms.update', $room->id) }}" method="POST" class="space-y-4">
    @csrf
    @method('PUT')

    <div class="p-3 bg-gray-50 border rounded text-xs text-gray-500">
    Properti: <strong>{{ $room->property->name }}</strong>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
    <label class="block text-sm font-medium text-gray-700">Nomor / Nama Kamar</label>
    <input type="text" name="room_number" value="{{ old('room_number', $room->room_number) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
    @error('room_number') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
    <label class="block text-sm font-medium text-gray-700">Tipe Kamar</label>
    <input type="text" name="type" value="{{ old('type', $room->type) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
    @error('type') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
    </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
    <label class="block text-sm font-medium text-gray-700">Harga Sewa / Bulan (Rp)</label>
    <input type="number" name="price" value="{{ old('price', (int)$room->price) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
    @error('price') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
    <label class="block text-sm font-medium text-gray-700">Status Kamar</label>
    <select name="status" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
    <option value="available" {{ $room->status === 'available'? 'selected': '' }}>Tersedia (Available)</option>
    <option value="occupied" {{ $room->status === 'occupied'? 'selected': '' }}>Terisi (Occupied)</option>
    <option value="maintenance" {{ $room->status === 'maintenance'? 'selected': '' }}>Dalam Perbaikan (Maintenance)</option>
    </select>
    @error('status') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
    </div>
    </div>

    <div>
    <label class="block text-sm font-medium text-gray-700">Fasilitas Kamar</label>
    <textarea name="facilities" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">{{ old('facilities', $room->facilities) }}</textarea>
    @error('facilities') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
    </div>

    <div class="flex justify-end space-x-3 pt-4 border-t">
    <a href="{{ route('dashboard') }}" class="px-4 py-2 border rounded-md text-sm text-gray-600 hover:bg-gray-50">Batal</a>
    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md text-sm font-semibold hover:bg-indigo-700">Perbarui Kamar</button>
    </div>
    </form>

    </div>
    </div>
    </div>
</x-app-layout>
