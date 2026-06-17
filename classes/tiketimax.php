<?php
/**
 * FILE: classes/TiketIMAX.php
 * FUNGSI: Subclass untuk tiket studio IMAX
 * 
 * Mewarisi (extends) dari abstract class Tiket
 */

// Include parent class
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
     * IMPLEMENTASI ABSTRACT METHOD hitungTotalHarga()
     * Sesuai soal: Total Harga = (jumlah_kursi * hargaDasarTiket) + 35000
     * (Dikenakan biaya tambahan teknologi proyeksi layar lebar IMAX Rp35.000)
     */
    public function hitungTotalHarga()
    {
        return ($this->jumlah_kursi * $this->hargaDasarTiket) + 35000;
    }
    
    /**
     * IMPLEMENTASI ABSTRACT METHOD tampilkanInfoFasilitas()
     * Menampilkan fasilitas khusus studio IMAX
     */
    public function tampilkanInfoFasilitas()
    {
        echo "<ul style='list-style:none; padding-left:0; margin:5px 0;'>";
        echo "<li>🕶️ <strong>Kacamata 3D:</strong> " . ($this->kacamata3dId ?: '-') . "</li>";
        echo "<li>🎬 <strong>Efek Gerak:</strong> " . ($this->efekGerakFitur ?: '-') . "</li>";
        echo "<li>📽️ <strong>Layar:</strong> Raksasa IMAX</li>";
        echo "<li>🔊 <strong>Sound System:</strong> IMAX 12-channel</li>";
        echo "<li>💰 <strong>Biaya Tambahan:</strong> Rp 35.000 (Teknologi IMAX)</li>";
        echo "</ul>";
    }
}
?>