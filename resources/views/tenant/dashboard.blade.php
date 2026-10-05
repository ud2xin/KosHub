<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <span class="text-xs font-bold uppercase tracking-wider text-indigo-600">Panel Penghuni & Penyewa</span>
                <h2 class="font-black text-2xl text-slate-900 leading-tight">
                    Dashboard Penyewa
                </h2>
            </div>
            <a href="{{ route('home') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-bold shadow-sm shadow-indigo-200 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                <span>Cari / Jelajahi Unit Kos Lain</span>
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <!-- Flash Alerts -->
            @if(session('success'))
                <div class="p-4 bg-emerald-50 border-l-4 border-emerald-500 rounded-2xl text-sm text-emerald-800 font-semibold shadow-sm flex items-center gap-3">
                    <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="p-4 bg-red-50 border-l-4 border-red-500 rounded-2xl text-sm text-red-800 font-semibold shadow-sm">
                    {{ session('error') }}
                </div>
            @endif

            <!-- 1. Banner Kamar Aktif yang Sedang Dihuni -->
            @if($activeRental)
                <div class="bg-gradient-to-br from-indigo-900 via-slate-900 to-indigo-950 text-white rounded-3xl p-6 sm:p-8 shadow-xl relative overflow-hidden">
                    <div class="absolute -right-10 -bottom-10 w-64 h-64 bg-indigo-500/10 rounded-full blur-2xl"></div>

                    <div class="relative flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                        <div class="space-y-3">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-500/90 text-white shadow-sm">
                                <span class="w-2 h-2 rounded-full bg-white animate-pulse"></span>
                                KAMAR AKTIF SAAT INI
                            </span>
                            
                            <div>
                                <h3 class="text-3xl font-black tracking-tight text-white">
                                    Kamar {{ $activeRental->room->room_number }}
                                </h3>
                                <p class="text-indigo-200 text-sm font-semibold mt-1">
                                    {{ $activeRental->room->property->name }} &bull; {{ $activeRental->room->property->city }}
                                </p>
                                <p class="text-xs text-slate-300 mt-0.5">
                                    {{ $activeRental->room->property->address }}
                                </p>
                            </div>

                            <div class="flex flex-wrap gap-4 pt-2 text-xs text-indigo-100">
                                <div class="bg-white/10 px-3 py-1.5 rounded-xl backdrop-blur">
                                    <span class="text-indigo-300 block text-[10px] uppercase font-semibold">Tipe Unit :</span>
                                    <span class="font-bold">{{ $activeRental->room->type }}</span>
                                </div>
                                <div class="bg-white/10 px-3 py-1.5 rounded-xl backdrop-blur">
                                    <span class="text-indigo-300 block text-[10px] uppercase font-semibold">Periode Sewa :</span>
                                    <span class="font-bold">{{ $activeRental->start_date->format('d M Y') }} - {{ $activeRental->end_date->format('d M Y') }}</span>
                                </div>
                                <div class="bg-white/10 px-3 py-1.5 rounded-xl backdrop-blur">
                                    <span class="text-indigo-300 block text-[10px] uppercase font-semibold">Pemilik Kos :</span>
                                    <span class="font-bold">{{ $activeRental->room->property->landlord->name }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons di Kartu Aktif -->
                        <div class="flex flex-col sm:flex-row md:flex-col gap-3 w-full md:w-auto shrink-0">
                            <a href="{{ route('complaints.create') }}" class="px-5 py-2.5 rounded-xl bg-indigo-500 hover:bg-indigo-600 text-white text-xs font-bold text-center transition flex items-center justify-center gap-1.5 shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                <span>Buat Laporan Pengaduan</span>
                            </a>

                            @if($activeRental->payments->first())
                                <a href="{{ route('payments.show', $activeRental->payments->first()->id) }}" class="px-5 py-2.5 rounded-xl bg-white/10 hover:bg-white/20 text-white text-xs font-bold text-center transition border border-white/20">
                                    Lihat Faktur Pembayaran
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @else
                <div class="bg-white rounded-3xl border border-dashed border-slate-300 p-8 text-center space-y-4 shadow-sm">
                    <div class="w-14 h-14 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center mx-auto">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-slate-900">Anda Belum Memiliki Kamar Sewa Aktif</h3>
                        <p class="text-xs text-slate-500 max-w-md mx-auto mt-1">
                            Pilih kos idaman Anda di katalog kami, lakukan booking dan pembayaran secara instan untuk mulai menempati kamar.
                        </p>
                    </div>
                    <a href="{{ route('home') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold shadow-md shadow-indigo-200 transition">
                        <span>Pilih Unit Kamar Kos Sekarang</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                </div>
            @endif

            <!-- 2. Riwayat Pemesanan & Pembayaran Sewa -->
            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6 sm:p-8 space-y-4">
                <div class="flex justify-between items-center">
                    <div>
                        <h3 class="text-lg font-bold text-slate-900 tracking-tight">Riwayat Sewa & Tagihan Anda</h3>
                        <p class="text-xs text-slate-500">Daftar pemesanan kamar yang pernah Anda lakukan</p>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse text-xs">
                        <thead>
                            <tr class="border-b border-slate-200 bg-slate-50/70 text-slate-500 uppercase tracking-wider font-bold">
                                <th class="p-3.5">Kos & Kamar</th>
                                <th class="p-3.5">Periode Sewa</th>
                                <th class="p-3.5">Total Biaya</th>
                                <th class="p-3.5">Status Sewa</th>
                                <th class="p-3.5">Status Bayar</th>
                                <th class="p-3.5 text-center">Aksi / Faktur</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($allRentals as $rental)
                                @php
                                    $payment = $rental->payments->first();
                                @endphp
                                <tr class="hover:bg-slate-50/50 transition">
                                    <td class="p-3.5">
                                        <div class="font-bold text-slate-900">Kamar {{ $rental->room->room_number }} ({{ $rental->room->type }})</div>
                                        <div class="text-[11px] text-slate-500">{{ $rental->room->property->name }} - {{ $rental->room->property->city }}</div>
                                    </td>
                                    <td class="p-3.5 text-slate-600">
                                        {{ $rental->start_date->format('d/m/Y') }} s/d {{ $rental->end_date->format('d/m/Y') }}
                                    </td>
                                    <td class="p-3.5 font-bold text-slate-900">
                                        Rp {{ number_format($rental->total_amount, 0, ',', '.') }}
                                    </td>
                                    <td class="p-3.5">
                                        @if($rental->status === 'active')
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">
                                                Aktif
                                            </span>
                                        @elseif($rental->status === 'pending')
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 text-amber-800">
                                                Menunggu Bayar
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-700">
                                                {{ ucfirst($rental->status) }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="p-3.5">
                                        @if($payment && $payment->status === 'paid')
                                            <span class="inline-flex items-center gap-1 text-[11px] font-bold text-emerald-600">
                                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                                                Lunas
                                            </span>
                                        @else
                                            <span class="text-[11px] font-bold text-amber-600">
                                                Belum Lunas
                                            </span>
                                        @endif
                                    </td>
                                    <td class="p-3.5 text-center">
                                        @if($payment)
                                            @if($payment->status === 'paid')
                                                <a href="{{ route('payments.show', $payment->id) }}" class="font-bold text-indigo-600 hover:text-indigo-800 underline">
                                                    Lihat Faktur
                                                </a>
                                            @else
                                                <a href="{{ route('payments.show', $payment->id) }}" class="inline-block px-3 py-1 bg-amber-500 hover:bg-amber-600 text-white rounded-lg font-bold text-[11px] shadow-sm">
                                                    Bayar Sekarang
                                                </a>
                                            @endif
                                        @else
                                            <span class="text-slate-400">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="p-6 text-center text-slate-400">Belum ada transaksi sewa.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- 3. Riwayat Pengaduan Fasilitas Kamar -->
            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6 sm:p-8 space-y-4">
                <div class="flex justify-between items-center">
                    <div>
                        <h3 class="text-lg font-bold text-slate-900 tracking-tight">Riwayat Pengaduan Fasilitas</h3>
                        <p class="text-xs text-slate-500">Daftar laporan keluhan dan kerusakan yang pernah Anda kirimkan ke pemilik kos</p>
                    </div>

                    @if($activeRental)
                        <a href="{{ route('complaints.create') }}" class="px-3.5 py-1.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-bold shadow-sm transition">
                            + Buat Pengaduan Baru
                        </a>
                    @endif
                </div>

                <div class="space-y-3">
                    @forelse($complaints as $c)
                        <div class="p-4 rounded-2xl border border-slate-200 bg-slate-50/60 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
                            <div>
                                <div class="flex items-center gap-2">
                                    <h4 class="font-bold text-slate-900 text-sm">{{ $c->title }}</h4>
                                    @if($c->photo)
                                        <a href="{{ asset('storage/' . $c->photo) }}" target="_blank" class="text-[10px] font-bold text-indigo-600 underline">
                                            [Foto Terlampir]
                                        </a>
                                    @endif
                                </div>
                                <p class="text-xs text-slate-600 mt-0.5">{{ $c->description }}</p>
                                <p class="text-[11px] text-slate-400 mt-1">
                                    Kamar : {{ $c->room->room_number }} ({{ $c->room->property->name }}) &bull; Diajukan : {{ $c->created_at->format('d M Y, H:i') }} WIB
                                </p>
                            </div>

                            <div>
                                @if($c->status === 'open')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-800">
                                        Sedang Divalidasi
                                    </span>
                                @elseif($c->status === 'in_progress')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-800">
                                        Sedang Dikerjakan
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800">
                                        Selesai Diperbaiki
                                    </span>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-6 text-slate-400 text-xs">
                            Belum pernah membuat laporan pengaduan fasilitas.
                        </div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
