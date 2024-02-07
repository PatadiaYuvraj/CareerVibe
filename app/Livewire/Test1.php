<?php

namespace App\Livewire;

use Livewire\Component;

class Test1 extends Component
{
    public function render()
    {
        return view('livewire.test1');
    }

    public function goToTest2()
    {
        dd('goToTest2');
        $this->redirect(Test2::class);
    }
}
