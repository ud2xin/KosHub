<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-xl text-slate-900 leading-tight">
                Tambah Unit Kamar Baru
            </h2>
            <a href="{{ route('dashboard') }}" class="text-xs font-semibold text-indigo-600 hover:text-indigo-800">
                &larr; Kembali ke Dashboard
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6 sm:p-8">
                
                <form action="{{ route('rooms.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <div>
                        <label for="property_id" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Pilih Properti Kos
                        </label>
                        <select id="property_id" name="property_id" required class="w-full text-sm rounded-xl border-slate-300 focus:ring-indigo-500 focus:border-indigo-500">
                            @foreach($properties as $prop)
                                <option value="{{ $prop->id }}" {{ (isset($selectedPropertyId) && $selectedPropertyId == $prop->id) ? 'selected' : '' }}>
                                    {{ $prop->name }} ({{ $prop->city }})
                                </option>
                            @endforeach
                        </select>
                        @error('property_id') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="room_number" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                Nomor / Nama Kamar
                            </label>
                            <input type="text" id="room_number" name="room_number" value="{{ old('room_number') }}" required placeholder="Contoh : A-01 / No. 12" class="w-full text-sm rounded-xl border-slate-300 focus:ring-indigo-500 focus:border-indigo-500">
                            @error('room_number') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="type" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                Tipe Kamar
                            </label>
                            <input type="text" id="type" name="type" value="{{ old('type') }}" required placeholder="Contoh : Deluxe AC / Standard / VIP" class="w-full text-sm rounded-xl border-slate-300 focus:ring-indigo-500 focus:border-indigo-500">
                            @error('type') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="price" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                Harga Sewa / Bulan (Rp)
                            </label>
                            <input type="number" id="price" name="price" value="{{ old('price') }}" required placeholder="Contoh : 1500000" class="w-full text-sm rounded-xl border-slate-300 focus:ring-indigo-500 focus:border-indigo-500">
                            @error('price') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="status" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                Status Unit Awal
                            </label>
                            <select id="status" name="status" required class="w-full text-sm rounded-xl border-slate-300 focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="available" {{ old('status') === 'available' ? 'selected' : '' }}>Tersedia (Available)</option>
                                <option value="occupied" {{ old('status') === 'occupied' ? 'selected' : '' }}>Terisi (Occupied)</option>
                                <option value="maintenance" {{ old('status') === 'maintenance' ? 'selected' : '' }}>Dalam Perbaikan (Maintenance)</option>
                            </select>
                            @error('status') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div>
                        <label for="facilities" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Fasilitas Kamar
                        </label>
                        <textarea id="facilities" name="facilities" rows="3" placeholder="Contoh : Kasur springbed, AC, Kamar mandi dalam, Meja belajar, Lemari baju, WiFi..." class="w-full text-sm rounded-xl border-slate-300 focus:ring-indigo-500 focus:border-indigo-500">{{ old('facilities') }}</textarea>
                        @error('facilities') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-6 border-t border-slate-100">
                        <a href="{{ route('dashboard') }}" class="px-5 py-2.5 rounded-xl border border-slate-300 text-xs font-semibold text-slate-700 hover:bg-slate-50 transition">
                            Batal
                        </a>
                        <button type="submit" class="px-6 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs shadow-md shadow-indigo-200 transition">
                            Simpan Kamar Baru
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
