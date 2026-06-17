<?php
/**
 * FILE: classes/TiketVelvet.php
 * FUNGSI: Subclass untuk tiket studio VELVET (Premium)
 * Mewarisi (extends) dari abstract class Tiket
 * 
 * TAHAP 5: Method Overriding untuk hitungTotalHarga() dan tampilkanInfoFasilitas()
 */

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
     * OVERRIDE METHOD hitungTotalHarga()
     * Sesuai soal: Total Harga = (jumlah_kursi * hargaDasarTiket) * 1.50
     * (Surcharge 50% dari total harga dasar)
     */
    public function hitungTotalHarga()
    {
        return ($this->jumlah_kursi * $this->hargaDasarTiket) * 1.50;
    }
    
    /**
     * OVERRIDE METHOD tampilkanInfoFasilitas()
     * Menampilkan fasilitas khusus studio Velvet (Premium)
     */
    public function tampilkanInfoFasilitas()
    {
        echo "<div style='background:#f5e8ff; padding:10px; border-radius:5px; border-left:4px solid #9C27B0;'>";
        echo "<strong>🛏️ Bantal & Selimut Pack:</strong> " . ($this->bantalSelimutPack ?: 'Tidak tersedia') . "<br>";
        echo "<strong>🤵 Layanan Butler:</strong> " . ($this->layananButler ?: 'Tidak tersedia') . "<br>";
        echo "<strong>🛋️ Jenis Kursi:</strong> Recliner Premium Velvet<br>";
        echo "<strong>🍽️ Makanan & Minuman:</strong> In-seat dining service<br>";
        echo "<strong>📺 Layar:</strong> Layar Premium 4K<br>";
        echo "<strong>💵 Biaya Tambahan:</strong> Surcharge 50% (Kelas Premium)<br>";
        echo "</div>";
    }
}
?>