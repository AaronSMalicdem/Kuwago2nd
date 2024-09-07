<?php

namespace App\Http\Livewire;

use App\Models\Role;
use Livewire\Component;

class Test extends Component
{
    public $arrays;

    public $a = [];

    protected $listeners = [
        'submit'
    ];

    public function mount()
    {
        $this->arrays = Role::factory()->count(10)->make()->toArray();
    }

    public function submit()
    {
        dd($this->a);
    }


    public function render()
    {
        return view('livewire.test')->layout('layouts.guest');
    }
}
