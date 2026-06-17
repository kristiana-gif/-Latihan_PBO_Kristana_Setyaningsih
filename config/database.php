<?php
/**
 * FILE: config/database.php
 */

// Konfigurasi database
$host = 'localhost';
$dbname = 'db_latihan_pbo_trpl1b_kristiana_setyaningsih';  // <-- PASTIKAN INI SAMA DENGAN DI phpMyAdmin
$username = 'root';
$password = '';

// Atur timezone
date_default_timezone_set('Asia/Jakarta');

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Koneksi database gagal: " . $e->getMessage());
}
?>