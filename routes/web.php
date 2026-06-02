<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// =============================================
// PUBLIC ROUTES — CrisisHub
// =============================================

// Helper to retrieve campaigns dynamically (combining DB records with dynamic donations)
if (!function_exists('getCampaignsList')) {
    function getCampaignsList() {
        // Ensure database default campaigns exist
        if (\App\Models\Campaign::count() === 0) {
            $orgId = \App\Models\User::whereHas('roles', function($q) {
                $q->whereIn('name', ['Admin', 'Organisasi Bantuan']);
            })->first()?->id ?: 1;

            $defaults = [
                [
                    'emoji' => '🌊', 'tag' => 'URGENT', 'tag_color' => 'red',
                    'title' => 'Darurat Banjir Jakarta Utara', 'location' => 'Jakarta Utara, DKI Jakarta',
                    'target_amount' => 500000000, 'collected_amount' => 387500000,
                    'deadline' => now()->addDays(3),
                    'description' => 'Banjir besar merendam ratusan rumah di Jakarta Utara. Ribuan keluarga butuh bantuan makanan, air bersih, dan tempat pengungsian.'
                ],
                [
                    'emoji' => '🏔️', 'tag' => 'AKTIF', 'tag_color' => 'blue',
                    'title' => 'Rehab Hunian Pasca Gempa Cianjur', 'location' => 'Cianjur, Jawa Barat',
                    'target_amount' => 1000000000, 'collected_amount' => 642000000,
                    'deadline' => now()->addDays(12),
                    'description' => 'Ribuan rumah rusak akibat gempa 6.2 SR. Dana digunakan untuk perbaikan hunian sementara and kebutuhan dasar keluarga terdampak.'
                ],
                [
                    'emoji' => '🌋', 'tag' => 'AKTIF', 'tag_color' => 'orange',
                    'title' => 'Pengungsian Erupsi Sinabung', 'location' => 'Karo, Sumatera Utara',
                    'target_amount' => 250000000, 'collected_amount' => 185000000,
                    'deadline' => now()->addDays(7),
                    'description' => 'Ratusan keluarga mengungsi akibat erupsi Gunung Sinabung. Bantuan untuk makanan, obat-obatan, dan fasilitas pengungsian sangat dibutuhkan.'
                ],
                [
                    'emoji' => '⛰️', 'tag' => 'AKTIF', 'tag_color' => 'green',
                    'title' => 'Longsor Purworejo — Pemulihan', 'location' => 'Purworejo, Jawa Tengah',
                    'target_amount' => 300000000, 'collected_amount' => 198000000,
                    'deadline' => now()->addDays(15),
                    'description' => 'Longsor melanda desa Bagelen, Purworejo. Dana dibutuhkan untuk evakuasi, pembersihan material longsor, dan bantuan korban.'
                ],
                [
                    'emoji' => '💨', 'tag' => 'BARU', 'tag_color' => 'purple',
                    'title' => 'Pemulihan Angin Puting Beliung NTB', 'location' => 'Mataram, Nusa Tenggara Barat',
                    'target_amount' => 150000000, 'collected_amount' => 42000000,
                    'deadline' => now()->addDays(21),
                    'description' => 'Angin puting beliung menghancurkan puluhan rumah di Mataram. Bantuan material bangunan dan logistik sangat mendesak.'
                ],
                [
                    'emoji' => '🌊', 'tag' => 'AKTIF', 'tag_color' => 'blue',
                    'title' => 'Banjir Bandang Kalimantan Selatan', 'location' => 'Banjarmasin, Kalimantan Selatan',
                    'target_amount' => 400000000, 'collected_amount' => 287000000,
                    'deadline' => now()->addDays(9),
                    'description' => 'Banjir bandang melanda beberapa kabupaten di Kalimantan Selatan. Ribuan jiwa terdampak dan butuh bantuan segera.'
                ]
            ];

            foreach ($defaults as $data) {
                \App\Models\Campaign::create(array_merge($data, [
                    'org_id' => $orgId,
                    'is_active' => true
                ]));
            }
        }

        // Get dynamic donations
        $donations = \App\Models\Donation::selectRaw('campaign_title, sum(amount) as total_amount, count(*) as donor_count')
            ->groupBy('campaign_title')
            ->get()
            ->keyBy('campaign_title');

        // Fetch campaigns from database
        $campaigns = \App\Models\Campaign::where('is_active', true)->orderBy('created_at', 'desc')->get();

        return $campaigns->map(function ($c) use ($donations) {
            $extraCollected = 0;
            $extraDonors = 0;

            if (isset($donations[$c->title])) {
                $extraCollected = $donations[$c->title]->total_amount;
                $extraDonors = $donations[$c->title]->donor_count;
            }

            // Normalise collected
            $collected = $c->collected_amount + $extraCollected;
            
            // Baseline donors fallback based on title matching
            $baseDonors = 100;
            if (stripos($c->title, 'Banjir Jakarta') !== false) $baseDonors = 2840;
            elseif (stripos($c->title, 'Cianjur') !== false) $baseDonors = 5120;
            elseif (stripos($c->title, 'Sinabung') !== false) $baseDonors = 1230;
            elseif (stripos($c->title, 'Purworejo') !== false) $baseDonors = 892;
            elseif (stripos($c->title, 'NTB') !== false) $baseDonors = 345;
            elseif (stripos($c->title, 'Kalimantan') !== false) $baseDonors = 2105;

            $donors = $baseDonors + $extraDonors;
            $pct = $c->target_amount > 0 ? min(100, round(($collected / $c->target_amount) * 100)) : 0;

            // Format deadline
            $diffDays = (int)ceil(now()->diffInDays(\Carbon\Carbon::parse($c->deadline), false));
            $deadlineStr = $diffDays > 0 ? "$diffDays hari lagi" : "Telah berakhir";

            return [
                'id' => $c->id,
                'emoji' => $c->emoji ?: '🆘',
                'tag' => $c->tag ?: 'AKTIF',
                'tagColor' => $c->tag_color ?: 'blue',
                'title' => $c->title,
                'location' => $c->location,
                'target' => (float)$c->target_amount,
                'collected' => (float)$collected,
                'pct' => $pct,
                'deadline' => $deadlineStr,
                'donors' => $donors,
                'desc' => $c->description,
                'urgent' => $c->tag === 'URGENT'
            ];
        });
    }
}

