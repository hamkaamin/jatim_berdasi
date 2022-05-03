<?php

namespace App\View\Components;

use Illuminate\View\Component;

class SelectWilayah extends Component
{
    public $label, $wilayah, $labelNext;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($label, $wilayah, $labelNext)
    {
        $this->label = $label;
        $this->wilayah = $wilayah;
        $this->labelNext = $labelNext;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.select-wilayah');
    }
}
