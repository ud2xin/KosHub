<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-xl text-slate-900 leading-tight">
                Riwayat Pemesanan & Sewa Kamar
            </h2>
            <a href="{{ route('dashboard') }}" class="text-xs font-semibold text-indigo-600 hover:text-indigo-800">
                &larr; Kembali ke Dashboard
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6 sm:p-8 space-y-4">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse text-xs">
                        <thead>
                            <tr class="border-b border-slate-200 bg-slate-50/70 text-slate-500 uppercase tracking-wider font-bold">
                                <th class="p-3.5">Kos & Kamar</th>
                                <th class="p-3.5">Periode Sewa</th>
                                <th class="p-3.5">Total Biaya</th>
                                <th class="p-3.5">Status Sewa</th>
                                <th class="p-3.5">Status Bayar</th>
                                <th class="p-3.5 text-center">Faktur Pembayaran</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($rentals as $rental)
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
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">
                                                Aktif
                                            </span>
                                        @elseif($rental->status === 'pending')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 text-amber-800">
                                                Menunggu Bayar
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-700">
                                                {{ ucfirst($rental->status) }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="p-3.5">
                                        @if($payment && $payment->status === 'paid')
                                            <span class="text-[11px] font-bold text-emerald-600">Lunas</span>
                                        @else
                                            <span class="text-[11px] font-bold text-amber-600">Belum Bayar</span>
                                        @endif
                                    </td>
                                    <td class="p-3.5 text-center">
                                        @if($payment)
                                            <a href="{{ route('payments.show', $payment->id) }}" class="font-bold text-indigo-600 hover:text-indigo-800 underline">
                                                Buka Faktur
                                            </a>
                                        @else
                                            <span class="text-slate-400">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="p-8 text-center text-slate-400">Belum ada riwayat pemesanan sewa kamar.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $rentals->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