// Home / Landing Page
Route::get('/', function () {
    $campaigns = getCampaignsList()->take(3);
    $totalDonationsInDb = \App\Models\Donation::sum('amount');
    return view('welcome', compact('campaigns', 'totalDonationsInDb'));
})->name('home');

// About Page
Route::get('/about', function () {
    return view('about');
})->name('about');

// Volunteer Page
Route::get('/volunteer', function () {
    return view('volunteer');
})->name('volunteer');

// Donate Public Page (Campaign List)
Route::get('/donate', function () {
    $campaigns = getCampaignsList();
    $totalDonationsInDb = \App\Models\Donation::sum('amount');
    $recentDonations = \App\Models\Donation::with('user')->orderBy('created_at', 'desc')->take(10)->get();
    return view('donate', compact('campaigns', 'totalDonationsInDb', 'recentDonations'));
})->name('donate');

// Donate Campaign Detail
Route::get('/donate/campaign/{id}', function ($id) {
    $campaigns = getCampaignsList();
    $totalDonationsInDb = \App\Models\Donation::sum('amount');
    $recentDonations = \App\Models\Donation::with('user')->orderBy('created_at', 'desc')->take(10)->get();
    return view('donate', compact('campaigns', 'totalDonationsInDb', 'recentDonations'));
})->name('donate.campaign');

// Donation routes (Protected Action)
Route::middleware(['auth'])->group(function () {
    Route::get('/donate/form', [\App\Http\Controllers\DonationController::class, 'create'])->name('donate.form');
    Route::post('/donate/form', [\App\Http\Controllers\DonationController::class, 'store'])->name('donate.store');
    Route::get('/donate/{id}/receipt', [\App\Http\Controllers\DonationController::class, 'receipt'])->name('donate.receipt');
});

// Contact Page
Route::get('/contact', function () {
    return view('contact');
})->name('contact');

