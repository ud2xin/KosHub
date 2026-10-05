<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-xl text-slate-900 leading-tight">
                Laporan Keuangan & Rekap Pembayaran Sewa
            </h2>
            <a href="{{ route('dashboard') }}" class="text-xs font-semibold text-indigo-600 hover:text-indigo-800">
                &larr; Kembali ke Dashboard
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Ringkasan Finansial -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm flex items-center justify-between">
                    <div>
                        <span class="text-xs font-bold uppercase tracking-wider text-emerald-600">Total Pemasukan Lunas</span>
                        <h3 class="text-3xl font-black text-slate-900 mt-1">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
                        <p class="text-xs text-slate-400 mt-0.5">Dari transaksi sewa yang telah dibayarkan penyewa</p>
                    </div>
                    <div class="w-12 h-12 bg-emerald-100 text-emerald-700 rounded-2xl flex items-center justify-center font-bold">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm flex items-center justify-between">
                    <div>
                        <span class="text-xs font-bold uppercase tracking-wider text-amber-600">Total Tagihan Tertunda (Unpaid)</span>
                        <h3 class="text-3xl font-black text-slate-900 mt-1">Rp {{ number_format($pendingAmount, 0, ',', '.') }}</h3>
                        <p class="text-xs text-slate-400 mt-0.5">Menunggu konfirmasi atau penyelesaian pembayaran</p>
                    </div>
                    <div class="w-12 h-12 bg-amber-100 text-amber-700 rounded-2xl flex items-center justify-center font-bold">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </div>
            </div>

            <!-- Tabel Transaksi Lengkap -->
            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6 sm:p-8 space-y-4">
                <h3 class="text-lg font-bold text-slate-900 tracking-tight">Daftar Seluruh Faktur & Tagihan</h3>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse text-xs">
                        <thead>
                            <tr class="border-b border-slate-200 bg-slate-50/70 text-slate-500 uppercase tracking-wider font-bold">
                                <th class="p-3.5">No. Invoice</th>
                                <th class="p-3.5">Nama Penyewa</th>
                                <th class="p-3.5">Unit Kos</th>
                                <th class="p-3.5">Kanal Bayar</th>
                                <th class="p-3.5">Jumlah (Rp)</th>
                                <th class="p-3.5">Status</th>
                                <th class="p-3.5 text-center">Faktur</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($payments as $p)
                                <tr class="hover:bg-slate-50/50 transition">
                                    <td class="p-3.5 font-mono font-bold text-indigo-700">{{ $p->invoice_number }}</td>
                                    <td class="p-3.5 font-bold text-slate-800">{{ $p->rental->tenant->name }}</td>
                                    <td class="p-3.5 text-slate-600">
                                        {{ $p->rental->room->property->name }} - Kamar {{ $p->rental->room->room_number }}
                                    </td>
                                    <td class="p-3.5 text-slate-500">{{ $p->payment_channel ?: 'Belum Dipilih' }}</td>
                                    <td class="p-3.5 font-bold text-slate-900">Rp {{ number_format($p->amount, 0, ',', '.') }}</td>
                                    <td class="p-3.5">
                                        @if($p->status === 'paid')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">
                                                Lunas
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 text-amber-800">
                                                Menunggu Bayar
                                            </span>
                                        @endif
                                    </td>
                                    <td class="p-3.5 text-center">
                                        <a href="{{ route('payments.show', $p->id) }}" class="font-bold text-indigo-600 hover:text-indigo-800 underline">
                                            Buka Faktur
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="p-8 text-center text-slate-400">Belum ada data transaksi pembayaran.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $payments->links() }}
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
