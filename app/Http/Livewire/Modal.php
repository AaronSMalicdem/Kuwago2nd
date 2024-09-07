<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Events\OrderUpdatedEvent;

class Modal extends Component
{
    public $isModalOpen = false;

    protected $listeners = [
        'toggleModal' => 'toggleModal',
    ];

    public function toggleModal()
    {
        $this->isModalOpen = !$this->isModalOpen;
    }

}
