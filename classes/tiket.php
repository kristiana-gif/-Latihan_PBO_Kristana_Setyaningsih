<?php
/**
 * FILE: classes/Tiket.php
 * FUNGSI: Abstract class Tiket sebagai induk dari semua jenis tiket
 */

abstract class Tiket
{
    /**
     * PROPERTI PROTECTED (sesuai soal)
     */
    protected $id_tiket;
    protected $nama_film;
    protected $jadwal_tayang;
    protected $jumlah_kursi;
    protected $hargaDasarTiket;
    
    /**
     * CONSTRUCTOR
     * Menginisialisasi semua properti
     */
    public function __construct($id_tiket, $nama_film, $jadwal_tayang, $jumlah_kursi, $hargaDasarTiket)
    {
        $this->id_tiket = $id_tiket;
        $this->nama_film = $nama_film;
        $this->jadwal_tayang = $jadwal_tayang;
        $this->jumlah_kursi = $jumlah_kursi;
        $this->hargaDasarTiket = $hargaDasarTiket;
    }
    
    /**
     * GETTER (opsional, untuk mengakses properti protected)
     */
    public function getIdTiket()
    {
        return $this->id_tiket;
    }
    
    public function getNamaFilm()
    {
        return $this->nama_film;
    }
    
    public function getJadwalTayang()
    {
        return $this->jadwal_tayang;
    }
    
    public function getJumlahKursi()
    {
        return $this->jumlah_kursi;
    }
    
    public function getHargaDasarTiket()
    {
        return $this->hargaDasarTiket;
    }
    
    /**
     * ABSTRACT METHOD 1: hitungTotalHarga()
     * WAJIB diimplementasikan oleh kelas anak
     */
    abstract public function hitungTotalHarga();
    
    /**
     * ABSTRACT METHOD 2: tampilkanInfoFasilitas()
     * WAJIB diimplementasikan oleh kelas anak
     */
    abstract public function tampilkanInfoFasilitas();
}
?>