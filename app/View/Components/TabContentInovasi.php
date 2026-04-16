<?php

namespace App\View\Components;

use Illuminate\View\Component;

class TabContentInovasi extends Component
{
    public $kategori, $active, $inovasi,$label,$fase,$area;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($kategori, $active, $inovasi,$label,$fase,$area)
    {
        $this->kategori = $kategori;
        $this->active = $active;
        $this->inovasi = $inovasi;
        $this->label = $label;
        $this->fase = $fase;
        $this->area = $area;

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