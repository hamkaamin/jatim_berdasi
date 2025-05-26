<?php

namespace App\Exports;

use App\Models\KategoriInovasi;
use App\Models\KelompokKovablik;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithStyles;

class PenilaianKovablikExport implements FromView,ShouldAutoSize, WithColumnWidths,WithStyles
{
    use Exportable;
    protected $kelompok_id;


    public function columnWidths(): array
    {
        return [
            'A' => 5,
            'B' => 30,
            'C' => 40,
            'D' => 15,
        ];
    }
    function __construct($kelompok_id) {
        $this->kelompok_id = $kelompok_id; 
    }

    public function view(): View
    {
        $kelompok_id = $this->kelompok_id; 
        $data = KelompokKovablik::get_penilaian_kovablik($kelompok_id);
        return view('penilaian.export', compact(
            'data'
        ));
    }
    public function styles(Worksheet $sheet)
    {
        // Total rows (1 for header + count($data))
        $rowCount = 1 + KelompokKovablik::get_penilaian_kovablik($this->kelompok_id)->count();

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