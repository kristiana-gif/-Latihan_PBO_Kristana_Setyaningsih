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
    
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&family=Space+Grotesk:wght@500;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --bg-main: #0b0f19;
            --bg-card: #151c2c;
            --bg-input: #1e2640;
            --text-muted: #94a3b8;
            --accent-gold: #ffb800;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-main);
            color: #f8fafc;
            overflow-x: hidden;
        }
        
        /* Glassmorphism Hero Header */
        .hero-section {
            background: radial-gradient(circle at top right, rgba(255, 184, 0, 0.15), transparent), 
                        linear-gradient(135deg, #151c2c, #0b0f19);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 24px;
            padding: 40px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.3);
        }

        .main-title {
            font-family: 'Space Grotesk', sans-serif;
            font-weight: 700;
            background: linear-gradient(45deg, #ffffff, #ffb800);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* Studio Category Headers */
        .studio-title-box {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding-bottom: 12px;
            margin-bottom: 30px;
            border-bottom: 2px solid rgba(255, 255, 255, 0.05);
        }

        .studio-indicator {
            display: inline-block;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            margin-right: 10px;
        }

        .indicator-regular { background-color: #10b981; box-shadow: 0 0 12px #10b981; }
        .indicator-imax { background-color: #3b82f6; box-shadow: 0 0 12px #3b82f6; }
        .indicator-velvet { background-color: #ef4444; box-shadow: 0 0 12px #ef4444; }
        
        /* Cyber-Cinema Card Design */
        .card-tiket {
            background: var(--bg-card);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 20px;
            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
            position: relative;
            overflow: hidden;
        }
        
        .card-tiket::before {
            content: '';
            position: absolute;
            top: 0; left: 0; width: 100%; height: 4px;
            background: transparent;
            transition: all 0.3s;
        }

        .card-regular:hover::before { background: #10b981; }
        .card-imax:hover::before { background: #3b82f6; }
        .card-velvet:hover::before { background: #ef4444; }

        .card-tiket:hover {
            transform: translateY(-8px) scale(1.01);
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.4);
            border-color: rgba(255, 255, 255, 0.15);
        }
        
        .film-title {
            font-family: 'Space Grotesk', sans-serif;
            font-weight: 700;
            font-size: 1.35rem;
            color: #ffffff;
            letter-spacing: -0.5px;
        }
        
        /* Neon Badges */
        .badge-id {
            background: rgba(255, 255, 255, 0.06);
            color: var(--text-muted);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        /* Pricing Area styled like an admission ticket stub */
        .ticket-stub-price {
            background: rgba(255, 255, 255, 0.02);
            border: 1px dashed rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            padding: 12px;
        }

        /* Polymorphic Facilities Section */
        .fasilitas-box {
            background: rgba(255, 255, 255, 0.03);
            padding: 14px 16px;
            border-radius: 12px;
            font-size: 0.88rem;
            color: #cbd5e1;
            border-left: 3px solid var(--accent-gold);
        }
        
        .fasilitas-box i {
            color: var(--accent-gold);
            margin-right: 8px;
        }
        
        /* Futuristic Footer */
        .footer-custom {
            margin-top: 80px;
            padding: 40px;
            background: var(--bg-card);
            border-radius: 24px;
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .text-muted-custom {
            color: var(--text-muted);
        }
    </style>
</head>
<body>
    
    <div class="container py-5">
        <div class="row mb-5">
            <div class="col-12">
                <div class="hero-section text-white">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-4">
                        <div>
                            <span class="badge mb-2 text-uppercase tracking-wider" style="background: rgba(255,184,0,0.1); color: var(--accent-gold); font-size: 0.75rem; font-weight:700; padding: 6px 12px; border-radius: 20px;">
                                <i class="fas fa-circle-play me-1"></i> Live Cinema Dashboard
                            </span>
                            <h1 class="display-6 main-title mb-2">
                                Manajemen Tiket Bioskop
                            </h1>
                            <div class="d-flex flex-wrap gap-2 mt-3" style="font-size: 0.85rem;">
                                <span class="badge badge-id py-2 px-3">Total Data: <strong><?= count($dataTiket) ?></strong></span>
                                <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 py-2 px-3">Regular (<?= count($tikets['Regular']) ?>)</span>
                                <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 py-2 px-3">IMAX (<?= count($tikets['IMAX']) ?>)</span>
                                <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 py-2 px-3">Velvet (<?= count($tikets['Velvet']) ?>)</span>
                            </div>
                        </div>
                        <div>
                            <div class="p-3 text-center rounded-4 border" style="background: rgba(255,255,255,0.02); border-color: rgba(255,255,255,0.05) !important; min-width: 160px;">
                                <small class="text-muted-custom d-block mb-1 text-uppercase fw-bold" style="font-size: 0.65rem; letter-spacing: 1px;">Sistem Waktu</small>
                                <span class="fw-bold text-white" style="font-size: 0.95rem;">
                                    <?= date('d M Y') ?>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <?php foreach (['Regular', 'IMAX', 'Velvet'] as $studio): ?>
            <?php if (!empty($tikets[$studio])): ?>
                <div class="row mb-5">
                    <div class="col-12">
                        <div class="studio-title-box">
                            <h3 class="mb-0 fw-bold fs-4 d-flex align-items-center">
                                <span class="studio-indicator indicator-<?= strtolower($studio) ?>"></span>
                                <?= getStudioIcon($studio) ?> <span class="ms-2">Studio <?= $studio ?></span>
                                <span class="badge rounded-pill ms-3 fs-6" style="background: rgba(255,255,255,0.05); color:#ffffff; font-weight: 500;">
                                    <?= count($tikets[$studio]) ?> Movie
                                </span>
                            </h3>
                            <small class="text-muted-custom d-none d-md-inline-block">
                                <i class="fa-solid fa-wand-magic-sparkles text-warning me-1"></i> Polimorfisme rendered successfully
                            </small>
                        </div>
                        
                        <div class="row g-4">
                            <?php foreach ($tikets[$studio] as $tiket): ?>
                                <div class="col-md-6 col-lg-4">
                                    <div class="card card-tiket card-<?= strtolower($studio) ?> h-100">
                                        <div class="card-body d-flex flex-column p-4">
                                            
                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <span class="badge badge-id px-2.5 py-1.5 rounded-3" style="font-size: 0.75rem;">
                                                    <i class="fas fa-fingerprint me-1"></i>ID: <?= $tiket->getIdTiket() ?>
                                                </span>
                                                <span class="text-uppercase fw-bold text-muted-custom" style="font-size: 0.7rem; letter-spacing: 1.5px;">
                                                    <?= $studio ?> Class
                                                </span>
                                            </div>
                                            
                                            <h5 class="card-title film-title mb-3">
                                                <?= htmlspecialchars($tiket->getNamaFilm()) ?>
                                            </h5>
                                            
                                            <div class="mb-4 text-muted-custom" style="font-size: 0.8rem;">
                                                <div class="d-flex flex-wrap gap-3">
                                                    <span><i class="fa-regular fa-calendar me-1.5 text-white-50"></i><?= date('d M Y', strtotime($tiket->getJadwalTayang())) ?></span>
                                                    <span><i class="fa-regular fa-clock me-1.5 text-white-50"></i><?= date('H:i', strtotime($tiket->getJadwalTayang())) ?></span>
                                                    <span><i class="fa-solid fa-couch me-1.5 text-white-50"></i><?= $tiket->getJumlahKursi() ?> Seats</span>
                                                </div>
                                            </div>
                                            
                                            <div class="ticket-stub-price mt-auto mb-3">
                                                <div class="row align-items-center">
                                                    <div class="col-6 border-end border-secondary border-opacity-25">
                                                        <small class="text-muted-custom d-block" style="font-size: 0.7rem;">Harga Dasar</small>
                                                        <span class="text-white-50 fw-medium" style="font-size: 0.85rem;"><?= formatRupiah($tiket->getHargaDasarTiket()) ?></span>
                                                    </div>
                                                    <div class="col-6 ps-3">
                                                        <small class="text-muted-custom d-block" style="font-size: 0.7rem;">Total Bayar</small>
                                                        <span class="fw-bold" style="font-size: 1rem; color: var(--accent-gold);">
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
            <div class="row g-4 text-center text-md-start">
                <div class="col-md-4">
                    <h6 class="fw-bold text-white mb-2"><i class="fas fa-layer-group text-warning me-2"></i>Arsitektur Proyek</h6>
                    <small class="text-muted-custom d-block mb-1">Tahap 6 - Polimorfisme View</small>
                    <small class="badge bg-white bg-opacity-5 text-muted-custom">PHP Object Oriented</small>
                </div>
                <div class="col-md-4">
                    <h6 class="fw-bold text-white mb-2"><i class="fas fa-chart-pie text-warning me-2"></i>Alokasi Objek</h6>
                    <small class="text-muted-custom d-block">
                        Reg: <?= count($tikets['Regular']) ?> Slot | 
                        IMAX: <?= count($tikets['IMAX']) ?> Slot | 
                        Velvet: <?= count($tikets['Velvet']) ?> Slot
                    </small>
                </div>
                <div class="col-md-4">
                    <h6 class="fw-bold text-white mb-2"><i class="fas fa-database text-warning me-2"></i>Sumber Data</h6>
                    <small class="text-muted-custom text-break d-block" style="font-size: 0.8rem;">
                        db_latihan_pbo_trpl1b_kristiana_setyaningsih
                    </small>
                </div>
            </div>
            <hr class="my-4 rgba(255,255,255,0.05)" style="border-color: rgba(255,255,255,0.05) !important;">
            <div class="text-center">
                <small class="text-muted-custom" style="font-size: 0.8rem;">
                    <i class="fas fa-graduation-cap me-1"></i>
                    Praktikum PBO &bull; Sistem Manajemen Tiket Bioskop Modern
                </small>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
</body>
</html>