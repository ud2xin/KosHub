<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-xl text-slate-900 leading-tight">
                Buat Laporan Pengaduan Fasilitas
            </h2>
            <a href="{{ route('dashboard') }}" class="text-xs font-semibold text-indigo-600 hover:text-indigo-800">
                &larr; Kembali ke Dashboard
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6 sm:p-8">
                
                <!-- Info Kamar Aktif yang Dikomplain -->
                <div class="mb-6 p-4 bg-indigo-50/70 border border-indigo-100 rounded-2xl flex items-center justify-between">
                    <div>
                        <span class="text-[10px] text-indigo-600 font-bold uppercase tracking-wider block">Laporan Ditujukan Untuk :</span>
                        <h4 class="text-base font-bold text-slate-900 mt-0.5">
                            {{ $activeRental->room->property->name }} - Kamar {{ $activeRental->room->room_number }}
                        </h4>
                        <p class="text-xs text-slate-500 mt-0.5">{{ $activeRental->room->property->city }} &bull; Pemilik : {{ $activeRental->room->property->landlord->name }}</p>
                    </div>
                    <span class="px-2.5 py-1 bg-emerald-100 text-emerald-800 rounded-full text-xs font-bold">
                        Sewa Aktif
                    </span>
                </div>

                <form action="{{ route('complaints.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <div>
                        <label for="title" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Judul Pengaduan / Keluhan
                        </label>
                        <input type="text" id="title" name="title" value="{{ old('title') }}" required placeholder="Contoh : Kran air patah / AC tidak dingin / Lampu mati" class="w-full text-sm rounded-xl border-slate-300 focus:ring-indigo-500 focus:border-indigo-500">
                        @error('title') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="description" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Detail Kerusakan & Kronologi
                        </label>
                        <textarea id="description" name="description" rows="4" required placeholder="Jelaskan detail masalah, bagian mana yang rusak, dan sejak kapan terjadi..." class="w-full text-sm rounded-xl border-slate-300 focus:ring-indigo-500 focus:border-indigo-500">{{ old('description') }}</textarea>
                        @error('description') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="photo" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Unggah Foto Bukti Kerusakan (Opsional)
                        </label>
                        <input type="file" id="photo" name="photo" accept="image/*" class="w-full text-sm text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                        @error('photo') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                        <p class="text-[11px] text-slate-400 mt-1">Format gambar JPG, PNG, atau WEBP (Maksimal 3 MB).</p>
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-6 border-t border-slate-100">
                        <a href="{{ route('dashboard') }}" class="px-5 py-2.5 rounded-xl border border-slate-300 text-xs font-semibold text-slate-700 hover:bg-slate-50 transition">
                            Batal
                        </a>
                        <button type="submit" class="px-6 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs shadow-md shadow-indigo-200 transition">
                            Kirimkan Laporan Pengaduan
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
