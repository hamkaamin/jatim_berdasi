<?php

namespace App\Exports\Sheets;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;

class ProposalKovablikSheet implements FromView, WithTitle
{
    public function __construct($proposal)
    {
        $this->proposal = $proposal;
    }

    public function view(): View
    {
        return view('export.kovablik-excel', [
            'proposal' => $this->proposal,
        ]);
    }

    public function title(): string
    {
        return 'Profil Proposal Kovablik';
    }
}


?>
