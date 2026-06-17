<?php
/**
 * FILE: classes/TiketRegular.php
 * FUNGSI: Subclass untuk tiket studio REGULAR
 * Mewarisi (extends) dari abstract class Tiket
 * 
 * TAHAP 5: Method Overriding untuk hitungTotalHarga() dan tampilkanInfoFasilitas()
 */

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
        // Panggil constructor parent (Tiket)
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
     * OVERRIDE METHOD hitungTotalHarga()
     * Sesuai soal: Total Harga = jumlah_kursi * hargaDasarTiket
     * (Tarif standar murni tanpa biaya tambahan fasilitas)
     */
    public function hitungTotalHarga()
    {
        return $this->jumlah_kursi * $this->hargaDasarTiket;
    }
    
    /**
     * OVERRIDE METHOD tampilkanInfoFasilitas()
     * Menampilkan fasilitas khusus studio Regular
     */
    public function tampilkanInfoFasilitas()
    {
        echo "<div style='background:#f0f8f0; padding:10px; border-radius:5px; border-left:4px solid #4CAF50;'>";
        echo "<strong>🎵 Tipe Audio:</strong> " . ($this->tipeAudio ?: 'Standar') . "<br>";
        echo "<strong>💺 Lokasi Baris:</strong> " . ($this->lokasiBaris ?: 'Tidak tersedia') . "<br>";
        echo "<strong>📺 Jenis Layar:</strong> Standar<br>";
        echo "<strong>🔊 Sound System:</strong> Surround Sound 5.1<br>";
        echo "<strong>💺 Kursi:</strong> Standar<br>";
        echo "<strong>💵 Biaya Tambahan:</strong> Tidak ada (tarif murni)<br>";
        echo "</div>";
    }
}
?>