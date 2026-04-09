<?php

namespace App\View\Components;

use App\Models\DefinisiOperasional;
use Illuminate\View\Component;

class FieldParameter extends Component
{
    public $param;
    public $param2;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($param, $param2)
    {
        $this->param = $param;
        $this->param2 = $param2;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $definisi_operasional = DefinisiOperasional::where('indikator_id', $this->param->indikator_id)->get();
        return view('components.field-parameter',compact('definisi_operasional'));
    }
}