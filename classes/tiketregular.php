<?php
/**
 * FILE: classes/TiketRegular.php
 * FUNGSI: Subclass untuk tiket studio REGULAR
 * 
 * Mewarisi (extends) dari abstract class Tiket
 */

// Include parent class
require_once 'Tiket.php';

class TiketRegular extends Tiket
{
    /**
     * PROPERTI TAMBAHAN KHUSUS REGULAR
     * Sesuai soal: tipeAudio dan lokasiBaris
     */
    private $tipeAudio;
    private $lokasiBaris;
    
    /**
     * CONSTRUCTOR
     * Memanggil parent::__construct() untuk properti induk
     * Dan meng-assign properti tambahan
     */
    public function __construct($id_tiket, $nama_film, $jadwal_tayang, $jumlah_kursi, $hargaDasarTiket, $tipeAudio, $lokasiBaris)
    {
        // Panggil constructor parent (Tiket) untuk inisialisasi properti induk
        parent::__construct($id_tiket, $nama_film, $jadwal_tayang, $jumlah_kursi, $hargaDasarTiket);
        
        // Assign properti tambahan
        $this->tipeAudio = $tipeAudio;
        $this->lokasiBaris = $lokasiBaris;
    }
    
    /**
     * GETTER UNTUK PROPERTI TAMBAHAN
     */
    public function getTipeAudio()
    {
        return $this->tipeAudio;
    }
    
    public function getLokasiBaris()
    {
        return $this->lokasiBaris;
    }
    
    /**
     * IMPLEMENTASI ABSTRACT METHOD hitungTotalHarga()
     * Sesuai soal: Total Harga = jumlah_kursi * hargaDasarTiket
     * (Tarif standar murni tanpa biaya tambahan fasilitas)
     */
    public function hitungTotalHarga()
    {
        return $this->jumlah_kursi * $this->hargaDasarTiket;
    }
    
    /**
     * IMPLEMENTASI ABSTRACT METHOD tampilkanInfoFasilitas()
     * Menampilkan fasilitas khusus studio Regular
     */
    public function tampilkanInfoFasilitas()
    {
        echo "<ul style='list-style:none; padding-left:0; margin:5px 0;'>";
        echo "<li>🎵 <strong>Tipe Audio:</strong> " . ($this->tipeAudio ?: '-') . "</li>";
        echo "<li>💺 <strong>Lokasi Baris:</strong> " . ($this->lokasiBaris ?: '-') . "</li>";
        echo "<li>📺 <strong>Layar:</strong> Standar</li>";
        echo "<li>🔊 <strong>Sound System:</strong> Surround Sound</li>";
        echo "</ul>";
    }
}
?>