// Disaster Detail Page
Route::get('/disaster/{id}', function ($id) {
    // 1. Check if the report exists in the database
    $report = \App\Models\Report::with('user')->find($id);

    // 2. Define the static mock disasters list matching the home page
    $mockDisasters = [
        1 => [
            'id' => 1,
            'title' => 'Banjir Jakarta Utara',
            'type' => 'Banjir',
            'type_icon' => '🌊',
            'status' => 'KRITIS',
            'status_color' => 'red',
            'priority_score' => 9.2,
            'location' => 'Jakarta Utara, DKI Jakarta',
            'date' => '30 Mei 2026, 06:15 WIB',
            'views' => '12.450',
            'korban' => '2.847',
            'kerusakan' => '94%',
            'relawan' => '248',
            'bantuan' => '1.200',
            'image' => '/images/flood_case.png',
            'description' => 'Banjir besar melanda wilayah Jakarta Utara akibat curah hujan ekstrem yang melanda DKI Jakarta sejak dini hari. Ketinggian air mencapai 1,5–2 meter di beberapa kelurahan, menyebabkan ribuan warga harus mengungsi. Wilayah yang paling terdampak meliputi Kelurahan Penjaringan, Pluit, Kapuk Muara, dan Muara Baru. Infrastruktur seperti jalan, jembatan, dan fasilitas umum mengalami kerusakan signifikan.',
            'posko' => 'GOR Jakarta Utara, Jl. Yos Sudarso',
            'phone' => '+62 21-4567-8900',
            'needs' => [
                ['item' => 'Air Minum Bersih', 'pct' => 85, 'color' => 'blue'],
                ['item' => 'Makanan / Sembako', 'pct' => 72, 'color' => 'orange'],
                ['item' => 'Obat-obatan', 'pct' => 60, 'color' => 'red'],
                ['item' => 'Selimut & Pakaian', 'pct' => 45, 'color' => 'purple'],
                ['item' => 'Relawan Medis', 'pct' => 30, 'color' => 'green'],
            ]
        ],
        2 => [
            'id' => 2,
            'title' => 'Gempa 6.2 SR Cianjur',
            'type' => 'Gempa',
            'type_icon' => '🏔️',
            'status' => 'KRITIS',
            'status_color' => 'red',
            'priority_score' => 8.7,
            'location' => 'Cianjur, Jawa Barat',
            'date' => '30 Mei 2026, 13:21 WIB',
            'views' => '9.820',
            'korban' => '1.340',
            'kerusakan' => '87%',
            'relawan' => '180',
            'bantuan' => '850',
            'image' => '/images/earthquake_case.png',
            'description' => 'Gempa bumi tektonik berkekuatan 6.2 SR mengguncang Cianjur dan sekitarnya. Gempa dangkal ini mengakibatkan ribuan rumah warga roboh, tanah longsor di beberapa titik jalan utama, dan memutus akses listrik serta komunikasi di daerah episentrum.',
            'posko' => 'Lapangan Utama Cianjur, Jl. Siliwangi',
            'phone' => '+62 263-1234-567',
            'needs' => [
                ['item' => 'Tenda Darurat', 'pct' => 90, 'color' => 'blue'],
                ['item' => 'Selimut & Pakaian', 'pct' => 50, 'color' => 'purple'],
                ['item' => 'Air Bersih', 'pct' => 40, 'color' => 'blue'],
                ['item' => 'Obat-obatan', 'pct' => 75, 'color' => 'red'],
                ['item' => 'Relawan Medis', 'pct' => 55, 'color' => 'green'],
            ]
        ],
        3 => [
            'id' => 3,
            'title' => 'Banjir Banjarmasin',
            'type' => 'Banjir',
            'type_icon' => '🌊',
            'status' => 'SEDANG',
            'status_color' => 'orange',
            'priority_score' => 7.1,
            'location' => 'Banjarmasin, Kalimantan Selatan',
            'date' => '29 Mei 2026, 22:10 WIB',
            'views' => '6.450',
            'korban' => '4.210',
            'kerusakan' => '65%',
            'relawan' => '120',
            'bantuan' => '3.100',
            'image' => '/images/flood_case.png',
            'description' => 'Luapan Sungai Barito memicu banjir yang merendam sebagian besar kota Banjarmasin. Genangan air setinggi 50–100 cm mengganggu aktivitas perekonomian warga dan transportasi darat.',
            'posko' => 'Stadion Lambung Mangkurat, Banjarmasin',
            'phone' => '+62 511-987-654',
            'needs' => [
                ['item' => 'Makanan Siap Saji', 'pct' => 80, 'color' => 'orange'],
                ['item' => 'Air Bersih', 'pct' => 75, 'color' => 'blue'],
                ['item' => 'Obat-obatan', 'pct' => 50, 'color' => 'red'],
                ['item' => 'Perahu Karet', 'pct' => 90, 'color' => 'blue'],
            ]
        ],
        4 => [
            'id' => 4,
            'title' => 'Erupsi Gunung Sinabung',
            'type' => 'Gunung Api',
            'type_icon' => '🌋',
            'status' => 'WASPADA',
            'status_color' => 'yellow',
            'priority_score' => 6.4,
            'location' => 'Karo, Sumatera Utara',
            'date' => '28 Mei 2026, 08:30 WIB',
            'views' => '4.890',
            'korban' => '892 pengungsi',
            'kerusakan' => '45%',
            'relawan' => '95',
            'bantuan' => '600',
            'image' => '/images/cause3.png',
            'description' => 'Gunung Sinabung kembali meluncurkan guguran awan panas dan abu vulkanik tebal setinggi 2.000 meter ke arah tenggara. Warga diimbau menjauhi zona merah dalam radius 5 km dari puncak gunung.',
            'posko' => 'Kantor Camat Naman Teran, Karo',
            'phone' => '+62 628-765-432',
            'needs' => [
                ['item' => 'Masker', 'pct' => 95, 'color' => 'green'],
                ['item' => 'Tenda Pengungsian', 'pct' => 70, 'color' => 'blue'],
                ['item' => 'Makanan Bayi', 'pct' => 40, 'color' => 'orange'],
                ['item' => 'Air Bersih', 'pct' => 65, 'color' => 'blue'],
            ]
        ],
        5 => [
            'id' => 5,
            'title' => 'Banjir Denpasar',
            'type' => 'Banjir',
            'type_icon' => '🌊',
            'status' => 'TERKENDALI',
            'status_color' => 'green',
            'priority_score' => 4.2,
            'location' => 'Denpasar, Bali',
            'date' => '28 Mei 2026, 14:00 WIB',
            'views' => '3.120',
            'korban' => '340',
            'kerusakan' => '25%',
            'relawan' => '45',
            'bantuan' => '250',
            'image' => '/images/flood_case.png',
            'description' => 'Hujan deras berdurasi panjang menyebabkan sistem drainase perkotaan di Denpasar meluap. Banjir menggenangi jalan protokol dan pemukiman warga dengan ketinggian air 30–50 cm. Kondisi saat ini berangsur surut.',
            'posko' => 'Kantor BPBD Kota Denpasar, Jl. Imam Bonjol',
            'phone' => '+62 361-223344',
            'needs' => [
                ['item' => 'Alat Pembersih', 'pct' => 80, 'color' => 'orange'],
                ['item' => 'Air Bersih', 'pct' => 90, 'color' => 'blue'],
                ['item' => 'Sembako', 'pct' => 70, 'color' => 'orange'],
            ]
        ],
        6 => [
            'id' => 6,
            'title' => 'Longsor Purworejo',
            'type' => 'Longsor',
            'type_icon' => '⛰️',
            'status' => 'SEDANG',
            'status_color' => 'orange',
            'priority_score' => 6.8,
            'location' => 'Purworejo, Jawa Tengah',
            'date' => '27 Mei 2026, 18:45 WIB',
            'views' => '5.620',
            'korban' => '127',
            'kerusakan' => '55%',
            'relawan' => '80',
            'bantuan' => '350',
            'image' => '/images/cause1.png',
            'description' => 'Hujan lebat memicu tanah longsor yang menimbun jalan penghubung antar desa di wilayah Purworejo. Beberapa rumah warga mengalami kerusakan sedang akibat tertimbun material tanah dari tebing sekitar.',
            'posko' => 'Balai Desa Purworejo',
            'phone' => '+62 275-554433',
            'needs' => [
                ['item' => 'Alat Berat', 'pct' => 60, 'color' => 'red'],
                ['item' => 'Makanan Siap Saji', 'pct' => 85, 'color' => 'orange'],
                ['item' => 'Selimut', 'pct' => 50, 'color' => 'purple'],
            ]
        ],
        7 => [
            'id' => 7,
            'title' => 'Gempa Palu 5.8 SR',
            'type' => 'Gempa',
            'type_icon' => '🏔️',
            'status' => 'KRITIS',
            'status_color' => 'red',
            'priority_score' => 7.8,
            'location' => 'Palu, Sulawesi Tengah',
            'date' => '26 Mei 2026, 09:12 WIB',
            'views' => '7.840',
            'korban' => '445',
            'kerusakan' => '50%',
            'relawan' => '110',
            'bantuan' => '500',
            'image' => '/images/earthquake_case.png',
            'description' => 'Gempa bumi tektonik berkekuatan 5.8 SR mengguncang kota Palu dan sekitarnya. Gempa dirasakan cukup kuat selama beberapa detik, memicu kepanikan warga dan merusak beberapa fasilitas publik.',
            'posko' => 'GOR Palu, Jl. Siranindi',
            'phone' => '+62 451-443322',
            'needs' => [
                ['item' => 'Alat Medis', 'pct' => 70, 'color' => 'green'],
                ['item' => 'Air Bersih', 'pct' => 80, 'color' => 'blue'],
                ['item' => 'Selimut & Alas Tidur', 'pct' => 65, 'color' => 'purple'],
            ]
        ],
        8 => [
            'id' => 8,
            'title' => 'Banjir Bangka',
            'type' => 'Banjir',
            'type_icon' => '🌊',
            'status' => 'SEDANG',
            'status_color' => 'orange',
            'priority_score' => 5.5,
            'location' => 'Bangka, Kepulauan Bangka Belitung',
            'date' => '25 Mei 2026, 11:30 WIB',
            'views' => '4.210',
            'korban' => '680',
            'kerusakan' => '40%',
            'relawan' => '60',
            'bantuan' => '400',
            'image' => '/images/flood_case.png',
            'description' => 'Curah hujan tinggi disertai pasang air laut memicu banjir rob di kawasan pesisir Bangka. Ratusan rumah terendam air payau setinggi 60 cm.',
            'posko' => 'Posko Bersama Pesisir Bangka',
            'phone' => '+62 717-112233',
            'needs' => [
                ['item' => 'Air Bersih', 'pct' => 85, 'color' => 'blue'],
                ['item' => 'Makanan Siap Saji', 'pct' => 75, 'color' => 'orange'],
                ['item' => 'Obat Gatal & Kulit', 'pct' => 50, 'color' => 'red'],
            ]
        ],
        9 => [
            'id' => 9,
            'title' => 'Angin Kencang Kendari',
            'type' => 'Angin Kencang',
            'type_icon' => '💨',
            'status' => 'TERKENDALI',
            'status_color' => 'green',
            'priority_score' => 3.8,
            'location' => 'Kendari, Sulawesi Tenggara',
            'date' => '24 Mei 2026, 16:00 WIB',
            'views' => '2.890',
            'korban' => '89',
            'kerusakan' => '20%',
            'relawan' => '30',
            'bantuan' => '150',
            'image' => '/images/mid.png',
            'description' => 'Angin kencang disertai hujan deras merobohkan belasan pohon pelindung jalan dan merusak atap rumah warga di beberapa kecamatan di Kendari.',
            'posko' => 'Kantor Walikota Kendari',
            'phone' => '+62 401-221100',
            'needs' => [
                ['item' => 'Seng & Bahan Bangunan', 'pct' => 40, 'color' => 'red'],
                ['item' => 'Terpal Darurat', 'pct' => 80, 'color' => 'blue'],
                ['item' => 'Sembako', 'pct' => 90, 'color' => 'orange'],
            ]
        ],
        10 => [
            'id' => 10,
            'title' => 'Banjir Padang',
            'type' => 'Banjir',
            'type_icon' => '🌊',
            'status' => 'SEDANG',
            'status_color' => 'orange',
            'priority_score' => 6.0,
            'location' => 'Padang, Sumatera Barat',
            'date' => '23 Mei 2026, 15:45 WIB',
            'views' => '5.100',
            'korban' => '520',
            'kerusakan' => '50%',
            'relawan' => '70',
            'bantuan' => '450',
            'image' => '/images/flood_case.png',
            'description' => 'Hujan lebat yang merata menyebabkan Sungai Batang Arau meluap, memicu banjir bandang skala kecil di pemukiman sekitar bantaran sungai.',
            'posko' => 'Balai Kota Padang, Jl. Bagindo Aziz Chan',
            'phone' => '+62 751-445566',
            'needs' => [
                ['item' => 'Air Bersih', 'pct' => 80, 'color' => 'blue'],
                ['item' => 'Sembako', 'pct' => 85, 'color' => 'orange'],
                ['item' => 'Relawan Evakuasi', 'pct' => 60, 'color' => 'green'],
            ]
        ]
    ];

    $disaster = null;

    if (isset($mockDisasters[$id])) {
        $disaster = $mockDisasters[$id];
    } elseif ($report) {
        $priorityRel = \App\Models\PriorityScore::where('report_id', $report->id)->first();
        $priorityScore = $priorityRel ? $priorityRel->score : $report->priority_score;
        $level = $priorityRel ? $priorityRel->level : 'Sedang';

        $statusColor = 'orange';
        if (strtolower($level) === 'kritis') $statusColor = 'red';
        elseif (strtolower($level) === 'tinggi') $statusColor = 'red';
        elseif (strtolower($level) === 'terkendali' || strtolower($level) === 'rendah') $statusColor = 'green';

        $typeIcons = [
            'Banjir' => '🌊',
            'Gempa' => '🏔️',
            'Gempa Bumi' => '🏔️',
            'Gunung Api' => '🌋',
            'Gunung' => '🌋',
            'Longsor' => '⛰️',
            'Tanah Longsor' => '⛰️',
            'Angin' => '💨',
            'Angin Kencang' => '💨',
            'Angin Topan' => '💨',
        ];
        
        $typeIcon = '⚠';
        foreach ($typeIcons as $k => $v) {
            if (stripos($report->jenis_bencana, $k) !== false) {
                $typeIcon = $v;
                break;
            }
        }

        $needs = [];
        if ($report->kebutuhan_mendesak) {
            $splitNeeds = explode(',', $report->kebutuhan_mendesak);
            $colors = ['blue', 'orange', 'red', 'purple', 'green'];
            foreach ($splitNeeds as $idxNeed => $valNeed) {
                $valNeed = trim($valNeed);
                if ($valNeed) {
                    $needs[] = [
                        'item' => $valNeed,
                        'pct' => rand(30, 85),
                        'color' => $colors[$idxNeed % count($colors)]
                    ];
                }
            }
        }
        if (empty($needs)) {
            $needs = [
                ['item' => 'Air Bersih', 'pct' => 60, 'color' => 'blue'],
                ['item' => 'Makanan Siap Saji', 'pct' => 50, 'color' => 'orange'],
            ];
        }

        $disaster = [
            'id' => $report->id,
            'title' => $report->jenis_bencana . ' - ' . ($report->alamat_lengkap ? explode(',', $report->alamat_lengkap)[0] : 'Lokasi Terdampak'),
            'type' => $report->jenis_bencana,
            'type_icon' => $typeIcon,
            'status' => strtoupper($level),
            'status_color' => $statusColor,
            'priority_score' => number_format($priorityScore / 10, 1),
            'location' => $report->alamat_lengkap ?: 'Tidak Diketahui',
            'date' => $report->created_at->timezone('Asia/Jakarta')->format('d M Y, H:i') . ' WIB',
            'views' => number_format(rand(100, 1000)),
            'korban' => number_format($report->jumlah_korban),
            'kerusakan' => $report->tingkat_kerusakan ?: 'Sedang',
            'relawan' => rand(10, 80),
            'bantuan' => number_format(rand(100, 1000)),
            'image' => $report->foto_path ? \Illuminate\Support\Facades\Storage::url($report->foto_path) : '/images/flood_case.png',
            'description' => $report->deskripsi_kondisi,
            'posko' => 'Posko Lapangan ' . ($report->alamat_lengkap ? explode(',', $report->alamat_lengkap)[0] : ''),
            'phone' => '+62 812-3456-7890',
            'needs' => $needs
        ];
    } else {
        abort(404);
    }

    return view('disaster-detail', compact('disaster'));
})->name('disaster.detail');

