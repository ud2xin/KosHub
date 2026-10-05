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
    // 1. Akun Landlord
    $landlord = User::create([
        'name' => 'Pak Budi (Landlord)',
        'email' => 'landlord@test.com',
        'password' => Hash::make('password'),
        'role' => 'landlord',
        'phone' => '081234567890',
    ]);

    // 2. Akun Tenant
    $tenant = User::create([
        'name' => 'Dimas (Tenant)',
        'email' => 'tenant@test.com',
        'password' => Hash::make('password'),
        'role' => 'tenant',
        'phone' => '089876543210',
    ]);

    // 3. Properti Kos Contoh
    $property = Property::create([
        'landlord_id' => $landlord->id,
        'name' => 'Kost Graha Melati Putri',
        'slug' => Str::slug('Kost Graha Melati Putri'),
        'description' => 'Kost nyaman, dekat kampus dan halte busway. Lingkungan aman dan tenang.',
        'address' => 'Jl. Melati No. 12, Sleman',
        'city' => 'Yogyakarta',
        'type' => 'putri',
        'rules' => 'Pintu gerbang ditutup pukul 23:00 WIB. Tamu lawan jenis dilarang masuk kamar.',
    ]);

    // 4. Unit Kamar
    $room1 = Room::create([
        'property_id' => $property->id,
        'room_number' => 'A-01',
        'type' => 'Deluxe AC',
        'price' => 1500000,
        'status' => 'occupied',
        'facilities' => 'Kasur Springbed, AC, Kamar Mandi Dalam, Meja Belajar, WiFi',
    ]);

    $room2 = Room::create([
        'property_id' => $property->id,
        'room_number' => 'A-02',
        'type' => 'Standard',
        'price' => 900000,
        'status' => 'available',
        'facilities' => 'Kasur Busa, Kipas Angin, Kamar Mandi Luar, Lemari Baju, WiFi',
    ]);

    // 5. Data Sewa Aktif untuk Kamar A-01 oleh Tenant
    $rental = Rental::create([
        'tenant_id' => $tenant->id,
        'room_id' => $room1->id,
        'start_date' => now()->startOfMonth(),
        'end_date' => now()->addMonths(6)->endOfMonth(),
        'total_amount' => 1500000,
        'status' => 'active',
    ]);

    // 6. Data Pembayaran Lunas
    Payment::create([
        'rental_id' => $rental->id,
        'invoice_number' => 'INV-'. strtoupper(Str::random(8)),
        'amount' => 1500000,
        'status' => 'paid',
        'payment_channel' => 'BCA_VA',
        'paid_at' => now(),
    ]);

    // 7. Data Contoh Pengaduan Fasilitas
    Complaint::create([
        'rental_id' => $rental->id,
        'room_id' => $room1->id,
        'tenant_id' => $tenant->id,
        'title' => 'AC Kamar Meneteskan Air',
        'description' => 'Air AC menetes deras di atas meja belajar sejak kemarin sore.',
        'status' => 'open',
        ]);
    }
}
