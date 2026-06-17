<?php
/**
 * FILE: classes/TiketIMAX.php
 * FUNGSI: Subclass untuk tiket studio IMAX
 * Mewarisi (extends) dari abstract class Tiket
 * 
 * TAHAP 5: Method Overriding untuk hitungTotalHarga() dan tampilkanInfoFasilitas()
 */

require_once 'Tiket.php';

class TiketIMAX extends Tiket
{
    /**
     * PROPERTI TAMBAHAN KHUSUS IMAX
     * Sesuai soal: kacamata3dId dan efekGerakFitur
     */
    private $kacamata3dId;
    private $efekGerakFitur;
    
    /**
     * CONSTRUCTOR
     * Memanggil parent::__construct() untuk properti induk
     * Dan meng-assign properti tambahan
     */
    public function __construct($id_tiket, $nama_film, $jadwal_tayang, $jumlah_kursi, $hargaDasarTiket, $kacamata3dId, $efekGerakFitur)
    {
        // Panggil constructor parent (Tiket)
        parent::__construct($id_tiket, $nama_film, $jadwal_tayang, $jumlah_kursi, $hargaDasarTiket);
        
        // Assign properti tambahan
        $this->kacamata3dId = $kacamata3dId;
        $this->efekGerakFitur = $efekGerakFitur;
    }
    
    /**
     * GETTER UNTUK PROPERTI TAMBAHAN
     */
    public function getKacamata3dId()
    {
        return $this->kacamata3dId;
    }
    
    public function getEfekGerakFitur()
    {
        return $this->efekGerakFitur;
    }
    
    /**
     * OVERRIDE METHOD hitungTotalHarga()
     * Sesuai soal: Total Harga = (jumlah_kursi * hargaDasarTiket) + 35000
     * (Dikenakan biaya tambahan teknologi proyeksi layar lebar IMAX Rp35.000)
     */
    public function hitungTotalHarga()
    {
        return ($this->jumlah_kursi * $this->hargaDasarTiket) + 35000;
    }
    
    /**
     * OVERRIDE METHOD tampilkanInfoFasilitas()
     * Menampilkan fasilitas khusus studio IMAX
     */
    public function tampilkanInfoFasilitas()
    {
        echo "<div style='background:#e8f4fd; padding:10px; border-radius:5px; border-left:4px solid #2196F3;'>";
        echo "<strong>🕶️ Kacamata 3D ID:</strong> " . ($this->kacamata3dId ?: 'Tidak tersedia') . "<br>";
        echo "<strong>🎬 Efek Gerak Fitur:</strong> " . ($this->efekGerakFitur ?: 'Tidak tersedia') . "<br>";
        echo "<strong>📽️ Jenis Layar:</strong> Layar Raksasa IMAX<br>";
        echo "<strong>🔊 Sound System:</strong> IMAX 12-channel Audio<br>";
        echo "<strong>💺 Kursi:</strong> Premium dengan Efek Gerak<br>";
        echo "<strong>💵 Biaya Tambahan:</strong> Rp 35.000 (Teknologi IMAX)<br>";
        echo "</div>";
    }
}
?>