<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriNilaiKovablikSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('kategori_nilai_kovabliks')->insert(['bagian' => 'Latar Belakang dan Tujuan', 'indikator' => '<ul><li>Uraikan latar belakang dan tujuan yang memuat:<br><ul><li>Rumusan masalah yang menggambarkan kondisi awal sebelum implementasi inovasi</li><li>Kelompok sasaran masyarakat yang terdampak permasalahan</li><li>Tujuan Inovasi dilengkapi dengan target yang terukur</li></ul></li><li>Lengkapi uraian tersebut di atas dengan melampirkan data pendukung yang relevan.</li></ul>', 'nilai_min' => '0', 'nilai_max' => '100', 'bobot_nilai' => '10', 'tahapan_id' => '1']);

        DB::table('kategori_nilai_kovabliks')->insert(['bagian' => 'Kebaruan/Nilai Tambah', 'indikator' => '<ul><li>Jelaskan ide/gagasan dan keunggulan (keunikan/nilai tambah/kebaruan) dari inovasi ini.</li><li>Lengkapi uraian tersebut di atas dengan melampirkan data pendukung yang relevan.</li></ul>', 'nilai_min' => '0', 'nilai_max' => '100', 'bobot_nilai' => '15', 'tahapan_id' => '1']);

        DB::table('kategori_nilai_kovabliks')->insert(['bagian' => 'Implementasi Inovasi', 'indikator' => '<ul><li>Uraikan implementasi inovasi dalam mengatasi permasalahan yang dihadapi.&nbsp;</li><li>Lengkapi uraian tersebut di atas dengan melampirkan data pendukung yang relevan.</li></ul>', 'nilai_min' => '0', 'nilai_max' => '100', 'bobot_nilai' => '5', 'tahapan_id' => '1']);

        DB::table('kategori_nilai_kovabliks')->insert(['bagian' => 'Signifikansi', 'indikator' => '<ul><li>Uraikan dampak inovasi (bandingkan kondisi sebelum dan sesudah inovasi diimplementasikan)&nbsp;</li><li>Jelaskan metode yang digunakan untuk mengukur dampak inovasi.</li><li>Lengkapi uraian tersebut dengan melampirkan data dukung berupa laporan hasil evaluasi inovasi baik dari eksternal maupun internal yang memuat data sebelum dan sesudah implementasi inovasi (kualitatif dan kuantitatif).</li></ul>', 'nilai_min' => '0', 'nilai_max' => '100', 'bobot_nilai' => '30', 'tahapan_id' => '1']);

        DB::table('kategori_nilai_kovabliks')->insert(['bagian' => 'Adaptabilitas', 'indikator' => '<ul><li>Apakah inovasi ini sudah direplikasi?&nbsp;</li><li>Jika sudah, sebutkan UPP dan/atau Instansi yang mereplikasi inovasi.</li><li>Jelaskan potensi inovasi untuk direplikasi dengan menggambarkan luasan populasi dan kesamaan karakter masalah yang dialami atau ada pada daerah lain.</li><li>Lengkapi uraian tersebut di atas dengan melampirkan data pendukung yang relevan.</li></ul>', 'nilai_min' => '0', 'nilai_max' => '100', 'bobot_nilai' => '20', 'tahapan_id' => '1']);

        DB::table('kategori_nilai_kovabliks')->insert(['bagian' => 'Sumber Daya', 'indikator' => '<ul><li>Jelaskan penguatan sumber daya yang digunakan setelah ditetapkan sebagai top inovasi terpuji, yang terdiri dari:<ul><li>sumber daya keuangan;</li><li>sumber daya manusia;</li><li>metode;</li><li>peralatan atau material</li></ul></li><li>Lengkapi uraian tersebut di atas dengan melampirkan data pendukung yang relevan.</li></ul>', 'nilai_min' => '0', 'nilai_max' => '100', 'bobot_nilai' => '5', 'tahapan_id' => '1']);

        DB::table('kategori_nilai_kovabliks')->insert(['bagian' => 'Strategi Keberlanjutan', 'indikator' => '<ul><li>Jelaskan strategi penguatan keberlanjutan inovasi, yang terdiri dari:<ul><li>strategi institusional berupa penguatan regulasi atau dasar hukum implementasi dan/atau pemberlakuan Inovasi;</li><li>strategi manajerial berupa penguatan peningkatan kapasitas SDM, kinerja organisasi, penjaminan kualitas dan/atau pemberlakuan SOP;</li><li>strategi sosial berupa penguatan partisipasi/kolaborasi pemangku kepentingan yang terlibat dan peran masing-masing pihak.</li></ul></li><li>Lengkapi uraian tersebut di atas dengan melampirkan data pendukung yang relevan.</li></ul>', 'nilai_min' => '0', 'nilai_max' => '100', 'bobot_nilai' => '15', 'tahapan_id' => '1']);

        DB::table('kategori_nilai_kovabliks')->insert(['bagian' => 'Penyampaian Paparan', 'indikator' => '<p>Penyampaian paparan materi dengan baik</p>', 'nilai_min' => '0', 'nilai_max' => '100', 'bobot_nilai' => '30', 'tahapan_id' => '2']);

        DB::table('kategori_nilai_kovabliks')->insert(['bagian' => 'Materi Inovasi / Kemanfaatan / Replikasi', 'indikator' => '<p>Isi materi detail</p>', 'nilai_min' => '0', 'nilai_max' => '100', 'bobot_nilai' => '50', 'tahapan_id' => '2']);

        DB::table('kategori_nilai_kovabliks')->insert(['bagian' => 'Video', 'indikator' => '<p>Video menjelaskan dengan baik</p>', 'nilai_min' => '0', 'nilai_max' => '100', 'bobot_nilai' => '10', 'tahapan_id' => '2']);

        DB::table('kategori_nilai_kovabliks')->insert(['bagian' => 'Kehadiran Kepala Daerah / OPD / BUMD', 'indikator' => '<p>Presentasi dihadiri oleh kepala daerah / OPD / BUMD</p>', 'nilai_min' => '0', 'nilai_max' => '100', 'bobot_nilai' => '10', 'tahapan_id' => '2']);
    }
}
