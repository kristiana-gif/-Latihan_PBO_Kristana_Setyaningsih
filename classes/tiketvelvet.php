<?php
/**
 * FILE: classes/TiketVelvet.php
 * FUNGSI: Subclass untuk tiket studio VELVET (Premium)
 * 
 * Mewarisi (extends) dari abstract class Tiket
 */

// Include parent class
require_once 'Tiket.php';

class TiketVelvet extends Tiket
{
    /**
     * PROPERTI TAMBAHAN KHUSUS VELVET
     * Sesuai soal: bantalSelimutPack dan layananButler
     */
    private $bantalSelimutPack;
    private $layananButler;
    
    /**
     * CONSTRUCTOR
     * Memanggil parent::__construct() untuk properti induk
     * Dan meng-assign properti tambahan
     */
    public function __construct($id_tiket, $nama_film, $jadwal_tayang, $jumlah_kursi, $hargaDasarTiket, $bantalSelimutPack, $layananButler)
    {
        // Panggil constructor parent (Tiket)
        parent::__construct($id_tiket, $nama_film, $jadwal_tayang, $jumlah_kursi, $hargaDasarTiket);
        
        // Assign properti tambahan
        $this->bantalSelimutPack = $bantalSelimutPack;
        $this->layananButler = $layananButler;
    }
    
    /**
     * GETTER UNTUK PROPERTI TAMBAHAN
     */
    public function getBantalSelimutPack()
    {
        return $this->bantalSelimutPack;
    }
    
    public function getLayananButler()
    {
        return $this->layananButler;
    }
    
    /**
     * IMPLEMENTASI ABSTRACT METHOD hitungTotalHarga()
     * Sesuai soal: Total Harga = (jumlah_kursi * hargaDasarTiket) * 1.50
     * (Surcharge 50% dari total harga dasar)
     */
    public function hitungTotalHarga()
    {
        return ($this->jumlah_kursi * $this->hargaDasarTiket) * 1.50;
    }
    
    /**
     * IMPLEMENTASI ABSTRACT METHOD tampilkanInfoFasilitas()
     * Menampilkan fasilitas khusus studio Velvet (Premium)
     */
    public function tampilkanInfoFasilitas()
    {
        echo "<ul style='list-style:none; padding-left:0; margin:5px 0;'>";
        echo "<li>🛏️ <strong>Bantal & Selimut:</strong> " . ($this->bantalSelimutPack ?: '-') . "</li>";
        echo "<li>🤵 <strong>Layanan Butler:</strong> " . ($this->layananButler ?: '-') . "</li>";
        echo "<li>🛋️ <strong>Kursi:</strong> Recliner Premium</li>";
        echo "<li>🍽️ <strong>Makanan:</strong> In-seat dining service</li>";
        echo "<li>💰 <strong>Surcharge:</strong> 50% dari harga dasar</li>";
        echo "</ul>";
    }
}
?>