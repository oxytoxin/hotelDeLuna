<?php

namespace App\View\Components\List;

use Illuminate\View\Component;

class Index extends Component
{

    public $table =[];
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($tabel =[])
    {
        $this->table = $tabel;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.list.index');
    }
}
