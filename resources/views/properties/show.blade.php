<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $property->name }} - KosHub</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 text-slate-800 antialiased font-sans flex flex-col min-h-screen">

    <!-- Top Navigation -->
    <header class="bg-white/95 backdrop-blur border-b border-slate-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex justify-between items-center">
            <a href="{{ route('home') }}" class="flex items-center gap-2">
                <div class="w-10 h-10 rounded-xl bg-indigo-600 flex items-center justify-center text-white font-black text-xl shadow-md shadow-indigo-200">
                    K
                </div>
                <span class="font-extrabold text-xl tracking-tight text-slate-900">Kos<span class="text-indigo-600">Hub</span></span>
            </a>

            <div class="flex items-center gap-3">
                <a href="{{ route('home') }}" class="text-xs font-bold text-slate-600 hover:text-indigo-600 px-3 py-2 flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Semua Kos
                </a>
                @auth
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-bold bg-indigo-50 text-indigo-700 hover:bg-indigo-100 transition">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="text-xs font-semibold text-slate-600 hover:text-indigo-600 px-3 py-2">Masuk</a>
                    <a href="{{ route('register') }}" class="px-4 py-2 rounded-xl text-xs font-bold bg-indigo-600 text-white hover:bg-indigo-700">Daftar</a>
                @endauth
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 flex-1 space-y-8">
        
        <!-- Flash Message -->
        @if(session('error'))
            <div class="p-4 bg-red-50 border-l-4 border-red-500 rounded-xl text-sm text-red-700 font-medium">
                {{ session('error') }}
            </div>
        @endif
        @if(session('success'))
            <div class="p-4 bg-emerald-50 border-l-4 border-emerald-500 rounded-xl text-sm text-emerald-700 font-medium">
                {{ session('success') }}
            </div>
        @endif

        <!-- Header Info Properti Kos -->
        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
            <!-- Cover Banner -->
            <div class="relative h-64 sm:h-80 bg-gradient-to-r from-indigo-950 via-slate-900 to-indigo-900">
                @if($property->thumbnail)
                    <img src="{{ asset('storage/' . $property->thumbnail) }}" alt="{{ $property->name }}" class="w-full h-full object-cover opacity-60">
                @else
                    <div class="w-full h-full flex flex-col items-center justify-center text-indigo-200">
                        <svg class="w-20 h-20 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    </div>
                @endif

                <div class="absolute bottom-6 left-6 right-6 flex flex-col sm:flex-row justify-between items-start sm:items-end gap-4">
                    <div class="text-white drop-shadow-md">
                        <div class="flex items-center gap-2 mb-2">
                            @if($property->type === 'putri')
                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-pink-500 text-white shadow">Kos Putri</span>
                            @elseif($property->type === 'putra')
                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-blue-600 text-white shadow">Kos Putra</span>
                            @else
                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-purple-600 text-white shadow">Kos Campur</span>
                            @endif
                            <span class="px-3 py-1 rounded-full text-xs font-bold bg-white/20 backdrop-blur text-white">{{ $property->city }}</span>
                        </div>
                        <h1 class="text-2xl sm:text-4xl font-black text-white">{{ $property->name }}</h1>
                        <p class="text-xs sm:text-sm text-slate-200 mt-1 flex items-center gap-1">
                            <svg class="w-4 h-4 text-rose-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path></svg>
                            {{ $property->address }}, {{ $property->city }}
                        </p>
                    </div>

                    <!-- Availability Summary Card -->
                    <div class="bg-white/90 backdrop-blur-md px-5 py-3 rounded-2xl shadow-lg border border-white/20 text-slate-800 flex items-center gap-4">
                        <div>
                            <span class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider block">Kamar Tersedia</span>
                            <span class="text-2xl font-black text-emerald-600">{{ $availableRooms->count() }} <span class="text-xs font-semibold text-slate-500">Unit</span></span>
                        </div>
                        <div class="border-l border-slate-300 pl-4">
                            <span class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider block">Total Unit</span>
                            <span class="text-2xl font-black text-slate-800">{{ $property->rooms->count() }} <span class="text-xs font-semibold text-slate-500">Kamar</span></span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detail Tabs / Columns -->
            <div class="p-6 sm:p-8 grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="md:col-span-2 space-y-6">
                    <div>
                        <h3 class="text-base font-bold text-slate-900 mb-2 flex items-center gap-2">
                            <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Deskripsi Kos
                        </h3>
                        <p class="text-sm text-slate-600 leading-relaxed bg-slate-50 p-4 rounded-2xl border border-slate-100">
                            {{ $property->description ?: 'Kos ini menyediakan lingkungan tinggal yang aman, nyaman, dan strategis bagi penghuni.' }}
                        </p>
                    </div>

                    <div>
                        <h3 class="text-base font-bold text-slate-900 mb-2 flex items-center gap-2">
                            <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                            Tata Tertib & Aturan Kos
                        </h3>
                        <div class="text-sm text-slate-600 leading-relaxed bg-amber-50/50 p-4 rounded-2xl border border-amber-100">
                            {{ $property->rules ?: 'Pintu gerbang ditutup pukul 23:00 WIB. Jaga kebersihan dan ketenangan lingkungan kos.' }}
                        </div>
                    </div>
                </div>

                <!-- Landlord Card -->
                <div class="space-y-4">
                    <div class="bg-indigo-50/60 p-5 rounded-2xl border border-indigo-100">
                        <span class="text-[11px] font-bold uppercase tracking-wider text-indigo-500">Dikelola Oleh</span>
                        <div class="flex items-center gap-3 mt-3">
                            <div class="w-12 h-12 rounded-xl bg-indigo-600 text-white font-black text-lg flex items-center justify-center">
                                {{ strtoupper(substr($property->landlord->name, 0, 1)) }}
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-900 text-sm">{{ $property->landlord->name }}</h4>
                                <span class="inline-block text-[11px] text-emerald-700 bg-emerald-100 px-2 py-0.5 rounded font-semibold mt-0.5">Pemilik Terverifikasi</span>
                            </div>
                        </div>

                        @if($property->landlord->phone)
                            <div class="mt-4 pt-3 border-t border-indigo-100 text-xs text-slate-600">
                                <span class="text-slate-400 block">WhatsApp / Kontak :</span>
                                <span class="font-bold text-slate-800">{{ $property->landlord->phone }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Section Daftar Unit Kamar -->
        <div class="space-y-6">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2">
                <div>
                    <h2 class="text-2xl font-bold text-slate-900 tracking-tight">Pilih Unit Kamar</h2>
                    <p class="text-xs text-slate-500 mt-0.5">Pilih kamar yang berstatus kosong dan klik sewa untuk melanjutkan proses pemesanan</p>
                </div>
            </div>

            <!-- Grid Kamar -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($property->rooms as $room)
                    <div class="bg-white rounded-2xl border {{ $room->status === 'available' ? 'border-slate-200 shadow-sm hover:border-indigo-400 hover:shadow-md' : 'border-slate-200/60 opacity-80' }} p-6 flex flex-col justify-between transition-all">
                        <div>
                            <!-- Header Kamar -->
                            <div class="flex justify-between items-start">
                                <div>
                                    <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider block">Kamar</span>
                                    <h3 class="text-xl font-black text-slate-900">{{ $room->room_number }}</h3>
                                    <span class="inline-block text-xs font-medium text-indigo-600 bg-indigo-50 px-2 py-0.5 rounded mt-1">Tipe : {{ $room->type }}</span>
                                </div>

                                <!-- Status Badge -->
                                <div>
                                    @if($room->status === 'available')
                                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>
                                            Tersedia
                                        </span>
                                    @elseif($room->status === 'occupied')
                                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-800">
                                            Terisi
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-700">
                                            Perbaikan
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <!-- Harga Sewa -->
                            <div class="mt-5 p-3.5 bg-slate-50 rounded-xl border border-slate-100">
                                <span class="text-[11px] text-slate-400 font-medium block">Biaya Sewa</span>
                                <div class="text-xl font-black text-indigo-600">
                                    Rp {{ number_format($room->price, 0, ',', '.') }}
                                    <span class="text-xs font-normal text-slate-500">/ bulan</span>
                                </div>
                            </div>

                            <!-- Fasilitas Kamar -->
                            <div class="mt-4">
                                <span class="text-xs font-bold text-slate-700 block mb-1.5">Fasilitas Kamar :</span>
                                <p class="text-xs text-slate-600 leading-relaxed">
                                    {{ $room->facilities ?: 'Kasur, Lemari, Meja Belajar, WiFi' }}
                                </p>
                            </div>
                        </div>

                        <!-- Action Button -->
                        <div class="mt-6 pt-4 border-t border-slate-100">
                            @if($room->status === 'available')
                                @auth
                                    @if(Auth::user()->role === 'tenant')
                                        <a href="{{ route('bookings.create', $room->id) }}" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2.5 px-4 rounded-xl text-xs flex items-center justify-center gap-2 shadow-sm shadow-indigo-300 transition">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                            Sewa / Booking Kamar Ini
                                        </a>
                                    @else
                                        <div class="text-center py-2 px-3 bg-slate-100 rounded-xl text-xs font-medium text-slate-500">
                                            Akun Pemilik Kos (Mode Pantau)
                                        </div>
                                    @endif
                                @else
                                    <a href="{{ route('login') }}" class="w-full bg-slate-900 hover:bg-indigo-600 text-white font-bold py-2.5 px-4 rounded-xl text-xs flex items-center justify-center gap-2 transition">
                                        Masuk untuk Sewa Kamar
                                    </a>
                                @endauth
                            @elseif($room->status === 'occupied')
                                <button disabled class="w-full bg-slate-100 text-slate-400 font-semibold py-2.5 px-4 rounded-xl text-xs cursor-not-allowed">
                                    Kamar Sedang Dihuni
                                </button>
                            @else
                                <button disabled class="w-full bg-slate-100 text-slate-400 font-semibold py-2.5 px-4 rounded-xl text-xs cursor-not-allowed">
                                    Sedang Dalam Perbaikan
                                </button>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-16 text-center bg-white rounded-2xl border border-slate-200 p-8">
                        <p class="text-sm font-semibold text-slate-600">Belum ada unit kamar yang terdaftar di properti ini.</p>
                    </div>
                @endforelse
            </div>
        </div>

    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-slate-200 py-6 text-center text-xs text-slate-400">
        KosHub Platform &bull; Sewa Kos Aman & Terpercaya
    </footer>

</body>
</html>
