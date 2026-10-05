<x-app-layout>
    <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
    Dashboard Pemilik Kos (Landlord)
    </h2>
    </x-slot>

    <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

    <!-- Kartu Statistik -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-blue-500">
    <p class="text-sm font-medium text-gray-500">Total Unit Kamar</p>
    <p class="text-3xl font-bold text-gray-800 mt-2">{{ $totalRooms }}</p>
    </div>
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-green-500">
    <p class="text-sm font-medium text-gray-500">Kamar Terisi (Occupied)</p>
    <p class="text-3xl font-bold text-gray-800 mt-2">{{ $occupiedRooms }}</p>
    </div>
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-yellow-500">
    <p class="text-sm font-medium text-gray-500">Kamar Kosong (Available)</p>
    <p class="text-3xl font-bold text-gray-800 mt-2">{{ $availableRooms }}</p>
    </div>
    </div>

    <!-- Monitoring Unit Kamar -->
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
        <div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-bold text-gray-800">Daftar Status Unit Kamar</h3>
        <a href="{{ route('rooms.create') }}" class="bg-indigo-600 text-white text-xs px-3 py-2 rounded hover:bg-indigo-700 font-semibold inline-block">
        + Tambah Kamar Baru
        </a>
        </div>

        <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
        <thead>
        <tr class="border-b bg-gray-50 text-sm font-semibold text-gray-600">
        <th class="p-3">Kos</th>
        <th class="p-3">No. Kamar</th>
        <th class="p-3">Tipe</th>
        <th class="p-3">Harga / Bulan</th>
        <th class="p-3">Status</th>
        <th class="p-3 text-center">Aksi</th>
        </tr>
        </thead>
        <tbody class="divide-y text-sm">
        @forelse($rooms as $room)
        <tr>
        <td class="p-3 font-medium">{{ $room->property->name }}</td>
        <td class="p-3">{{ $room->room_number }}</td>
        <td class="p-3">{{ $room->type }}</td>
        <td class="p-3">Rp {{ number_format($room->price, 0, ',', '.') }}</td>
        <td class="p-3">
        @if($room->status === 'available')
        <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs font-semibold">Tersedia</span>
        @elseif($room->status === 'occupied')
        <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-semibold">Terisi</span>
        @else
        <span class="px-2 py-1 bg-gray-100 text-gray-800 rounded-full text-xs font-semibold">Perbaikan</span>
        @endif
        </td>
        <td class="p-3 text-center">
        <a href="{{ route('rooms.edit', $room->id) }}" class="text-indigo-600 hover:text-indigo-900 text-xs font-semibold">
        Edit
        </a>
        </td>
        </tr>
        @empty
        <tr>
        <td colspan="6" class="p-3 text-center text-gray-500">Belum ada unit kamar.</td>
        </tr>
        @endforelse
        </tbody>
        </table>
        </div>
    </div>

    <!-- Laporan Pengaduan Masuk -->
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
    <h3 class="text-lg font-bold text-gray-800 mb-4">Pengaduan Masuk dari Penyewa</h3>
    <div class="space-y-4">

    @forelse($complaints as $c)
    <div class="p-4 border rounded-lg bg-gray-50 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
    <div>
        <h4 class="font-semibold text-gray-800">{{ $c->title }}</h4>
        <p class="text-sm text-gray-600 mt-1">{{ $c->description }}</p>
        <p class="text-xs text-gray-400 mt-2">
            Dari: {{ $c->tenant->name }} | Kamar: {{ $c->room->room_number }} ({{ $c->room->property->name }})
        </p>
    </div>

    <div class="flex items-center space-x-2">
        <form action="{{ route('complaints.updateStatus', $c->id) }}" method="POST" class="inline">
        @csrf
        @method('PATCH')
        <select name="status" onchange="this.form.submit()" class="text-xs rounded-md border-gray-300 font-semibold">
        <option value="open" {{ $c->status === 'open'? 'selected': '' }}>OPEN (Baru)</option>
        <option value="in_progress" {{ $c->status === 'in_progress'? 'selected': '' }}>PROSES</option>
        <option value="resolved" {{ $c->status === 'resolved'? 'selected': '' }}>SELESAI</option>
        </select>
        </form>
        </div>
    </div>
    @endforelse
    </div>
    </div>

    </div>
    </div>
</x-app-layout>
