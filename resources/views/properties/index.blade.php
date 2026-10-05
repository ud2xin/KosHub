<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>KosHub - Cari & Sewa Kos Mahasiswa & Karyawan Nyaman</title>
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
                <div>
                    <span class="font-extrabold text-xl tracking-tight text-slate-900">Kos<span class="text-indigo-600">Hub</span></span>
                    <span class="block text-[10px] text-slate-400 font-semibold tracking-wider uppercase -mt-1">Sewa & Kelola Kos</span>
                </div>
            </a>

            <div class="flex items-center gap-3">
                @auth
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold bg-indigo-50 text-indigo-700 hover:bg-indigo-100 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                        Dashboard ({{ Auth::user()->name }})
                    </a>
                @else
                    <a href="{{ route('login') }}" class="text-sm font-semibold text-slate-600 hover:text-indigo-600 px-3 py-2">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-4 py-2 rounded-xl text-sm font-bold bg-indigo-600 text-white hover:bg-indigo-700 shadow-sm shadow-indigo-300 transition">
                        Daftar Akun
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <!-- Hero Search Section -->
    <section class="relative bg-gradient-to-br from-indigo-900 via-indigo-800 to-slate-900 text-white py-16 px-4 sm:px-6 lg:px-8 overflow-hidden">
        <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#fff_1px,transparent_1px)] [background-size:16px_16px]"></div>
        
        <div class="relative max-w-4xl mx-auto text-center">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-indigo-500/30 text-indigo-200 border border-indigo-400/20 mb-4">
                ✨ Solusi Praktis Kos-Kosan Mahasiswa & Karyawan
            </span>
            <h1 class="text-3xl sm:text-5xl font-extrabold tracking-tight leading-tight">
                Cari & Sewa Kos Impian <br class="hidden sm:inline">Tanpa Ribet, Serba Otomatis
            </h1>
            <p class="mt-4 text-indigo-200 text-sm sm:text-base max-w-2xl mx-auto">
                Lihat ketersediaan kamar secara realtime, booking langsung, bayar aman lewat berbagai metode, dan nikmati fitur pelaporan fasilitas terpadu.
            </p>

            <!-- Search & Filter Card -->
            <form action="{{ route('home') }}" method="GET" class="mt-8 bg-white p-3 sm:p-4 rounded-2xl shadow-2xl text-slate-800 grid grid-cols-1 sm:grid-cols-12 gap-3 text-left">
                <!-- Input Keyword -->
                <div class="sm:col-span-5">
                    <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1">Cari Kos / Alamat</label>
                    <div class="relative">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Ketik nama kos, daerah, atau kampus..." class="w-full text-sm rounded-xl border-slate-200 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 pl-9 py-2.5">
                        <svg class="w-4 h-4 text-slate-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                </div>

                <!-- Dropdown Kota -->
                <div class="sm:col-span-3">
                    <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1">Kota / Wilayah</label>
                    <select name="city" class="w-full text-sm rounded-xl border-slate-200 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 py-2.5">
                        <option value="">Semua Kota</option>
                        @foreach($availableCities as $city)
                            <option value="{{ $city }}" {{ request('city') === $city ? 'selected' : '' }}>{{ $city }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Dropdown Tipe Kos -->
                <div class="sm:col-span-2">
                    <label class="block text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1">Tipe Kos</label>
                    <select name="type" class="w-full text-sm rounded-xl border-slate-200 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 py-2.5">
                        <option value="">Semua</option>
                        <option value="putra" {{ request('type') === 'putra' ? 'selected' : '' }}>Putra</option>
                        <option value="putri" {{ request('type') === 'putri' ? 'selected' : '' }}>Putri</option>
                        <option value="campur" {{ request('type') === 'campur' ? 'selected' : '' }}>Campur</option>
                    </select>
                </div>

                <!-- Tombol Submit -->
                <div class="sm:col-span-2 flex items-end">
                    <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2.5 px-4 rounded-xl text-sm shadow-md shadow-indigo-300 transition flex items-center justify-center gap-1.5 h-[42px]">
                        <span>Cari Kos</span>
                    </button>
                </div>
            </form>
        </div>
    </section>

    <!-- Main Content Area -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 flex-1">
        
        <!-- Filter Tabs & Sort Header -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8 pb-4 border-b border-slate-200">
            <div>
                <h2 class="text-2xl font-bold text-slate-900 tracking-tight">Rekomendasi Kos Pilihan</h2>
                <p class="text-xs text-slate-500 mt-0.5">Ditemukan {{ $properties->total() }} pilihan kos siap huni</p>
            </div>

            <!-- Quick Type Filter Buttons & Sort Dropdown -->
            <div class="flex flex-wrap items-center gap-2">
                <a href="{{ route('home') }}" class="px-3 py-1.5 rounded-lg text-xs font-semibold {{ !request('type') ? 'bg-indigo-600 text-white' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' }}">
                    Semua
                </a>
                <a href="{{ route('home', array_merge(request()->query(), ['type' => 'putri'])) }}" class="px-3 py-1.5 rounded-lg text-xs font-semibold {{ request('type') === 'putri' ? 'bg-pink-600 text-white' : 'bg-white text-slate-600 hover:bg-pink-50 border border-slate-200' }}">
                    Putri
                </a>
                <a href="{{ route('home', array_merge(request()->query(), ['type' => 'putra'])) }}" class="px-3 py-1.5 rounded-lg text-xs font-semibold {{ request('type') === 'putra' ? 'bg-blue-600 text-white' : 'bg-white text-slate-600 hover:bg-blue-50 border border-slate-200' }}">
                    Putra
                </a>
                <a href="{{ route('home', array_merge(request()->query(), ['type' => 'campur'])) }}" class="px-3 py-1.5 rounded-lg text-xs font-semibold {{ request('type') === 'campur' ? 'bg-purple-600 text-white' : 'bg-white text-slate-600 hover:bg-purple-50 border border-slate-200' }}">
                    Campur
                </a>

                <div class="ms-2">
                    <form action="{{ route('home') }}" method="GET" class="inline">
                        @if(request('search')) <input type="hidden" name="search" value="{{ request('search') }}"> @endif
                        @if(request('type')) <input type="hidden" name="type" value="{{ request('type') }}"> @endif
                        @if(request('city')) <input type="hidden" name="city" value="{{ request('city') }}"> @endif
                        <select name="sort" onchange="this.form.submit()" class="text-xs rounded-lg border-slate-300 py-1.5 pl-2 pr-7 font-medium text-slate-700">
                            <option value="">Urutkan : Terbaru</option>
                            <option value="price_asc" {{ request('sort') === 'price_asc' ? 'selected' : '' }}>Harga : Termurah</option>
                            <option value="price_desc" {{ request('sort') === 'price_desc' ? 'selected' : '' }}>Harga : Termahal</option>
                        </select>
                    </form>
                </div>
            </div>
        </div>

        <!-- Property Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($properties as $property)
                @php
                    $availableCount = $property->rooms->where('status', 'available')->count();
                    $minPrice = $property->rooms->min('price');
                @endphp
                <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden flex flex-col justify-between group">
                    <div>
                        <!-- Thumbnail / Image Cover -->
                        <div class="relative h-48 bg-slate-100 overflow-hidden">
                            @if($property->thumbnail)
                                <img src="{{ asset('storage/' . $property->thumbnail) }}" alt="{{ $property->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                            @else
                                <div class="w-full h-full flex flex-col items-center justify-center bg-gradient-to-tr from-slate-800 to-indigo-900 text-indigo-200">
                                    <svg class="w-12 h-12 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                    <span class="text-xs font-semibold mt-2 tracking-wide uppercase text-indigo-300/80">{{ $property->city }}</span>
                                </div>
                            @endif

                            <!-- Type Badge -->
                            <div class="absolute top-3 left-3">
                                @if($property->type === 'putri')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-pink-500/90 text-white backdrop-blur shadow-sm">
                                        Kos Putri
                                    </span>
                                @elseif($property->type === 'putra')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-blue-600/90 text-white backdrop-blur shadow-sm">
                                        Kos Putra
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-purple-600/90 text-white backdrop-blur shadow-sm">
                                        Kos Campur
                                    </span>
                                @endif
                            </div>

                            <!-- Availability Badge -->
                            <div class="absolute top-3 right-3">
                                @if($availableCount > 0)
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-500/90 text-white backdrop-blur shadow-sm">
                                        <span class="w-1.5 h-1.5 rounded-full bg-white animate-pulse"></span>
                                        {{ $availableCount }} Kamar Kosong
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-slate-800/80 text-slate-200 backdrop-blur">
                                        Kamar Penuh
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Card Body -->
                        <div class="p-5">
                            <div class="flex items-center gap-1.5 text-xs font-semibold text-indigo-600 mb-1">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                <span>{{ $property->city }}</span>
                            </div>

                            <h3 class="text-lg font-bold text-slate-900 group-hover:text-indigo-600 transition leading-snug">
                                <a href="{{ route('properties.show', $property->slug) }}">
                                    {{ $property->name }}
                                </a>
                            </h3>

                            <p class="text-xs text-slate-500 mt-1 line-clamp-1">
                                {{ $property->address }}
                            </p>

                            <p class="text-xs text-slate-600 mt-3 line-clamp-2 leading-relaxed">
                                {{ $property->description ?: 'Kos strategis dan nyaman untuk tempat tinggal Anda.' }}
                            </p>
                        </div>
                    </div>

                    <!-- Card Footer: Price & Action -->
                    <div class="px-5 pb-5 pt-3 border-t border-slate-100 flex items-center justify-between">
                        <div>
                            <span class="text-[11px] text-slate-400 font-medium block">Mulai dari</span>
                            @if($minPrice)
                                <div class="text-base font-extrabold text-indigo-600">
                                    Rp {{ number_format($minPrice, 0, ',', '.') }}
                                    <span class="text-[11px] font-normal text-slate-500">/ bln</span>
                                </div>
                            @else
                                <div class="text-xs text-slate-400 italic">Harga belum diatur</div>
                            @endif
                        </div>

                        <a href="{{ route('properties.show', $property->slug) }}" class="inline-flex items-center gap-1 bg-indigo-50 text-indigo-700 hover:bg-indigo-600 hover:text-white px-4 py-2 rounded-xl text-xs font-bold transition">
                            <span>Lihat Unit</span>
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-20 text-center bg-white rounded-2xl border border-slate-200 p-8 shadow-sm">
                    <div class="w-16 h-16 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-800">Tidak ada kos yang sesuai dengan filter</h3>
                    <p class="text-sm text-slate-500 mt-1 max-w-md mx-auto">Coba ubah kata kunci pencarian, pilih kota lain, atau reset filter untuk melihat semua kos.</p>
                    <a href="{{ route('home') }}" class="inline-block mt-4 px-4 py-2 bg-indigo-600 text-white rounded-xl text-xs font-semibold hover:bg-indigo-700">
                        Reset Filter
                    </a>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-10">
            {{ $properties->links() }}
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-slate-200 py-8 mt-12 text-center text-xs text-slate-500">
        <div class="max-w-7xl mx-auto px-4">
            <p class="font-semibold text-slate-700">KosHub Platform &bull; Sewa & Manajemen Properti Kos Modern</p>
            <p class="mt-1 text-slate-400">Dirancang khusus untuk kenyamanan mahasiswa, karyawan, dan pemilik kos.</p>
        </div>
    </footer>

</body>
</html>
