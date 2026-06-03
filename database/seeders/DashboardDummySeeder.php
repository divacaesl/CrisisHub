<?php

namespace Database\Seeders;

use App\Models\Report;
use App\Models\PriorityScore;
use App\Models\VictimNeed;
use App\Models\Donation;
use App\Models\VolunteerLocation;
use App\Models\Message;
use App\Models\Distribution;
use App\Models\User;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Str;

class DashboardDummySeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('email', 'admin@crisishub.com')->first();
        $authorId = $admin ? $admin->id : User::firstOrCreate([
            'email' => 'admin@crisishub.com',
            'name' => 'Super Admin'
        ], ['password' => bcrypt('password')])->id;

        // Create Reports
        $reports = [
            ['jenis' => 'Banjir', 'kerusakan' => 'Hancur Total', 'lat' => -6.1322, 'lng' => 106.8833, 'desc' => 'Banjir besar merendam ratusan rumah di Jakarta Utara.', 'alamat' => 'Jakarta Utara, DKI Jakarta'],
            ['jenis' => 'Gempa Bumi', 'kerusakan' => 'Tinggi', 'lat' => -6.8167, 'lng' => 107.1417, 'desc' => 'Ribuan rumah rusak akibat gempa 6.2 SR.', 'alamat' => 'Cianjur, Jawa Barat'],
            ['jenis' => 'Erupsi Gunung', 'kerusakan' => 'Sedang', 'lat' => 3.1706, 'lng' => 98.3925, 'desc' => 'Ratusan keluarga mengungsi akibat erupsi Gunung Sinabung.', 'alamat' => 'Karo, Sumatera Utara'],
            ['jenis' => 'Tanah Longsor', 'kerusakan' => 'Tinggi', 'lat' => -7.7122, 'lng' => 110.0097, 'desc' => 'Longsor melanda desa Bagelen, Purworejo.', 'alamat' => 'Purworejo, Jawa Tengah'],
            ['jenis' => 'Angin Topan', 'kerusakan' => 'Tinggi', 'lat' => -8.5833, 'lng' => 116.1167, 'desc' => 'Angin puting beliung menghancurkan puluhan rumah di Mataram.', 'alamat' => 'Mataram, Nusa Tenggara Barat'],
            ['jenis' => 'Banjir Bandang', 'kerusakan' => 'Hancur Total', 'lat' => -3.3167, 'lng' => 114.5901, 'desc' => 'Banjir bandang melanda beberapa kabupaten di Kalimantan Selatan.', 'alamat' => 'Banjarmasin, Kalimantan Selatan']
        ];

        foreach ($reports as $idx => $r) {
            $report = Report::create([
                'user_id' => $authorId,
                'jenis_bencana' => $r['jenis'],
                'tingkat_kerusakan' => $r['kerusakan'],
                'jumlah_korban' => rand(10, 100),
                'deskripsi_kondisi' => $r['desc'],
                'latitude' => $r['lat'],
                'longitude' => $r['lng'],
                'alamat_lengkap' => $r['alamat'],
                'status' => 'Verified',
                'created_at' => Carbon::now()->subDays(rand(0, 6))->subHours(rand(1, 10))
            ]);

            // Create Priority Score
            $level = $r['kerusakan'] == 'Hancur Total' ? 'Kritis' : ($r['kerusakan'] == 'Tinggi' ? 'Tinggi' : 'Sedang');
            PriorityScore::create([
                'report_id' => $report->id,
                'score' => rand(60, 95),
                'level' => $level,
                'variables_snapshot' => json_encode(['severity' => $r['kerusakan']])
            ]);

            // Create Victim Needs
            if ($idx < 3) {
                VictimNeed::create([
                    'report_id' => $report->id,
                    'user_id' => $authorId,
                    'category' => $idx == 0 ? 'Pangan' : ($idx == 1 ? 'Sanitasi' : 'Kesehatan'),
                    'item_name' => $idx == 0 ? 'Makanan Siap Saji' : ($idx == 1 ? 'Air Bersih' : 'Obat-obatan'),
                    'quantity' => rand(500, 2000),
                    'urgency_level' => 1,
                    'status' => 'Pending'
                ]);
            }
        }

        // Create Donations
        for ($i = 0; $i < 5; $i++) {
            Donation::create([
                'user_id' => $authorId,
                'type' => 'Uang',
                'amount' => rand(100000, 2000000),
                'status' => 'Verified',
                'tracking_code' => strtoupper(Str::random(10)),
                'created_at' => Carbon::now()->subMinutes(rand(5, 120))
            ]);
        }

        // Create Volunteer Locations
        for ($i = 0; $i < 4; $i++) {
            VolunteerLocation::create([
                'volunteer_id' => $authorId, 
                'latitude' => -6.9 + (rand(-10, 10) / 100),
                'longitude' => 107.6 + (rand(-10, 10) / 100),
                'recorded_at' => Carbon::now()->subMinutes(rand(1, 15))
            ]);
        }
        
        // Distribution
        Distribution::create([
            'report_id' => Report::first()->id ?? 1,
            'donation_id' => null,
            'volunteer_id' => $authorId,
            'status' => 'Diterima'
        ]);

        // Notifications/Messages
        Message::create([
            'sender_id' => $authorId,
            'content' => 'Terdapat laporan banjir bandang baru yang memerlukan penanganan cepat.',
            'type' => 'broadcast',
            'created_at' => Carbon::now()->subMinutes(10)
        ]);
        Message::create([
            'sender_id' => $authorId,
            'content' => 'Donasi sebesar Rp 1.000.000 telah masuk ke sistem.',
            'type' => 'broadcast',
            'created_at' => Carbon::now()->subMinutes(25)
        ]);
    }
}
