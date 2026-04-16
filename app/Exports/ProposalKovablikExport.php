<?php

namespace App\Exports;

use App\Exports\Sheets\ProposalKovablikSheet;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ProposalKovablikExport implements WithMultipleSheets
{
    use Exportable;

    public function __construct($proposal)
    {
        $this->proposal = $proposal;
    }

    public function sheets(): array
    {
        $sheets = [];
        $sheets[] = new ProposalKovablikSheet($this->proposal);
        return $sheets;
    }
}
