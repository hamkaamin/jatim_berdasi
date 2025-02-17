<?php

namespace App\View\Components;

use Illuminate\View\Component;

class TabInovasi extends Component
{
    public $kategori, $active, $key, $bgColor;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($kategori, $active, $key)
    {
        $this->kategori = $kategori;
        $this->active = $active;
        $this->key = $key;
        if (($this->key % 8) == 0) {
            $this->bgColor = "#ED4D4D";
        } elseif (($this->key % 8) == 1) {
            $this->bgColor = "#FF884E";
        } elseif (($this->key % 8) == 2) {
            $this->bgColor = "#FFC44C";
        } elseif (($this->key % 8) == 3) {
            $this->bgColor = "#8CCA4D";
        } elseif (($this->key % 8) == 4) {
            $this->bgColor = "#4FDAC5";
        } elseif (($this->key % 8) == 5) {
            $this->bgColor = "#4DC3FF";
        } elseif (($this->key % 8) == 6) {
            $this->bgColor = "#5E94FF";
        } elseif (($this->key % 8) == 7) {
            $this->bgColor = "#A06FFF";
        }
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
