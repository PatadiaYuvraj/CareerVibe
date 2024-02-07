<?php

namespace App\Livewire;

use Livewire\Component;

class Test2 extends Component
{
    public function render()
    {
        return view('livewire.test2');
    }

    public function goToTest1()
    {
        dd('goToTest1');
        $this->redirect(Test1::class);
    }
}
