<?php
/**
 * FILE: index.php
 * FUNGSI: Halaman utama untuk menampilkan daftar tiket penonton
 * * TAHAP 6: Menampilkan data tiket yang dikelompokkan per jenis studio
 */

// Include koneksi database
require_once 'config/database.php';

// Include semua class
require_once 'classes/Tiket.php';
require_once 'classes/TiketRegular.php';
require_once 'classes/TiketIMAX.php';
require_once 'classes/TiketVelvet.php';

// Fungsi untuk format Rupiah
function formatRupiah($angka)
{
    return 'Rp ' . number_format($angka, 0, ',', '.');
}

// Ambil semua data dari database
$stmt = $pdo->query("SELECT * FROM tabel_tiket ORDER BY 
                     FIELD(jenis_studio, 'Regular', 'IMAX', 'Velvet'), 
                     id_tiket");
$dataTiket = $stmt->fetchAll();

// Array untuk menyimpan objek tiket per kategori
$tikets = [
    'Regular' => [],
    'IMAX' => [],
    'Velvet' => []
];

// Loop data dan buat objek sesuai jenis studio
foreach ($dataTiket as $row) {
    switch ($row['jenis_studio']) {
        case 'Regular':
            $tiket = new TiketRegular(
                $row['id_tiket'],
                $row['nama_film'],
                $row['jadwal_tayang'],
                $row['jumlah_kursi'],
                $row['harga_dasar_tiket'],
                $row['tipe_audio'],
                $row['lokasi_baris']
            );
            $tikets['Regular'][] = $tiket;
            break;
            
        case 'IMAX':
            $tiket = new TiketIMAX(
                $row['id_tiket'],
                $row['nama_film'],
                $row['jadwal_tayang'],
                $row['jumlah_kursi'],
                $row['harga_dasar_tiket'],
                $row['kacamata_3d_id'],
                $row['efek_gerak_fitur']
            );
            $tikets['IMAX'][] = $tiket;
            break;
            
        case 'Velvet':
            $tiket = new TiketVelvet(
                $row['id_tiket'],
                $row['nama_film'],
                $row['jadwal_tayang'],
                $row['jumlah_kursi'],
                $row['harga_dasar_tiket'],
                $row['bantal_selimut_pack'],
                $row['layanan_butler']
            );
            $tikets['Velvet'][] = $tiket;
            break;
    }
}

// Fungsi untuk mendapatkan warna badge
function getBadgeColor($studio)
{
    $colors = [
        'Regular' => 'success',
        'IMAX' => 'primary',
        'Velvet' => 'danger'
    ];
    return $colors[$studio] ?? 'secondary';
}

// Fungsi untuk mendapatkan icon studio
function getStudioIcon($studio)
{
    $icons = [
        'Regular' => '🎫',
        'IMAX' => '🎬',
        'Velvet' => '👑'
    ];
    return $icons[$studio] ?? '🎟️';
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Manajemen Tiket Bioskop</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f4f6f9;
            color: #2d3748;
        }
        
        .header-panel {
            background: linear-gradient(135deg, #1e293b, #0f172a);
            box-shadow: 0 10px 25px rgba(15, 23, 42, 0.15);
        }

        .studio-header {
            padding: 16px 24px;
            border-radius: 12px;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }
        
        /* Pewarnaan baru yang lebih teduh & premium (Pastel-ish) */
        .studio-regular {
            background-color: #e6f4ea;
            border-left: 5px solid #34a853;
            color: #137333;
        }
        
        .studio-imax {
            background-color: #e8f0fe;
            border-left: 5px solid #1a73e8;
            color: #174ea6;
        }
        
        .studio-velvet {
            background-color: #fce8e6;
            border-left: 5px solid #d93025;
            color: #a51d24;
        }
        
        .fasilitas-box {
            background: #f8fafc;
            padding: 14px;
            border-radius: 10px;
            margin-top: 15px;
            font-size: 0.9rem;
            border: 1px solid #edf2f7;
            color: #4a5568;
        }
        
        .fasilitas-box i {
            width: 25px;
            color: #4a5568;
        }
        
        .card-tiket {
            border: 1px solid #e2e8f0;
            border-radius: 14px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            background: #ffffff;
        }
        
        .card-tiket:hover {
            transform: translateY(-6px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.07), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            border-color: #cbd5e1;
        }
        
        .badge-custom {
            font-weight: 500;
            padding: 6px 12px;
            border-radius: 8px;
        }
        
        .film-title {
            font-weight: 700;
            font-size: 1.25rem;
            color: #1e293b;
            line-height: 1.4;
        }
        
        .footer-custom {
            margin-top: 50px;
            padding: 30px;
            background: #ffffff;
            border-radius: 16px;
            text-align: center;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            border: 1px solid #e2e8f0;
        }

        .price-box {
            border-radius: 10px;
            padding: 10px;
            height: 100%;
        }
    </style>
</head>
<body>
    
    <div class="container py-5">
        <div class="row mb-5">
            <div class="col-12">
                <div class="header-panel text-white p-5 rounded-4">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                        <div>
                            <h1 class="fw-bold mb-2" style="letter-spacing: -1px;">
                                <i class="fas fa-film text-warning me-2"></i> Manajemen Tiket Bioskop
                            </h1>
                            <p class="text-white-50 lead mb-0">
                                <i class="fas fa-ticket-alt me-2"></i>
                                Total Tiket: <span class="badge bg-light text-dark fw-bold"><?= count($dataTiket) ?></span>
                                <span class="ms-2 badge bg-success bg-opacity-25 text-success badge-custom">Regular: <?= count($tikets['Regular']) ?></span>
                                <span class="badge bg-primary bg-opacity-25 text-primary badge-custom">IMAX: <?= count($tikets['IMAX']) ?></span>
                                <span class="badge bg-danger bg-opacity-25 text-danger badge-custom">Velvet: <?= count($tikets['Velvet']) ?></span>
                            </p>
                        </div>
                        <div>
                            <span class="badge bg-blur text-white p-3 fs-6 rounded-3" style="background: rgba(255,255,255,0.1); backdrop-filter: blur(5px);">
                                <i class="fas fa-calendar-alt text-warning me-2"></i>
                                <?= date('d F Y') ?>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <?php foreach (['Regular', 'IMAX', 'Velvet'] as $studio): ?>
            <?php if (!empty($tikets[$studio])): ?>
                <div class="row mb-5">
                    <div class="col-12">
                        <div class="studio-header studio-<?= strtolower($studio) ?>">
                            <div>
                                <h3 class="mb-0 fw-bold d-flex align-items-center gap-2">
                                    <span><?= getStudioIcon($studio) ?></span> Studio <?= $studio ?>
                                    <span class="badge bg-white text-dark fs-6 ms-2 shadow-sm rounded-pill px-3">
                                        <?= count($tikets[$studio]) ?> Tiket
                                    </span>
                                </h3>
                            </div>
                            <div class="d-none d-sm-block">
                                <small class="opacity-75">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Klik pada tiket untuk melihat detail fasilitas
                                </small>
                            </div>
                        </div>
                        
                        <div class="row g-4">
                            <?php foreach ($tikets[$studio] as $tiket): ?>
                                <div class="col-md-6 col-lg-4">
                                    <div class="card card-tiket shadow-sm h-100">
                                        <div class="card-body d-flex flex-column p-4">
                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <span class="badge bg-light text-secondary border px-2.5 py-1.5 rounded-3">
                                                    <i class="fas fa-hashtag me-1"></i>ID: <?= $tiket->getIdTiket() ?>
                                                </span>
                                                <span class="badge bg-<?= getBadgeColor($studio) ?> bg-opacity-10 text-<?= getBadgeColor($studio) ?> fw-semibold px-2.5 py-1.5 rounded-3">
                                                    <?= getStudioIcon($studio) ?> <?= $studio ?>
                                                </span>
                                            </div>
                                            
                                            <h5 class="card-title film-title mb-3">
                                                <?= htmlspecialchars($tiket->getNamaFilm()) ?>
                                            </h5>
                                            
                                            <div class="mb-4 text-secondary fs-7">
                                                <div class="d-flex flex-wrap gap-3">
                                                    <span><i class="fas fa-calendar text-muted me-1"></i> <?= date('d M Y', strtotime($tiket->getJadwalTayang())) ?></span>
                                                    <span><i class="fas fa-clock text-muted me-1"></i> <?= date('H:i', strtotime($tiket->getJadwalTayang())) ?></span>
                                                    <span><i class="fas fa-chair text-muted me-1"></i> <?= $tiket->getJumlahKursi() ?> Kursi</span>
                                                </div>
                                            </div>
                                            
                                            <div class="row g-2 mb-2 mt-auto">
                                                <div class="col-6">
                                                    <div class="price-box border bg-light text-center">
                                                        <small class="text-muted d-block" style="font-size: 0.75rem;">Harga Dasar</small>
                                                        <span class="fw-semibold text-dark" style="font-size: 0.9rem;"><?= formatRupiah($tiket->getHargaDasarTiket()) ?></span>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="price-box text-center <?= $studio == 'Regular' ? 'bg-success bg-opacity-10' : ($studio == 'IMAX' ? 'bg-primary bg-opacity-10' : 'bg-danger bg-opacity-10') ?>">
                                                        <small class="text-muted d-block" style="font-size: 0.75rem;">Total Harga</small>
                                                        <span class="fw-bold <?= $studio == 'Regular' ? 'text-success' : ($studio == 'IMAX' ? 'text-primary' : 'text-danger') ?>" style="font-size: 0.9rem;">
                                                            <?= formatRupiah($tiket->hitungTotalHarga()) ?>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="fasilitas-box">
                                                <?php $tiket->tampilkanInfoFasilitas(); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
        
        <div class="footer-custom">
            <div class="row g-3">
                <div class="col-md-4">
                    <h6 class="fw-bold text-dark"><i class="fas fa-code text-primary me-2"></i>Tahap 6 - View</h6>
                    <small class="text-muted">Implementasi Polimorfisme PHP</small>
                </div>
                <div class="col-md-4">
                    <h6 class="fw-bold text-dark"><i class="fas fa-ticket text-danger me-2"></i>Total Tiket</h6>
                    <small class="text-muted">
                        Regular: <?= count($tikets['Regular']) ?> | 
                        IMAX: <?= count($tikets['IMAX']) ?> | 
                        Velvet: <?= count($tikets['Velvet']) ?>
                    </small>
                </div>
                <div class="col-md-4">
                    <h6 class="fw-bold text-dark"><i class="fas fa-database text-success me-2"></i>Database</h6>
                    <small class="text-muted text-break">
                        db_latihan_pbo_trpl1b_kristiana_setyaningsih
                    </small>
                </div>
            </div>
            <hr class="my-4 text-muted opacity-25">
            <small class="text-muted fw-medium">
                <i class="fas fa-graduation-cap me-1 text-secondary"></i>
                Praktikum PBO - Sistem Manajemen Tiket & Fasilitas Studio Bioskop
            </small>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
</body>
</html>