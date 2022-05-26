<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;

class ProfilPemdaExport implements FromView, WithTitle
{
    public function __construct($provinsi)
    {
        $this->provinsi = $provinsi;
    }

    public function view(): View
    {
        return view('export.profil-pemda-excel', [
            'provinsi' => $this->provinsi
        ]);
    }

    public function title(): string
    {
        return 'Data';
    }
}
