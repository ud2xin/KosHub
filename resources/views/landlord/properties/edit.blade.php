<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-xl text-slate-900 leading-tight">
                Edit Properti : {{ $property->name }}
            </h2>
            <a href="{{ route('dashboard') }}" class="text-xs font-semibold text-indigo-600 hover:text-indigo-800">
                &larr; Kembali ke Dashboard
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6 sm:p-8">
                
                <form action="{{ route('properties.update', $property->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="name" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Nama Properti Kos
                        </label>
                        <input type="text" id="name" name="name" value="{{ old('name', $property->name) }}" required class="w-full text-sm rounded-xl border-slate-300 focus:ring-indigo-500 focus:border-indigo-500">
                        @error('name') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="city" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                Kota / Kabupaten
                            </label>
                            <input type="text" id="city" name="city" value="{{ old('city', $property->city) }}" required class="w-full text-sm rounded-xl border-slate-300 focus:ring-indigo-500 focus:border-indigo-500">
                            @error('city') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="type" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                Tipe Penghuni Kos
                            </label>
                            <select id="type" name="type" required class="w-full text-sm rounded-xl border-slate-300 focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="putri" {{ old('type', $property->type) === 'putri' ? 'selected' : '' }}>Khusus Putri</option>
                                <option value="putra" {{ old('type', $property->type) === 'putra' ? 'selected' : '' }}>Khusus Putra</option>
                                <option value="campur" {{ old('type', $property->type) === 'campur' ? 'selected' : '' }}>Kos Campur</option>
                            </select>
                            @error('type') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div>
                        <label for="address" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Alamat Lengkap Properti
                        </label>
                        <textarea id="address" name="address" rows="2" required class="w-full text-sm rounded-xl border-slate-300 focus:ring-indigo-500 focus:border-indigo-500">{{ old('address', $property->address) }}</textarea>
                        @error('address') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="description" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Deskripsi Properti Kos
                        </label>
                        <textarea id="description" name="description" rows="3" class="w-full text-sm rounded-xl border-slate-300 focus:ring-indigo-500 focus:border-indigo-500">{{ old('description', $property->description) }}</textarea>
                        @error('description') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="rules" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Tata Tertib & Peraturan Kos
                        </label>
                        <textarea id="rules" name="rules" rows="3" class="w-full text-sm rounded-xl border-slate-300 focus:ring-indigo-500 focus:border-indigo-500">{{ old('rules', $property->rules) }}</textarea>
                        @error('rules') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="thumbnail" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Ganti Foto / Thumbnail Properti (Opsional)
                        </label>
                        @if($property->thumbnail)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $property->thumbnail) }}" alt="{{ $property->name }}" class="w-32 h-20 object-cover rounded-xl border">
                            </div>
                        @endif
                        <input type="file" id="thumbnail" name="thumbnail" accept="image/*" class="w-full text-sm text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                        @error('thumbnail') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-6 border-t border-slate-100">
                        <a href="{{ route('dashboard') }}" class="px-5 py-2.5 rounded-xl border border-slate-300 text-xs font-semibold text-slate-700 hover:bg-slate-50 transition">
                            Batal
                        </a>
                        <button type="submit" class="px-6 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs shadow-md shadow-indigo-200 transition">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
