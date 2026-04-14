<?php

namespace App\View\Components;

use Illuminate\View\Component;

class TabInovasi extends Component
{
    public $tahapan, $active;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($tahapan, $active)
    {
        $this->tahapan = $tahapan;
        $this->active = $active;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.tab-inovasi');
    }
}
