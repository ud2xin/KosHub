<x-app-layout>
    <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
    Dashboard Penyewa (Tenant)
    </h2>
    </x-slot>

    <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

    <!-- Status Kamar yang Sedang Dihuni -->
    @if($activeRental)
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-indigo-500">
    <h3 class="text-lg font-bold text-gray-800">Unit Kamar Aktif Anda</h3>
    <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
    <div>
    <p class="text-gray-500">Nama Kos:</p>
    <p class="font-semibold text-gray-800 text-base">{{ $activeRental->room->property->name }}</p>
    <p class="text-gray-500 mt-2">Kamar:</p>
    <p class="font-semibold text-gray-800 text-base">{{ $activeRental->room->room_number }} ({{ $activeRental->room->type }})</p>
    </div>
    <div>
    <p class="text-gray-500">Masa Sewa:</p>
    <p class="font-semibold text-gray-800">{{ $activeRental->start_date->format('d M Y') }} s/d {{ $activeRental->end_date->format('d M Y') }}</p>
    <p class="text-gray-500 mt-2">Status Pembayaran:</p>
    <span class="inline-block mt-1 px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs font-bold">LUNAS</span>
    </div>
    </div>
    </div>
    @else
    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-md">
    <p class="text-sm text-yellow-700">
    Anda belum memiliki kamar sewa yang aktif. Silakan pilih unit di menu pencarian kos.
    </p>
    </div>
    @endif

    <!-- Riwayat Pengaduan -->
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
    <div class="flex justify-between items-center mb-4">
    <h3 class="text-lg font-bold text-gray-800">Riwayat Pengaduan Fasilitas</h3>
    @if($activeRental)
    <button class="bg-indigo-600 text-white text-xs px-3 py-2 rounded hover:bg-indigo-700 font-semibold">
    + Buat Pengaduan Baru
    </button>
    @endif
    </div>

    <div class="space-y-3">
    @forelse($complaints as $c)
    <div class="p-3 border rounded-lg bg-gray-50 flex justify-between items-center">
    <div>
    <p class="font-medium text-gray-800">{{ $c->title }}</p>
    <p class="text-xs text-gray-500 mt-1">{{ $c->description }}</p>
    </div>
    <span class="px-2 py-1 bg-yellow-100 text-yellow-800 text-xs font-semibold rounded">
    {{ ucfirst($c->status) }}
    </span>
    </div>
    @empty
    <p class="text-sm text-gray-500">Belum pernah mengajukan pengaduan.</p>
    @endforelse
    </div>
    </div>

    </div>
    </div>
</x-app-layout>
