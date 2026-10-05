<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Property;
use App\Models\Room;
use App\Models\Rental;
use App\Models\Payment;
use App\Models\Complaint;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Akun Pemilik Kos (Landlord)
        $landlord = User::firstOrCreate(
            ['email' => 'landlord@test.com'],
            [
                'name' => 'Pak Budi Santoso (Landlord)',
                'password' => Hash::make('password'),
                'role' => 'landlord',
                'phone' => '081234567890',
            ]
        );

        // 2. Akun Penyewa Utama (Tenant)
        $tenant1 = User::firstOrCreate(
            ['email' => 'tenant@test.com'],
            [
                'name' => 'Dimas Saputra (Tenant)',
                'password' => Hash::make('password'),
                'role' => 'tenant',
                'phone' => '089876543210',
            ]
        );

        // 3. Akun Penyewa Tambahan (Tenant 2)
        $tenant2 = User::firstOrCreate(
            ['email' => 'siti@test.com'],
            [
                'name' => 'Siti Aisyah (Tenant)',
                'password' => Hash::make('password'),
                'role' => 'tenant',
                'phone' => '087712345678',
            ]
        );

        // 4. Properti Kos 1 : Yogyakarta (Putri)
        $prop1 = Property::firstOrCreate(
            ['slug' => 'kost-graha-melati-putri'],
            [
                'landlord_id' => $landlord->id,
                'name' => 'Kost Graha Melati Putri',
                'description' => 'Kost putri eksklusif, aman, bersih dan tenang. Hanya 5 menit ke kampus UGM/UNY dan dekat halte TransJogja. Dilengkapi CCTV 24 jam dan akses fingerprint.',
                'address' => 'Jl. Melati No. 12, Caturtunggal, Sleman',
                'city' => 'Yogyakarta',
                'type' => 'putri',
                'rules' => 'Pintu gerbang ditutup pukul 23:00 WIB. Tamu pria hanya boleh di ruang tamu bersama. Dilarang merokok dan membawa hewan peliharaan.',
            ]
        );

        // Unit Kamar Kos 1
        $room1 = Room::firstOrCreate(
            ['property_id' => $prop1->id, 'room_number' => 'A-01'],
            [
                'type' => 'Deluxe AC',
                'price' => 1500000,
                'status' => 'occupied',
                'facilities' => 'Kasur Springbed 120x200, AC Daikin 1/2 PK, Kamar Mandi Dalam (Water Heater), Meja Belajar Kayu Jati, Lemari Pakaian 2 Pintu, WiFi 50 Mbps',
            ]
        );

        $room2 = Room::firstOrCreate(
            ['property_id' => $prop1->id, 'room_number' => 'A-02'],
            [
                'type' => 'Standard',
                'price' => 950000,
                'status' => 'available',
                'facilities' => 'Kasur Busa Inoac, Kipas Angin Dinding, Kamar Mandi Luar Bersih, Meja Belajar, Lemari Pakaian, WiFi',
            ]
        );

        $room3 = Room::firstOrCreate(
            ['property_id' => $prop1->id, 'room_number' => 'A-03'],
            [
                'type' => 'VIP Balkon',
                'price' => 1850000,
                'status' => 'available',
                'facilities' => 'Balkon Pribadi, Kasur Queen Size, AC, Smart TV 32 Inch, Kamar Mandi Dalam + Water Heater, Kulkas Mini, WiFi 100 Mbps',
            ]
        );

        $room4 = Room::firstOrCreate(
            ['property_id' => $prop1->id, 'room_number' => 'A-04'],
            [
                'type' => 'Standard AC',
                'price' => 1200000,
                'status' => 'maintenance',
                'facilities' => 'Kasur Single, AC, Meja Belajar, Kamar Mandi Dalam (Sedang Pengecatan Ulang)',
            ]
        );

        // 5. Properti Kos 2 : Jakarta Selatan (Campur)
        $prop2 = Property::firstOrCreate(
            ['slug' => 'kost-executive-rasuna-residence'],
            [
                'landlord_id' => $landlord->id,
                'name' => 'Kost Executive Rasuna Residence',
                'description' => 'Kost modern premium untuk eksekutif muda dan mahasiswa. Lokasi emas segitiga Kuningan Jakarta Selatan, dekat stasiun LRT dan mall ternama.',
                'address' => 'Jl. Rasuna Barat No. 88, Setiabudi',
                'city' => 'Jakarta Selatan',
                'type' => 'campur',
                'rules' => 'Akses kartu pintar 24 jam. Parkir mobil & motor tersedia. Menjaga ketertiban dan kenyamanan sesama penghuni.',
            ]
        );

        Room::firstOrCreate(
            ['property_id' => $prop2->id, 'room_number' => 'B-101'],
            [
                'type' => 'Studio Suite',
                'price' => 2800000,
                'status' => 'available',
                'facilities' => 'Kasur King Koil, AC Inverter, Smart TV 43 Inch, Kamar Mandi Dalam dengan Bathtub, Kitchenette Pribadi, WiFi Dedicated 100 Mbps',
            ]
        );

        Room::firstOrCreate(
            ['property_id' => $prop2->id, 'room_number' => 'B-102'],
            [
                'type' => 'Executive Single',
                'price' => 2200000,
                'status' => 'available',
                'facilities' => 'Kasur Springbed, AC, Kamar Mandi Dalam, Meja Kerja Ergonomis, Lemari Sliding Kaca, WiFi High Speed',
            ]
        );

        // 6. Properti Kos 3 : Bandung (Putra)
        $prop3 = Property::firstOrCreate(
            ['slug' => 'kost-putra-pondok-dago-asri'],
            [
                'landlord_id' => $landlord->id,
                'name' => 'Kost Putra Pondok Dago Asri',
                'description' => 'Kost khusus mahasiswa dan karyawan pria di kawasan sejuk Dago Atas Bandung. Dekat kampus ITB dan Unpad Dipatiukur, suasana tenang untuk belajar.',
                'address' => 'Jl. Dago Asri V No. 15, Coblong',
                'city' => 'Bandung',
                'type' => 'putra',
                'rules' => 'Gerbang ditutup pukul 24:00 WIB. Dilarang membawa miras atau obat terlarang. Tersedia dapur umum dan dispenser air minum gratis.',
            ]
        );

        Room::firstOrCreate(
            ['property_id' => $prop3->id, 'room_number' => 'C-01'],
            [
                'type' => 'Reguler Mahasiswa',
                'price' => 850000,
                'status' => 'available',
                'facilities' => 'Kasur Busa, Lemari Pakaian, Meja Belajar, Kamar Mandi Luar, Parkir Motor Luas, WiFi Fiber',
            ]
        );

        Room::firstOrCreate(
            ['property_id' => $prop3->id, 'room_number' => 'C-02'],
            [
                'type' => 'Reguler Mahasiswa',
                'price' => 850000,
                'status' => 'available',
                'facilities' => 'Kasur Busa, Lemari Pakaian, Meja Belajar, Kamar Mandi Luar, WiFi Fiber',
            ]
        );

        // 7. Data Kontrak Sewa Aktif untuk Dimas (Tenant 1) di Kamar A-01
        $rental = Rental::firstOrCreate(
            ['tenant_id' => $tenant1->id, 'room_id' => $room1->id],
            [
                'start_date' => now()->startOfMonth(),
                'end_date' => now()->addMonths(6)->endOfMonth(),
                'total_amount' => 1500000,
                'status' => 'active',
            ]
        );

        // 8. Data Pembayaran Lunas untuk Sewa Tersebut
        Payment::firstOrCreate(
            ['rental_id' => $rental->id],
            [
                'invoice_number' => 'INV-20261001-BCA01',
                'amount' => 1500000,
                'status' => 'paid',
                'payment_channel' => 'BCA_VA',
                'paid_at' => now()->subDays(2),
                'snap_token' => 'SNAP-' . Str::random(24),
            ]
        );

        // 9. Data Laporan Pengaduan Fasilitas
        Complaint::firstOrCreate(
            ['rental_id' => $rental->id, 'title' => 'AC Kamar Meneteskan Air'],
            [
                'room_id' => $room1->id,
                'tenant_id' => $tenant1->id,
                'description' => 'Air pembuangan AC menetes cukup deras di dekat meja belajar sejak kemarin sore, mohon bantuan teknisi untuk servis.',
                'status' => 'open',
            ]
        );

        Complaint::firstOrCreate(
            ['rental_id' => $rental->id, 'title' => 'Gagang Pintu Kamar Mandi Longgar'],
            [
                'room_id' => $room1->id,
                'tenant_id' => $tenant1->id,
                'description' => 'Baut gagang pintu kamar mandi agak kendur dan hampir lepas.',
                'status' => 'resolved',
            ]
        );
    }
}
