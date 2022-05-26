<?php

namespace App\Exports;

use App\Exports\Sheets\IndikatorSheet;
use App\Exports\Sheets\InovasiSheet;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class InovasiExport implements WithMultipleSheets
{
    use Exportable;

    public function __construct($inovasi, $kolom)
    {
        $this->inovasi = $inovasi;
        $this->kolom = $kolom;
    }

    public function sheets(): array
    {
        $sheets = [];
        $sheets[] = new InovasiSheet($this->inovasi, $this->kolom);
        $sheets[] = new IndikatorSheet($this->inovasi);
        return $sheets;
    }
}
