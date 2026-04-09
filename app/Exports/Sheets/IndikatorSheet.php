<?php

namespace App\Exports\Sheets;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;

class IndikatorSheet implements FromView, WithTitle
{
    public function __construct($inovasi)
    {
        $this->inovasi = $inovasi;
    }

    public function view(): View
    {
        return view('export.indikator-excel', [
            'inovasi' => $this->inovasi
        ]);
    }

    public function title(): string
    {
        return 'Indikator Inovasi';
    }
}


?>
