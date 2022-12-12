<?php

namespace App\Http\Livewire\BackOffice;

use Livewire\Component;

class Reports extends Component
{
    public $selected_report;
    public function render()
    {
        return view('livewire.back-office.reports');
    }
}
