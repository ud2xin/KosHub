<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <span class="text-xs font-bold uppercase tracking-wider text-amber-600">Panel Kontrol Pemilik Kos</span>
                <h2 class="font-black text-2xl text-slate-900 leading-tight">
                    Dashboard Landlord
                </h2>
            </div>
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('properties.create') }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-bold shadow-sm shadow-indigo-200 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    <span>Tambah Properti Kos</span>
                </a>
                <a href="{{ route('rooms.create') }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-slate-900 hover:bg-slate-800 text-white rounded-xl text-xs font-bold shadow-sm transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                    <span>Tambah Kamar</span>
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <!-- Flash Alerts -->
            @if(session('success'))
                <div class="p-4 bg-emerald-50 border-l-4 border-emerald-500 rounded-2xl text-sm text-emerald-800 font-semibold shadow-sm flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        <span>{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="p-4 bg-red-50 border-l-4 border-red-500 rounded-2xl text-sm text-red-800 font-semibold shadow-sm">
                    {{ session('error') }}
                </div>
            @endif

            <!-- 1. KPI & Statistik Ringkasan -->
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
                <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
                    <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">Total Properti</span>
                    <p class="text-2xl font-black text-slate-900 mt-1">{{ $totalProperties }}</p>
                    <span class="text-[10px] text-slate-400 mt-0.5 block">Lokasi kos aktif</span>
                </div>

                <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
                    <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">Total Kamar</span>
                    <p class="text-2xl font-black text-slate-900 mt-1">{{ $totalRooms }}</p>
                    <span class="text-[10px] text-indigo-600 font-semibold mt-0.5 block">{{ $occupancyRate }}% Okupansi</span>
                </div>

                <div class="bg-white p-5 rounded-2xl border border-emerald-100 bg-emerald-50/20 shadow-sm">
                    <span class="text-[11px] font-bold text-emerald-600 uppercase tracking-wider block">Kamar Terisi</span>
                    <p class="text-2xl font-black text-emerald-700 mt-1">{{ $occupiedRooms }}</p>
                    <span class="text-[10px] text-emerald-600 mt-0.5 block">Sedang disewa</span>
                </div>

                <div class="bg-white p-5 rounded-2xl border border-blue-100 bg-blue-50/20 shadow-sm">
                    <span class="text-[11px] font-bold text-blue-600 uppercase tracking-wider block">Kamar Kosong</span>
                    <p class="text-2xl font-black text-blue-700 mt-1">{{ $availableRooms }}</p>
                    <span class="text-[10px] text-blue-600 mt-0.5 block">Siap disewa</span>
                </div>

                <div class="bg-white p-5 rounded-2xl border border-amber-100 bg-amber-50/20 shadow-sm">
                    <span class="text-[11px] font-bold text-amber-600 uppercase tracking-wider block">Perbaikan</span>
                    <p class="text-2xl font-black text-amber-700 mt-1">{{ $maintenanceRooms }}</p>
                    <span class="text-[10px] text-amber-600 mt-0.5 block">Perlu renovasi</span>
                </div>

                <div class="bg-white p-5 rounded-2xl border border-indigo-100 bg-indigo-50/20 shadow-sm">
                    <span class="text-[11px] font-bold text-indigo-600 uppercase tracking-wider block">Total Masuk</span>
                    <p class="text-lg font-black text-indigo-700 mt-1 leading-snug">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
                    <span class="text-[10px] text-indigo-500 font-semibold mt-0.5 block">Pembayaran lunas</span>
                </div>
            </div>

            <!-- 2. Properti Kos yang Dimiliki -->
            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6 sm:p-8 space-y-4">
                <div class="flex justify-between items-center">
                    <div>
                        <h3 class="text-lg font-bold text-slate-900 tracking-tight">Daftar Properti Kos Anda</h3>
                        <p class="text-xs text-slate-500">Kelola informasi kos, aturan, dan tambah kamar per lokasi</p>
                    </div>
                    <a href="{{ route('properties.create') }}" class="text-xs font-bold text-indigo-600 hover:text-indigo-800">
                        + Tambah Properti Baru
                    </a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                    @forelse($properties as $prop)
                        <div class="p-5 rounded-2xl border border-slate-200 bg-slate-50/60 flex flex-col justify-between hover:bg-slate-50 transition">
                            <div>
                                <div class="flex justify-between items-start">
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider
                                        {{ $prop->type === 'putri' ? 'bg-pink-100 text-pink-700' : ($prop->type === 'putra' ? 'bg-blue-100 text-blue-700' : 'bg-purple-100 text-purple-700') }}">
                                        Kos {{ ucfirst($prop->type) }}
                                    </span>
                                    <span class="text-xs font-bold text-slate-500">{{ $prop->city }}</span>
                                </div>
                                
                                <h4 class="font-bold text-slate-900 text-base mt-2 leading-snug">{{ $prop->name }}</h4>
                                <p class="text-xs text-slate-500 mt-1 line-clamp-1">{{ $prop->address }}</p>

                                <div class="flex items-center gap-3 mt-4 text-xs font-semibold">
                                    <span class="text-slate-600">Total : {{ $prop->rooms->count() }} Kamar</span>
                                    <span class="text-emerald-600">&bull; {{ $prop->rooms->where('status', 'available')->count() }} Kosong</span>
                                </div>
                            </div>

                            <div class="mt-5 pt-3 border-t border-slate-200/70 flex items-center justify-between text-xs font-semibold">
                                <div class="space-x-2">
                                    <a href="{{ route('properties.edit', $prop->id) }}" class="text-indigo-600 hover:text-indigo-800">Edit</a>
                                    <a href="{{ route('properties.show', $prop->slug) }}" target="_blank" class="text-slate-600 hover:text-slate-900">Lihat Web</a>
                                </div>
                                <a href="{{ route('rooms.create', ['property_id' => $prop->id]) }}" class="px-2.5 py-1 bg-indigo-50 text-indigo-700 hover:bg-indigo-600 hover:text-white rounded-lg transition text-[11px] font-bold">
                                    + Tambah Kamar
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full text-center py-8 text-slate-500 text-xs">
                            Anda belum mendaftarkan properti kos. Klik tombol Tambah Properti di atas untuk memulai.
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- 3. Monitoring Seluruh Unit Kamar -->
            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6 sm:p-8 space-y-4">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2">
                    <div>
                        <h3 class="text-lg font-bold text-slate-900 tracking-tight">Status Unit Kamar (Monitoring Realtime)</h3>
                        <p class="text-xs text-slate-500">Pantau ketersediaan kamar, kamar terisi, dan atur pemeliharaan kamar</p>
                    </div>
                    <a href="{{ route('rooms.create') }}" class="px-3 py-1.5 bg-indigo-50 text-indigo-700 hover:bg-indigo-100 rounded-xl text-xs font-bold transition">
                        + Tambah Kamar Baru
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse text-xs">
                        <thead>
                            <tr class="border-b border-slate-200 bg-slate-50/70 text-slate-500 uppercase tracking-wider font-bold">
                                <th class="p-3.5">Properti Kos</th>
                                <th class="p-3.5">No. Kamar</th>
                                <th class="p-3.5">Tipe Kamar</th>
                                <th class="p-3.5">Harga / Bln</th>
                                <th class="p-3.5">Fasilitas</th>
                                <th class="p-3.5">Status Keterisian</th>
                                <th class="p-3.5 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($rooms as $room)
                                <tr class="hover:bg-slate-50/50 transition">
                                    <td class="p-3.5 font-bold text-slate-900">{{ $room->property->name }}</td>
                                    <td class="p-3.5 font-black text-indigo-700">{{ $room->room_number }}</td>
                                    <td class="p-3.5 font-medium text-slate-600">{{ $room->type }}</td>
                                    <td class="p-3.5 font-bold text-slate-800">Rp {{ number_format($room->price, 0, ',', '.') }}</td>
                                    <td class="p-3.5 text-slate-500 max-w-xs truncate">{{ $room->facilities ?: '-' }}</td>
                                    <td class="p-3.5">
                                        @if($room->status === 'available')
                                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-emerald-100 text-emerald-800">
                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>
                                                Tersedia
                                            </span>
                                        @elseif($room->status === 'occupied')
                                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-blue-100 text-blue-800">
                                                Terisi
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-amber-100 text-amber-800">
                                                Perbaikan
                                            </span>
                                        @endif
                                    </td>
                                    <td class="p-3.5 text-center">
                                        <a href="{{ route('rooms.edit', $room->id) }}" class="font-bold text-indigo-600 hover:text-indigo-900 px-2 py-1 rounded hover:bg-indigo-50">
                                            Edit
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="p-6 text-center text-slate-400">Belum ada kamar yang ditambahkan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- 4. Laporan Sewa & Status Pembayaran (Siapa yang Sudah Bayar & Belum) -->
            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6 sm:p-8 space-y-4">
                <div>
                    <h3 class="text-lg font-bold text-slate-900 tracking-tight">Laporan Sewa & Status Pembayaran Penyewa</h3>
                    <p class="text-xs text-slate-500">Pantau transaksi penyewa, status pembayaran lunas atau belum dibayar</p>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse text-xs">
                        <thead>
                            <tr class="border-b border-slate-200 bg-slate-50/70 text-slate-500 uppercase tracking-wider font-bold">
                                <th class="p-3.5">Nama Penyewa</th>
                                <th class="p-3.5">Kamar & Kos</th>
                                <th class="p-3.5">Periode Sewa</th>
                                <th class="p-3.5">Total Tagihan</th>
                                <th class="p-3.5">Status Pembayaran</th>
                                <th class="p-3.5 text-center">Detail Faktur</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($recentRentals as $rental)
                                @php
                                    $payment = $rental->payments->first();
                                @endphp
                                <tr class="hover:bg-slate-50/50 transition">
                                    <td class="p-3.5">
                                        <div class="font-bold text-slate-900">{{ $rental->tenant->name }}</div>
                                        <div class="text-[11px] text-slate-400">{{ $rental->tenant->phone ?: $rental->tenant->email }}</div>
                                    </td>
                                    <td class="p-3.5">
                                        <span class="font-bold text-slate-800">Kamar {{ $rental->room->room_number }}</span>
                                        <span class="block text-[11px] text-slate-500">{{ $rental->room->property->name }}</span>
                                    </td>
                                    <td class="p-3.5 text-slate-600">
                                        {{ $rental->start_date->format('d/m/Y') }} s/d {{ $rental->end_date->format('d/m/Y') }}
                                    </td>
                                    <td class="p-3.5 font-bold text-slate-900">
                                        Rp {{ number_format($rental->total_amount, 0, ',', '.') }}
                                    </td>
                                    <td class="p-3.5">
                                        @if($payment && $payment->status === 'paid')
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-bold bg-emerald-100 text-emerald-800">
                                                <svg class="w-3 h-3 text-emerald-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                                                LUNAS
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-bold bg-amber-100 text-amber-800">
                                                BELUM BAYAR
                                            </span>
                                        @endif
                                    </td>
                                    <td class="p-3.5 text-center">
                                        @if($payment)
                                            <a href="{{ route('payments.show', $payment->id) }}" class="font-bold text-indigo-600 hover:text-indigo-800 underline">
                                                Lihat Faktur
                                            </a>
                                        @else
                                            <span class="text-slate-400">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="p-6 text-center text-slate-400">Belum ada riwayat transaksi sewa penyewa.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- 5. Laporan Tiket Pengaduan Masuk dari Penyewa -->
            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6 sm:p-8 space-y-4">
                <div>
                    <h3 class="text-lg font-bold text-slate-900 tracking-tight">Pengaduan Masuk dari Penyewa</h3>
                    <p class="text-xs text-slate-500">Tiket keluhan dan laporan kerusakan fasilitas dari kamar yang aktif dihuni</p>
                </div>

                <div class="space-y-4">
                    @forelse($complaints as $c)
                        <div class="p-5 border rounded-2xl bg-slate-50/70 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                            <div class="space-y-1">
                                <div class="flex items-center gap-2">
                                    <h4 class="font-bold text-slate-900 text-sm">{{ $c->title }}</h4>
                                    @if($c->photo)
                                        <a href="{{ asset('storage/' . $c->photo) }}" target="_blank" class="text-[10px] font-bold bg-indigo-50 text-indigo-700 px-2 py-0.5 rounded border border-indigo-200">
                                            Lihat Foto Bukti
                                        </a>
                                    @endif
                                </div>
                                <p class="text-xs text-slate-600">{{ $c->description }}</p>
                                <p class="text-[11px] text-slate-400 pt-1">
                                    Penyewa : <strong>{{ $c->tenant->name }}</strong> &bull; Kamar : <strong>{{ $c->room->room_number }}</strong> ({{ $c->room->property->name }}) &bull; Waktu : {{ $c->created_at->format('d M Y, H:i') }} WIB
                                </p>
                            </div>

                            <div class="flex items-center gap-2 shrink-0">
                                <span class="text-xs text-slate-500 font-semibold">Ubah Status :</span>
                                <form action="{{ route('complaints.updateStatus', $c->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <select name="status" onchange="this.form.submit()" class="text-xs rounded-xl border-slate-300 font-bold py-1.5 pl-3 pr-8 focus:ring-indigo-500">
                                        <option value="open" {{ $c->status === 'open' ? 'selected' : '' }}>OPEN (Baru)</option>
                                        <option value="in_progress" {{ $c->status === 'in_progress' ? 'selected' : '' }}>PROSES PENANGANAN</option>
                                        <option value="resolved" {{ $c->status === 'resolved' ? 'selected' : '' }}>SELESAI DITANGANI</option>
                                    </select>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8 text-slate-400 text-xs">
                            Tidak ada pengaduan aktif dari penyewa kamar. Semua fasilitas aman terkendali!
                        </div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
