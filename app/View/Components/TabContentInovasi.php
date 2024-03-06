<?php

namespace App\View\Components;

use Illuminate\View\Component;

class TabContentInovasi extends Component
{
    public $tahapan, $active, $kolom, $inovasi,$label;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($tahapan, $active, $kolom, $inovasi,$label)
    {
        $this->tahapan = $tahapan;
        $this->active = $active;
        $this->kolom = $kolom;
        $this->inovasi = $inovasi;
        $this->label = $label;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.tab-content-inovasi');
    }
}