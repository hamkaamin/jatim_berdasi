<?php

namespace App\Exports\Sheets;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;

class InovasiSheet implements FromView, WithTitle
{
    public function __construct($inovasi, $kolom)
    {
        $this->inovasi = $inovasi;
        $this->kolom = $kolom;
    }

    public function view(): View
    {
        return view('export.inovasi-excel', [
            'inovasi' => $this->inovasi,
            'kolom' => $this->kolom,
        ]);
    }

    public function title(): string
    {
        return 'Profil Inovasi';
    }
}


?>