// News Pages — redirect ke halaman utama sambil highlight section berita
Route::get('/news', function () {
    return redirect()->route('home')->with('section', 'news');
})->name('news.index');

Route::get('/news/{id}', function ($id) {
    return redirect()->route('home')->with('section', 'news');
})->name('news.detail');

// Public Map — tampilkan halaman peta bencana aktif dengan marker Leaflet
Route::get('/peta-bencana', function () {
    $reports = \App\Models\Report::whereNotNull('latitude')
        ->whereNotNull('longitude')
        ->whereIn('status', ['Verified', 'Approved', 'In Progress'])
        ->get();
    return view('peta-bencana', compact('reports'));
})->name('peta.bencana');

// Public Analytics — tampilkan halaman analitik publik
Route::get('/analytics', function () {
    $totalLaporan = \App\Models\Report::count();
    $totalDonasi  = \App\Models\Donation::where('status', 'Verified')->sum('amount');
    $totalRelawan = \App\Models\User::whereHas('roles', fn($q) => $q->where('name', 'Relawan'))->count();
    $disasterTypes = \App\Models\Report::select('jenis_bencana', \Illuminate\Support\Facades\DB::raw('count(*) as total'))
        ->groupBy('jenis_bencana')->orderByDesc('total')->take(8)->get();
    return view('analytics-publik', compact('totalLaporan', 'totalDonasi', 'totalRelawan', 'disasterTypes'));
})->name('analytics');


