<?php

namespace App\Http\Livewire\FrondDesk;

use Livewire\Component;
use App\Traits\WithCaching;
class EndShift extends Component
{
    //traits
    use WithCaching;

    //listeners

    //public properties

    //protected properties

    public function mount()
    {
        //code ....
    }
    public function render()
    {
        return view('livewire.frond-desk.end-shift',[
            //data
        ]);
    }
}
