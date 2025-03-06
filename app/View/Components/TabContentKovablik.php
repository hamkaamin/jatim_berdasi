<?php

namespace App\View\Components;

use Illuminate\View\Component;

class TabContentKovablik extends Component
{
    public $kategori, $active, $proposal,$label,$fase;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($kategori, $active, $proposal,$label,$fase)
    {
        $this->kategori = $kategori;
        $this->active = $active;
        $this->proposal = $proposal;
        $this->label = $label;
        $this->fase = $fase;

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.tab-content-kovablik');
    }
}