// Terms & Privacy
Route::get('/terms', function () {
    return view('terms');
})->name('terms');

Route::get('/privacy', function () {
    return view('privacy');
})->name('privacy');

Route::get('/help', function () {
    return view('contact');
})->name('help');

// Laporkan Bencana (redirect ke dashboard atau halaman report)
Route::get('/report', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
})->name('report');

// =============================================
// AUTH DASHBOARD
// =============================================
Route::get('/auth/google', [\App\Http\Controllers\Auth\GoogleAuthController::class, 'redirect'])->name('google.login');
Route::get('/auth/google/callback', [\App\Http\Controllers\Auth\GoogleAuthController::class, 'callback']);

Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    // Centers
    Route::get('/volunteer-center', [\App\Http\Controllers\CenterController::class, 'volunteer'])->middleware('role:Relawan')->name('center.volunteer');
    Route::get('/organization-center', [\App\Http\Controllers\CenterController::class, 'organization'])->middleware('role:Organisasi Bantuan')->name('center.organization');
    Route::get('/admin-center', [\App\Http\Controllers\CenterController::class, 'admin'])->middleware('role:Admin')->name('center.admin');

    // Applications
    Route::get('/apply/volunteer', [\App\Http\Controllers\ApplicationController::class, 'createVolunteer'])->name('apply.volunteer');
    Route::post('/apply/volunteer', [\App\Http\Controllers\ApplicationController::class, 'storeVolunteer']);
    
    Route::get('/apply/organization', [\App\Http\Controllers\ApplicationController::class, 'createOrganization'])->name('apply.organization');
    Route::post('/apply/organization', [\App\Http\Controllers\ApplicationController::class, 'storeOrganization']);

    Route::post('/report/store', [\App\Http\Controllers\ReportController::class, 'store'])->name('report.store');
    
    // Report Chat Routes
    Route::get('/report/{id}/chat', [\App\Http\Controllers\ReportChatController::class, 'getMessages'])->name('report.chat.get');
    Route::post('/report/{id}/chat', [\App\Http\Controllers\ReportChatController::class, 'sendMessage'])->name('report.chat.send');
    // Volunteer task status update (relawan update tugas mereka sendiri)
    Route::post('/volunteer/task/{id}/update', [\App\Http\Controllers\CenterController::class, 'updateTaskStatus'])->name('center.volunteer.task.update');
    Route::post('/volunteer/profile/update', [\App\Http\Controllers\CenterController::class, 'updateProfile'])->middleware('role:Relawan')->name('center.volunteer.profile.update');
    Route::post('/volunteer/availability/toggle', [\App\Http\Controllers\CenterController::class, 'toggleAvailability'])->middleware('role:Relawan')->name('center.volunteer.availability.toggle');
    Route::post('/volunteer/task/claim', [\App\Http\Controllers\CenterController::class, 'claimTask'])->middleware('role:Relawan')->name('center.volunteer.task.claim');
});

