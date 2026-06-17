<?php
/**
 * FILE: config/database.php
 * FUNGSI: Koneksi ke database MySQL menggunakan PDO
 */

// Konfigurasi database
$host = 'localhost';           // Server database (biasanya localhost)
$dbname = 'DB_LATIHAN_PBO_TRPL1B_NamaLengkap';  // Ganti dengan nama database Anda
$username = 'root';            // Username MySQL (default root)
$password = '';               // Password MySQL (kosong jika pakai XAMPP)

// Atur timezone ke Indonesia
date_default_timezone_set('Asia/Jakarta');

try {
    // Buat koneksi PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    
    // Set mode error PDO ke exception (agar mudah menangkap error)
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Set default fetch mode ke associative array
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    
    // (Opsional) echo jika koneksi berhasil - nanti bisa dihapus
    // echo "Koneksi database berhasil!<br>";
    
} catch (PDOException $e) {
    // Jika koneksi gagal, tampilkan pesan error
    die("Koneksi database gagal: " . $e->getMessage());
}

// Catatan: Variabel $pdo akan tersedia di file yang memanggil file ini
?>
