<x-guest-layout>
    <div class="mb-6 text-center">
        <h2 class="text-2xl font-extrabold text-gray-800">Daftar Akun Baru</h2>
        <p class="text-xs text-gray-500 mt-1">Pilih peran akun Anda untuk mulai menggunakan aplikasi</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Pilihan Peran Akun (Role) -->
        <div class="mb-4">
            <x-input-label :value="__('Daftar Sebagai')" />
            <div class="grid grid-cols-2 gap-3 mt-2">
                <label class="relative flex flex-col p-3 border rounded-xl cursor-pointer hover:border-indigo-500 focus-within:ring-2 focus-within:ring-indigo-500 transition bg-white shadow-sm has-[:checked]:border-indigo-600 has-[:checked]:bg-indigo-50/50">
                    <input type="radio" name="role" value="tenant" class="sr-only" {{ old('role', 'tenant') === 'tenant' ? 'checked' : '' }} required>
                    <span class="text-sm font-bold text-gray-800 flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        Pencari Kos
                    </span>
                    <span class="text-[11px] text-gray-500 mt-1 leading-tight">Saya mahasiswa / karyawan yang ingin sewa kamar</span>
                </label>

                <label class="relative flex flex-col p-3 border rounded-xl cursor-pointer hover:border-indigo-500 focus-within:ring-2 focus-within:ring-indigo-500 transition bg-white shadow-sm has-[:checked]:border-indigo-600 has-[:checked]:bg-indigo-50/50">
                    <input type="radio" name="role" value="landlord" class="sr-only" {{ old('role') === 'landlord' ? 'checked' : '' }} required>
                    <span class="text-sm font-bold text-gray-800 flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        Pemilik Kos
                    </span>
                    <span class="text-[11px] text-gray-500 mt-1 leading-tight">Saya pemilik properti yang ingin menyewakan kamar</span>
                </label>
            </div>
            <x-input-error :messages="$errors->get('role')" class="mt-2" />
        </div>

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Nama Lengkap')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Contoh : Dimas Saputra" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Nomor Telepon / WA -->
        <div class="mt-4">
            <x-input-label for="phone" :value="__('Nomor WhatsApp / HP')" />
            <x-text-input id="phone" class="block mt-1 w-full" type="text" name="phone" :value="old('phone')" placeholder="Contoh : 081234567890" />
            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Alamat Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="nama@email.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Kata Sandi')" />
            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" placeholder="Minimal 8 karakter" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Konfirmasi Kata Sandi')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" placeholder="Ulangi kata sandi" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between mt-6">
            <a class="underline text-xs text-gray-600 hover:text-indigo-600 rounded-md" href="{{ route('login') }}">
                Sudah punya akun? Masuk
            </a>

            <x-primary-button>
                Daftar Sekarang
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
