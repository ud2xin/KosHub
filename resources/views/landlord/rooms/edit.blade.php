<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-xl text-slate-900 leading-tight">
                Edit Kamar : {{ $room->room_number }} ({{ $room->property->name }})
            </h2>
            <a href="{{ route('dashboard') }}" class="text-xs font-semibold text-indigo-600 hover:text-indigo-800">
                &larr; Kembali ke Dashboard
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6 sm:p-8">
                
                <form action="{{ route('rooms.update', $room->id) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100 flex items-center justify-between text-xs">
                        <div>
                            <span class="text-slate-400 block font-medium">Properti Kos</span>
                            <span class="font-bold text-slate-800 text-sm">{{ $room->property->name }}</span>
                        </div>
                        <span class="px-2.5 py-1 bg-indigo-100 text-indigo-800 rounded-full font-bold">
                            {{ $room->property->city }}
                        </span>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="room_number" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                Nomor / Nama Kamar
                            </label>
                            <input type="text" id="room_number" name="room_number" value="{{ old('room_number', $room->room_number) }}" required class="w-full text-sm rounded-xl border-slate-300 focus:ring-indigo-500 focus:border-indigo-500">
                            @error('room_number') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="type" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                Tipe Kamar
                            </label>
                            <input type="text" id="type" name="type" value="{{ old('type', $room->type) }}" required class="w-full text-sm rounded-xl border-slate-300 focus:ring-indigo-500 focus:border-indigo-500">
                            @error('type') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="price" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                Harga Sewa / Bulan (Rp)
                            </label>
                            <input type="number" id="price" name="price" value="{{ old('price', (int)$room->price) }}" required class="w-full text-sm rounded-xl border-slate-300 focus:ring-indigo-500 focus:border-indigo-500">
                            @error('price') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="status" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                Status Kamar
                            </label>
                            <select id="status" name="status" required class="w-full text-sm rounded-xl border-slate-300 focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="available" {{ old('status', $room->status) === 'available' ? 'selected' : '' }}>Tersedia (Available)</option>
                                <option value="occupied" {{ old('status', $room->status) === 'occupied' ? 'selected' : '' }}>Terisi (Occupied)</option>
                                <option value="maintenance" {{ old('status', $room->status) === 'maintenance' ? 'selected' : '' }}>Dalam Perbaikan (Maintenance)</option>
                            </select>
                            @error('status') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div>
                        <label for="facilities" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Fasilitas Kamar
                        </label>
                        <textarea id="facilities" name="facilities" rows="3" class="w-full text-sm rounded-xl border-slate-300 focus:ring-indigo-500 focus:border-indigo-500">{{ old('facilities', $room->facilities) }}</textarea>
                        @error('facilities') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex items-center justify-between pt-6 border-t border-slate-100">
                        <button type="button" onclick="if(confirm('Yakin ingin menghapus kamar ini?')) { document.getElementById('deleteRoomForm').submit(); }" class="text-xs font-bold text-red-600 hover:text-red-800">
                            Hapus Kamar
                        </button>

                        <div class="flex items-center gap-3">
                            <a href="{{ route('dashboard') }}" class="px-5 py-2.5 rounded-xl border border-slate-300 text-xs font-semibold text-slate-700 hover:bg-slate-50 transition">
                                Batal
                            </a>
                            <button type="submit" class="px-6 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs shadow-md shadow-indigo-200 transition">
                                Simpan Perubahan
                            </button>
                        </div>
                    </div>
                </form>

                <!-- Hidden Delete Form -->
                <form id="deleteRoomForm" action="{{ route('rooms.destroy', $room->id) }}" method="POST" class="hidden">
                    @csrf
                    @method('DELETE')
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
