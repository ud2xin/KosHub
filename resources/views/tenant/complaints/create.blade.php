<x-app-layout>
    <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
    Buat Laporan Pengaduan Fasilitas
    </h2>
    </x-slot>

    <div class="py-12">
    <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

    <div class="mb-6 p-4 bg-indigo-50 border-l-4 border-indigo-500 rounded">
    <p class="text-xs text-gray-500 font-semibold uppercase">Laporan Ditujukan Untuk:</p>
    <p class="text-sm font-bold text-gray-800 mt-1">
    {{ $activeRental->room->property->name }} - Kamar {{ $activeRental->room->room_number }}
    </p>
    </div>

    <form action="{{ route('complaints.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
    @csrf

    <div>
    <label class="block text-sm font-medium text-gray-700">Judul Pengaduan</label>
    <input type="text" name="title" required placeholder="Contoh: Kran air patah / AC tidak dingin" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
    @error('title') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
    <label class="block text-sm font-medium text-gray-700">Detail Masalah</label>
    <textarea name="description" rows="4" required placeholder="Ceritakan detail kerusakan dan sejak kapan terjadi..." class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm"></textarea>
    @error('description') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
    <label class="block text-sm font-medium text-gray-700">Foto Bukti Kerusakan (Opsional)</label>
    <input type="file" name="photo" accept="image/*" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
    @error('photo') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
    </div>

    <div class="flex justify-end space-x-3 pt-4 border-t">
    <a href="{{ route('dashboard') }}" class="px-4 py-2 border rounded-md text-sm text-gray-600 hover:bg-gray-50">Batal</a>
    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md text-sm font-semibold hover:bg-indigo-700">Kirim Laporan</button>
    </div>
    </form>

    </div>
    </div>
    </div>
</x-app-layout>
