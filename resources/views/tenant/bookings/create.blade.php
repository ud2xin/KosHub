<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-xl text-slate-900 leading-tight">
                Formulir Pemesanan (Booking) Kamar
            </h2>
            <a href="{{ route('properties.show', $room->property->slug) }}" class="text-xs font-semibold text-indigo-600 hover:text-indigo-800">
                &larr; Kembali ke Detail Kos
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Ringkasan Kamar yang Dipilih -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <span class="text-[11px] font-bold uppercase tracking-wider text-indigo-600">Unit Terpilih</span>
                    <h3 class="text-2xl font-black text-slate-900 mt-1">Kamar {{ $room->room_number }}</h3>
                    <p class="text-sm font-semibold text-slate-700">{{ $room->property->name }} - {{ $room->property->city }}</p>
                    <p class="text-xs text-slate-500 mt-0.5">Tipe : {{ $room->type }} | Fasilitas : {{ $room->facilities }}</p>
                </div>

                <div class="text-right bg-slate-50 p-4 rounded-xl border border-slate-100 min-w-[200px]">
                    <span class="text-xs text-slate-400 block font-medium">Tarif Dasar / Bulan :</span>
                    <span class="text-xl font-black text-indigo-600">
                        Rp {{ number_format($room->price, 0, ',', '.') }}
                    </span>
                </div>
            </div>

            <!-- Formulir Pemesanan & Kalkulator Biaya -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 sm:p-8">
                <form action="{{ route('bookings.store', $room->id) }}" method="POST" id="bookingForm" class="space-y-6">
                    @csrf

                    <div>
                        <h4 class="text-base font-bold text-slate-900 border-b pb-3 mb-4">1. Tentukan Periode & Durasi Sewa</h4>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Tanggal Mulai Masuk -->
                            <div>
                                <label for="start_date" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                    Tanggal Mulai Menempati
                                </label>
                                <input type="date" id="start_date" name="start_date" value="{{ old('start_date', date('Y-m-d')) }}" min="{{ date('Y-m-d') }}" required class="w-full text-sm rounded-xl border-slate-300 focus:ring-indigo-500 focus:border-indigo-500">
                                @error('start_date') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                            </div>

                            <!-- Pilihan Durasi Sewa -->
                            <div>
                                <label for="duration_months" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                    Durasi Waktu Sewa
                                </label>
                                <select id="duration_months" name="duration_months" required class="w-full text-sm rounded-xl border-slate-300 focus:ring-indigo-500 focus:border-indigo-500">
                                    <option value="1" {{ old('duration_months') == '1' ? 'selected' : '' }}>1 Bulan (Bayar Bulanan)</option>
                                    <option value="3" {{ old('duration_months') == '3' ? 'selected' : '' }}>3 Bulan (Paket Triwulan)</option>
                                    <option value="6" {{ old('duration_months') == '6' ? 'selected' : '' }}>6 Bulan (Paket Semester)</option>
                                    <option value="12" {{ old('duration_months') == '12' ? 'selected' : '' }}>12 Bulan (Paket 1 Tahun)</option>
                                </select>
                                @error('duration_months') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>

                    <div>
                        <h4 class="text-base font-bold text-slate-900 border-b pb-3 mb-4">2. Catatan Khusus untuk Pemilik Kos (Opsional)</h4>
                        <textarea name="notes" rows="2" placeholder="Contoh : Perkiraan check-in pukul 14.00 siang, membawa kendaraan motor..." class="w-full text-sm rounded-xl border-slate-300 focus:ring-indigo-500 focus:border-indigo-500">{{ old('notes') }}</textarea>
                    </div>

                    <!-- Rincian Biaya Realtime -->
                    <div class="bg-indigo-50/70 p-5 rounded-2xl border border-indigo-100 space-y-3">
                        <h4 class="text-sm font-bold text-indigo-950 uppercase tracking-wider">Rincian Perhitungan Tagihan</h4>
                        <div class="flex justify-between text-xs text-slate-600">
                            <span>Harga Sewa Kamar / Bulan :</span>
                            <span class="font-semibold text-slate-800" id="displayBasePrice">Rp {{ number_format($room->price, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-xs text-slate-600">
                            <span>Durasi yang Dipilih :</span>
                            <span class="font-semibold text-slate-800" id="displayDuration">1 Bulan</span>
                        </div>
                        <div class="border-t border-indigo-200 pt-3 flex justify-between items-center text-sm">
                            <span class="font-bold text-slate-900">Total Biaya yang Harus Dibayar :</span>
                            <span class="text-2xl font-black text-indigo-700" id="displayTotalPrice">Rp {{ number_format($room->price, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <!-- Tombol Submit -->
                    <div class="flex items-center justify-end gap-3 pt-4 border-t">
                        <a href="{{ route('properties.show', $room->property->slug) }}" class="px-5 py-2.5 rounded-xl border border-slate-300 text-xs font-semibold text-slate-700 hover:bg-slate-50 transition">
                            Batalkan
                        </a>
                        <button type="submit" class="px-6 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-sm shadow-md shadow-indigo-200 transition flex items-center gap-2">
                            <span>Konfirmasi & Lanjut ke Pembayaran</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>

    <!-- Script Kalkulator Realtime -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const basePrice = {{ (int) $room->price }};
            const durationSelect = document.getElementById('duration_months');
            const displayDuration = document.getElementById('displayDuration');
            const displayTotalPrice = document.getElementById('displayTotalPrice');

            function updatePrice() {
                const duration = parseInt(durationSelect.value) || 1;
                const total = basePrice * duration;

                displayDuration.textContent = duration + ' Bulan';
                displayTotalPrice.textContent = 'Rp ' + total.toLocaleString('id-ID');
            }

            durationSelect.addEventListener('change', updatePrice);
            updatePrice();
        });
    </script>
</x-app-layout>
