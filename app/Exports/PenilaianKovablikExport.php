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
    protected $juri_tahap;

    public function columnWidths(): array
    {
        return [
            'A' => 5,
            'B' => 30,
            'C' => 40,
            'D' => 15,
        ];
    }
    function __construct($kelompok_id, $juri_tahap) {
        $this->kelompok_id = $kelompok_id; 
        $this->juri_tahap = $juri_tahap; 
    }

    public function view(): View
    {
        $kelompok_id = $this->kelompok_id; 
        $juri_tahap = $this->juri_tahap;
        $data = KelompokKovablik::get_penilaian_kovablik($kelompok_id, $juri_tahap);
        return view('penilaian-kovablik.export', compact(
            'data'
        ));
    }
    public function styles(Worksheet $sheet)
    {
        // Total rows (1 for header + count($data))
        $rowCount = 1 + KelompokKovablik::get_penilaian_kovablik($this->kelompok_id, $this->juri_tahap)->count();

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