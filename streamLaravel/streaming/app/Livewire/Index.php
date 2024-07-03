<?php

namespace App\Livewire;

use Livewire\Component;

class Index extends Component
{
    public function redirectToRmaPayment()
    {
        return redirect()->route('rma-payment');
    }

    public function render()
    {
        return view('index');
    }
}
