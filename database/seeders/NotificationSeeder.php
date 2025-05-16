<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Notification;
use Carbon\Carbon;

class NotificationSeeder extends Seeder
{
    /**
     * Menjalankan database seeds.
     */
    public function run(): void
    {
        $admin = User::where('role', 'admin')->first();
        
        // Membuat contoh notifikasi
        $notifications = [
            [
                'title' => 'Pemesanan Baru',
                'message' => 'Pemesanan baru telah dibuat oleh Budi Santoso untuk Toyota Avanza.',
                'type' => 'booking',
                'created_at' => Carbon::now()->subMinutes(10),
            ],
            [
                'title' => 'Pengguna Baru Terdaftar',
                'message' => 'Pengguna baru telah mendaftar: siti.rahayu@contoh.com',
                'type' => 'user',
                'created_at' => Carbon::now()->subHours(1),
            ],
            [
                'title' => 'Pembayaran Diterima',
                'message' => 'Pembayaran sebesar Rp 1.500.000 telah diterima untuk pemesanan #1234.',
                'type' => 'payment',
                'created_at' => Carbon::now()->subHours(3),
                'read_at' => Carbon::now()->subHours(2),
            ],
            [
                'title' => 'Jadwal Perawatan Kendaraan',
                'message' => 'Honda Jazz (ABC123) dijadwalkan untuk perawatan besok.',
                'type' => 'vehicle',
                'created_at' => Carbon::now()->subDays(1),
            ],
            [
                'title' => 'Pembaruan Sistem',
                'message' => 'Sistem akan diperbarui malam ini pukul 02.00 WIB. Diperkirakan akan terjadi pemadaman selama 30 menit.',
                'type' => 'system',
                'created_at' => Carbon::now()->subDays(2),
                'read_at' => Carbon::now()->subDays(1),
            ],
        ];
        
        foreach ($notifications as $notification) {
            Notification::create([
                'user_id' => $admin->id,
                'title' => $notification['title'],
                'message' => $notification['message'],
                'type' => $notification['type'],
                'link' => null,
                'read_at' => $notification['read_at'] ?? null,
                'created_at' => $notification['created_at'],
                'updated_at' => $notification['created_at'],
            ]);
        }
    }
}