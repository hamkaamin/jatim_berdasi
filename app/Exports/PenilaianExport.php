<?php

namespace App\Exports;

use App\Models\KategoriInovasi;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnWidths;

class PenilaianExport implements FromView,ShouldAutoSize, WithColumnWidths
{
    use Exportable;
    protected $jenis;
    protected $kategori_id;


    public function columnWidths(): array
    {
        return [
            'A' => 5,
            'B' => 30,
            'C' => 40,
            'D' => 15,
        ];
    }
    function __construct($jenis,$kategori_id) {
        $this->jenis = $jenis; 
        $this->kategori_id = $kategori_id; 
    }

    public function view(): View
    {
        $jenis = $this->jenis; 
        $kategori_id = $this->kategori_id; 
        $data = KategoriInovasi::get_penilaian_inovasi($jenis, $kategori_id);
        return view('penilaian.export', compact(
            'data'
        ));
    }
}