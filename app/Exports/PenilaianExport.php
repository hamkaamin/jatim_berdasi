<?php

namespace App\Exports;

use App\Models\KategoriInovasi;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithStyles;

class PenilaianExport implements FromView,ShouldAutoSize, WithColumnWidths,WithStyles
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
    public function styles(Worksheet $sheet)
    {
        // Total rows (1 for header + count($data))
        $rowCount = 1 + KategoriInovasi::get_penilaian_inovasi($this->jenis, $this->kategori_id)->count();

        // Set border for all cells (A1:D{lastRow})
        $cellRange = 'A1:D' . $rowCount;

        return [
            $cellRange => [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['argb' => '000000'],
                    ],
                ],
            ],
        ];
    }
}