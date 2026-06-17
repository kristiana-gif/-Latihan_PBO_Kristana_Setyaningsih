<?php
/**
 * FILE: index.php
 * FUNGSI: Halaman utama untuk menampilkan daftar tiket penonton
 * 
 * TAHAP 6: Menampilkan data tiket yang dikelompokkan per jenis studio
 * - Mengambil data dari database
 * - Instansiasi objek sesuai jenis_studio
 * - Menampilkan dalam tabel HTML yang rapi
 * - Memanggil method polimorfik: hitungTotalHarga() dan tampilkanInfoFasilitas()
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

// Ambil semua data dari database, urutkan berdasarkan jenis studio
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
    
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome 6 (untuk icon) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        /* Custom CSS tambahan */
        .studio-header {
            padding: 15px 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        
        .studio-regular {
            background: linear-gradient(135deg, #d4edda, #b7e4c7);
            border-left: 5px solid #28a745;
        }
        
        .studio-imax {
            background: linear-gradient(135deg, #cce5ff, #b8d4f0);
            border-left: 5px solid #007bff;
        }
        
        .studio-velvet {
            background: linear-gradient(135deg, #f8d7da, #f5c6cb);
            border-left: 5px solid #dc3545;
        }
        
        .fasilitas-box {
            background: #f8f9fa;
            padding: 12px 15px;
            border-radius: 8px;
            margin-top: 5px;
            font-size: 0.95rem;
        }
        
        .fasilitas-box i {
            width: 25px;
            color: #6c757d;
        }
        
        .total-harga {
            font-size: 1.1rem;
            font-weight: bold;
            color: #28a745;
        }
        
        .total-harga-imax {
            color: #007bff;
        }
        
        .total-harga-velvet {
            color: #dc3545;
        }
        
        .card-tiket {
            transition: transform 0.2s;
            height: 100%;
        }
        
        .card-tiket:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        
        .badge-studio {
            font-size: 0.9rem;
            padding: 8px 15px;
        }
        
        .film-title {
            font-weight: 600;
            font-size: 1.2rem;
        }
        
        .footer-custom {
            margin-top: 40px;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 10px;
            text-align: center;
        }
    </style>
</head>
<body>
    
    <div class="container-fluid py-4">
        <!-- HEADER -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="bg-dark text-white p-4 rounded-3">
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <div>
                            <h1 class="display-5 fw-bold">
                                <i class="fas fa-film me-2"></i> Manajemen Tiket Bioskop
                            </h1>
                            <p class="lead mb-0">
                                <i class="fas fa-ticket-alt me-2"></i>
                                Total Tiket: <strong><?= count($dataTiket) ?></strong> | 
                                <span class="badge bg-success">Regular: <?= count($tikets['Regular']) ?></span>
                                <span class="badge bg-primary">IMAX: <?= count($tikets['IMAX']) ?></span>
                                <span class="badge bg-danger">Velvet: <?= count($tikets['Velvet']) ?></span>
                            </p>
                        </div>
                        <div class="mt-2 mt-md-0">
                            <span class="badge bg-secondary badge-studio">
                                <i class="fas fa-calendar-alt me-1"></i>
                                <?= date('d F Y') ?>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- TAMPILAN DATA PER STUDIO -->
        <?php foreach (['Regular', 'IMAX', 'Velvet'] as $studio): ?>
            <?php if (!empty($tikets[$studio])): ?>
                <div class="row mb-4">
                    <div class="col-12">
                        <!-- Header Studio -->
                        <div class="studio-header studio-<?= strtolower($studio) ?>">
                            <div>
                                <h3 class="mb-0">
                                    <?= getStudioIcon($studio) ?> Studio <?= $studio ?>
                                    <span class="badge bg-<?= getBadgeColor($studio) ?> ms-2">
                                        <?= count($tikets[$studio]) ?> Tiket
                                    </span>
                                </h3>
                            </div>
                            <div>
                                <small class="text-muted">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Klik pada tiket untuk melihat detail fasilitas
                                </small>
                            </div>
                        </div>
                        
                        <!-- Cards Tiket -->
                        <div class="row">
                            <?php foreach ($tikets[$studio] as $tiket): ?>
                                <div class="col-md-6 col-xl-4 mb-3">
                                    <div class="card card-tiket shadow-sm">
                                        <div class="card-body">
                                            <!-- ID Tiket & Badge -->
                                            <div class="d-flex justify-content-between align-items-start mb-2">
                                                <span class="badge bg-secondary">
                                                    <i class="fas fa-hashtag"></i> ID: <?= $tiket->getIdTiket() ?>
                                                </span>
                                                <span class="badge bg-<?= getBadgeColor($studio) ?>">
                                                    <?= getStudioIcon($studio) ?> <?= $studio ?>
                                                </span>
                                            </div>
                                            
                                            <!-- Judul Film -->
                                            <h5 class="card-title film-title">
                                                <i class="fas fa-video me-1"></i>
                                                <?= htmlspecialchars($tiket->getNamaFilm()) ?>
                                            </h5>
                                            
                                            <!-- Info Dasar -->
                                            <div class="mb-2">
                                                <small class="text-muted">
                                                    <i class="fas fa-calendar me-1"></i>
                                                    <?= date('d M Y', strtotime($tiket->getJadwalTayang())) ?>
                                                    <i class="fas fa-clock ms-2 me-1"></i>
                                                    <?= date('H:i', strtotime($tiket->getJadwalTayang())) ?>
                                                    <i class="fas fa-chair ms-2 me-1"></i>
                                                    <?= $tiket->getJumlahKursi() ?> kursi
                                                </small>
                                            </div>
                                            
                                            <!-- Harga -->
                                            <div class="row g-2 mb-2">
                                                <div class="col-6">
                                                    <div class="border rounded p-2 text-center bg-light">
                                                        <small class="text-muted d-block">Harga Dasar</small>
                                                        <strong><?= formatRupiah($tiket->getHargaDasarTiket()) ?></strong>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="border rounded p-2 text-center <?= $studio == 'Regular' ? 'bg-success bg-opacity-10' : ($studio == 'IMAX' ? 'bg-primary bg-opacity-10' : 'bg-danger bg-opacity-10') ?>">
                                                        <small class="text-muted d-block">Total Harga</small>
                                                        <strong class="<?= $studio == 'Regular' ? 'text-success' : ($studio == 'IMAX' ? 'text-primary' : 'text-danger') ?>">
                                                            <?= formatRupiah($tiket->hitungTotalHarga()) ?>
                                                        </strong>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <!-- Fasilitas (Polimorfik) -->
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
        
        <!-- FOOTER -->
        <div class="footer-custom">
            <div class="row">
                <div class="col-md-4">
                    <h6><i class="fas fa-code me-2"></i>Tahap 6 - View</h6>
                    <small class="text-muted">Implementasi Polimorfisme PHP</small>
                </div>
                <div class="col-md-4">
                    <h6><i class="fas fa-ticket me-2"></i>Total Tiket</h6>
                    <small class="text-muted">
                        Regular: <?= count($tikets['Regular']) ?> | 
                        IMAX: <?= count($tikets['IMAX']) ?> | 
                        Velvet: <?= count($tikets['Velvet']) ?>
                    </small>
                </div>
                <div class="col-md-4">
                    <h6><i class="fas fa-database me-2"></i>Database</h6>
                    <small class="text-muted">
                        <?= $dbname ?? 'DB_LATIHAN_PBO_TRPL1B' ?>
                    </small>
                </div>
            </div>
            <hr class="my-3">
            <small class="text-muted">
                <i class="fas fa-graduation-cap me-1"></i>
                Praktikum PBO - Sistem Manajemen Tiket & Fasilitas Studio Bioskop
            </small>
        </div>
    </div>
    
    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
</body>
</html>