// Admin Routes
Route::middleware(['auth', 'role:Admin'])->prefix('admin')->name('admin.')->group(function () {
    $ctrl = \App\Http\Controllers\AdminDashboardController::class;

    // ── Overview ──────────────────────────────────
    Route::get('/dashboard', [$ctrl, 'index'])->name('dashboard');

    // ── Disaster Reports ──────────────────────────
    Route::get('/laporan', [$ctrl, 'laporan'])->name('laporan');
    Route::post('/laporan/{id}/verify', [$ctrl, 'verifyReport'])->name('laporan.verify');
    Route::get('/laporan/export', [$ctrl, 'exportReports'])->name('laporan.export');

    // ── Verification Center ───────────────────────
    Route::get('/verifikasi', [$ctrl, 'verifikasi'])->name('verifikasi');
    Route::post('/apply/volunteer/{id}/verify', [$ctrl, 'verifyVolunteerApplication'])->name('apply.volunteer.verify');
    Route::post('/apply/organization/{id}/verify', [$ctrl, 'verifyOrganizationApplication'])->name('apply.organization.verify');

    // ── GIS Map ───────────────────────────────────
    Route::get('/peta', [$ctrl, 'peta'])->name('peta');

    // ── Volunteer Management ──────────────────────
    Route::get('/relawan', [$ctrl, 'relawan'])->name('relawan');
    Route::post('/relawan/assign', [$ctrl, 'assignVolunteer'])->name('relawan.assign');
    Route::get('/penugasan', [$ctrl, 'penugasan'])->name('penugasan');

    // ── Donation Management ───────────────────────
    Route::get('/donasi', [$ctrl, 'donasi'])->name('donasi');
    Route::post('/donasi/{id}/verify', [$ctrl, 'verifyDonation'])->name('donasi.verify');
    Route::get('/donasi/export', [$ctrl, 'exportDonations'])->name('donasi.export');

    // ── Campaign Management ───────────────────────
    Route::get('/campaign', [$ctrl, 'campaign'])->name('campaign');
    Route::post('/campaign', [$ctrl, 'campaignStore'])->name('campaign.store');
    Route::patch('/campaign/{id}', [$ctrl, 'campaignUpdate'])->name('campaign.update');
    Route::delete('/campaign/{id}', [$ctrl, 'campaignDestroy'])->name('campaign.destroy');

    // ── Aid Distribution ──────────────────────────
    Route::get('/kebutuhan', [$ctrl, 'kebutuhan'])->name('kebutuhan');
    Route::post('/kebutuhan/{id}/update-status', [$ctrl, 'updateKebutuhanStatus'])->name('kebutuhan.update-status');

    // ── Volunteer Task Status ──────────────────────
    Route::post('/penugasan/{id}/update-status', [$ctrl, 'updateTaskStatus'])->name('penugasan.update-status');

    // ── User Management ───────────────────────────
    Route::get('/pengguna', [$ctrl, 'pengguna'])->name('pengguna');
    Route::patch('/pengguna/{id}', [$ctrl, 'updateUser'])->name('pengguna.update');
    Route::post('/pengguna/{id}/suspend', [$ctrl, 'suspendUser'])->name('pengguna.suspend');
    Route::delete('/pengguna/{id}', [$ctrl, 'destroyUser'])->name('pengguna.destroy');

    // ── Role Management ───────────────────────────
    Route::get('/roles', [$ctrl, 'roleManagement'])->name('roles');

    // ── Analytics ─────────────────────────────────
    Route::get('/analitik', [$ctrl, 'analitik'])->name('analitik');

    // ── Emergency Broadcast ───────────────────────
    Route::get('/notifikasi', [$ctrl, 'notifikasi'])->name('notifikasi');
    Route::post('/notifikasi/broadcast', [$ctrl, 'broadcast'])->name('broadcast');

    // ── System Settings ───────────────────────────
    Route::get('/pengaturan', [$ctrl, 'pengaturan'])->name('pengaturan');
    Route::post('/pengaturan/save', [$ctrl, 'saveSettings'])->name('pengaturan.save');
    Route::post('/pengaturan/defcon', [$ctrl, 'activateDefcon'])->name('pengaturan.defcon');

    // ── Legacy ───────────────────────────────────
    Route::get('/komunikasi', [$ctrl, 'komunikasi'])->name('komunikasi');
    Route::post('/komunikasi/reply', [$ctrl, 'komunikasiReply'])->name('komunikasi.reply');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
