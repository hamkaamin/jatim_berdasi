<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;

class CompileInovasiExport implements FromView, WithTitle
{
    public function __construct($data, $kolom)
    {
        $this->data = $data;
        $this->kolom = $kolom;
    }

    public function view(): View
    {
        return view('export.inovasi-daerah-excel', [
            'data' => $this->data,
            'kolom' => $this->kolom,
        ]);
    }

    public function title(): string
    {
        return 'Data';
    }
}
