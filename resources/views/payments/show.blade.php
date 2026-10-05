<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-xl text-slate-900 leading-tight">
                Faktur Pembayaran (Invoice)
            </h2>
            <a href="{{ route('dashboard') }}" class="text-xs font-semibold text-indigo-600 hover:text-indigo-800">
                &larr; Kembali ke Dashboard
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Flash Alert -->
            @if(session('success'))
                <div class="p-4 bg-emerald-50 border-l-4 border-emerald-500 rounded-2xl text-sm text-emerald-800 font-semibold shadow-sm flex items-center gap-3">
                    <svg class="w-6 h-6 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if(session('info'))
                <div class="p-4 bg-blue-50 border-l-4 border-blue-500 rounded-2xl text-sm text-blue-800 font-semibold shadow-sm">
                    {{ session('info') }}
                </div>
            @endif

            <!-- Invoice Card -->
            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden" id="printableInvoice">
                
                <!-- Invoice Header Bar -->
                <div class="bg-slate-900 text-white p-6 sm:p-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="w-7 h-7 rounded-lg bg-indigo-500 flex items-center justify-center font-black text-xs text-white">K</span>
                            <span class="font-extrabold text-lg tracking-tight">KosHub Invoicing</span>
                        </div>
                        <h1 class="text-2xl font-black mt-2 tracking-tight">{{ $payment->invoice_number }}</h1>
                        <p class="text-xs text-slate-400 mt-0.5">Diterbitkan pada : {{ $payment->created_at->format('d M Y, H:i') }} WIB</p>
                    </div>

                    <div class="text-left sm:text-right">
                        <span class="text-xs text-slate-400 block uppercase font-bold tracking-wider mb-1">Status Pembayaran</span>
                        @if($payment->status === 'paid')
                            <span class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full text-xs font-black bg-emerald-500 text-white shadow-lg shadow-emerald-900/40">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                SUDAH LUNAS
                            </span>
                            <span class="block text-[11px] text-emerald-300 mt-1">
                                {{ $payment->paid_at ? $payment->paid_at->format('d M Y, H:i') . ' WIB' : 'Lunas' }}
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full text-xs font-black bg-amber-500 text-white shadow-lg shadow-amber-900/40">
                                MENUNGGU PEMBAYARAN
                            </span>
                            <span class="block text-[11px] text-amber-300 mt-1">Harap segera selesaikan</span>
                        @endif
                    </div>
                </div>

                <!-- Invoice Details -->
                <div class="p-6 sm:p-8 space-y-6">
                    <!-- Dua Kolom: Identitas Penyewa & Unit Kos -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 pb-6 border-b border-slate-100 text-xs">
                        <div>
                            <span class="font-bold text-slate-400 uppercase tracking-wider block mb-1">Data Penyewa</span>
                            <h4 class="text-base font-bold text-slate-900">{{ $rental->tenant->name }}</h4>
                            <p class="text-slate-600 mt-0.5">{{ $rental->tenant->email }}</p>
                            <p class="text-slate-600">No. Kontak : {{ $rental->tenant->phone ?: '-' }}</p>
                        </div>

                        <div>
                            <span class="font-bold text-slate-400 uppercase tracking-wider block mb-1">Tujuan Pembayaran</span>
                            <h4 class="text-base font-bold text-slate-900">{{ $rental->room->property->name }}</h4>
                            <p class="text-slate-600 mt-0.5">Kamar : <strong>{{ $rental->room->room_number }}</strong> ({{ $rental->room->type }})</p>
                            <p class="text-slate-600">Lokasi : {{ $rental->room->property->address }}, {{ $rental->room->property->city }}</p>
                            <p class="text-slate-600">Pemilik Kos : {{ $rental->room->property->landlord->name }}</p>
                        </div>
                    </div>

                    <!-- Tabel Item Biaya -->
                    <div>
                        <table class="w-full text-left text-xs border-collapse">
                            <thead>
                                <tr class="border-b border-slate-200 text-slate-400 uppercase tracking-wider">
                                    <th class="py-2.5">Deskripsi Transaksi</th>
                                    <th class="py-2.5 text-center">Periode Sewa</th>
                                    <th class="py-2.5 text-right">Jumlah</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 text-slate-700">
                                <tr>
                                    <td class="py-3 font-semibold text-slate-900">
                                        Sewa Unit Kamar {{ $rental->room->room_number }} - {{ $rental->room->property->name }}
                                        <span class="block text-[11px] font-normal text-slate-500 mt-0.5">Termasuk seluruh fasilitas kamar dan akses kos</span>
                                    </td>
                                    <td class="py-3 text-center">
                                        {{ $rental->start_date->format('d/m/Y') }} s/d {{ $rental->end_date->format('d/m/Y') }}
                                    </td>
                                    <td class="py-3 text-right font-bold text-slate-900">
                                        Rp {{ number_format($payment->amount, 0, ',', '.') }}
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr class="border-t-2 border-slate-200">
                                    <td colspan="2" class="py-4 text-sm font-bold text-slate-900">Total Tagihan Bersih :</td>
                                    <td class="py-4 text-right text-xl font-black text-indigo-600">
                                        Rp {{ number_format($payment->amount, 0, ',', '.') }}
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <!-- Informasi Tambahan Setelah Lunas -->
                    @if($payment->status === 'paid')
                        <div class="bg-emerald-50/80 p-5 rounded-2xl border border-emerald-100 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                            <div>
                                <h4 class="text-xs font-bold uppercase tracking-wider text-emerald-800">Bukti Pembayaran Terverifikasi</h4>
                                <p class="text-xs text-emerald-700 mt-0.5">
                                    Kanal Bayar : <strong>{{ $payment->payment_channel ?: 'Transfer Bank / QRIS' }}</strong> &bull; Waktu : {{ $payment->paid_at->format('d M Y, H:i') }} WIB
                                </p>
                            </div>
                            <button onclick="window.print()" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-bold shadow-sm transition flex items-center gap-1.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                                <span>Cetak Faktur</span>
                            </button>
                        </div>
                    @endif

                </div>

            </div>

            <!-- Bagian Pembayaran Interaktif (Jika Status Unpaid dan User adalah Tenant) -->
            @if($payment->status === 'unpaid' && $isTenantOwner)
                <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6 sm:p-8 space-y-6">
                    <div>
                        <h3 class="text-lg font-bold text-slate-900 tracking-tight">Pilih Metode Pembayaran</h3>
                        <p class="text-xs text-slate-500 mt-0.5">Pilih salah satu metode pembayaran di bawah untuk menyelesaikan transaksi sewa Anda</p>
                    </div>

                    <form action="{{ route('payments.pay', $payment->id) }}" method="POST" id="paymentForm">
                        @csrf

                        <!-- Pilihan Channel Pembayaran (Radio Tabs) -->
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 mb-6">
                            
                            <!-- Opsi 1: Virtual Account Bank -->
                            <label class="p-4 border rounded-2xl cursor-pointer hover:border-indigo-500 transition has-[:checked]:border-indigo-600 has-[:checked]:bg-indigo-50/50 flex flex-col justify-between">
                                <div class="flex items-center justify-between">
                                    <span class="text-xs font-bold text-slate-800">Virtual Account</span>
                                    <input type="radio" name="payment_channel" value="BCA_VA" checked class="text-indigo-600 focus:ring-indigo-500">
                                </div>
                                <div class="mt-3">
                                    <p class="text-[11px] text-slate-500">BCA, Mandiri, BNI, BRI</p>
                                    <span class="inline-block mt-2 font-mono text-xs font-bold text-slate-800 bg-white px-2 py-1 rounded border border-slate-200">
                                        8271 0892 8391
                                    </span>
                                </div>
                            </label>

                            <!-- Opsi 2: QRIS Instant -->
                            <label class="p-4 border rounded-2xl cursor-pointer hover:border-indigo-500 transition has-[:checked]:border-indigo-600 has-[:checked]:bg-indigo-50/50 flex flex-col justify-between">
                                <div class="flex items-center justify-between">
                                    <span class="text-xs font-bold text-slate-800">QRIS / E-Money</span>
                                    <input type="radio" name="payment_channel" value="QRIS" class="text-indigo-600 focus:ring-indigo-500">
                                </div>
                                <div class="mt-3">
                                    <p class="text-[11px] text-slate-500">Scan via BCA, Mandiri, GoPay, OVO, ShopeePay</p>
                                    <span class="inline-block mt-2 text-[11px] font-bold text-indigo-700 bg-indigo-100/60 px-2 py-0.5 rounded">
                                        Bebas Biaya Admin
                                    </span>
                                </div>
                            </label>

                            <!-- Opsi 3: E-Wallet Dompet Digital -->
                            <label class="p-4 border rounded-2xl cursor-pointer hover:border-indigo-500 transition has-[:checked]:border-indigo-600 has-[:checked]:bg-indigo-50/50 flex flex-col justify-between">
                                <div class="flex items-center justify-between">
                                    <span class="text-xs font-bold text-slate-800">E-Wallet Langsung</span>
                                    <input type="radio" name="payment_channel" value="GOPAY" class="text-indigo-600 focus:ring-indigo-500">
                                </div>
                                <div class="mt-3">
                                    <p class="text-[11px] text-slate-500">GoPay / ShopeePay / DANA</p>
                                    <span class="inline-block mt-2 text-[11px] font-bold text-slate-600 bg-slate-100 px-2 py-0.5 rounded">
                                        Verifikasi Otomatis
                                    </span>
                                </div>
                            </label>

                        </div>

                        <!-- Tombol Eksekusi Bayar Realtime -->
                        <div class="bg-indigo-900 text-white p-5 rounded-2xl flex flex-col sm:flex-row justify-between items-center gap-4">
                            <div>
                                <span class="text-xs text-indigo-300 block">Total Pembayaran :</span>
                                <span class="text-2xl font-black">Rp {{ number_format($payment->amount, 0, ',', '.') }}</span>
                            </div>

                            <button type="submit" class="w-full sm:w-auto px-6 py-3 bg-emerald-500 hover:bg-emerald-600 text-slate-900 hover:text-white font-black text-sm rounded-xl shadow-lg transition flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <span>Bayar Sekarang (Simulasi Realtime)</span>
                            </button>
                        </div>
                    </form>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
