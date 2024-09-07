<?php

namespace App\Http\Livewire\Auth;

use App\Events\AnyOrderUpdatedEvent;
use App\Models\User;
use App\Http\Livewire\Modal;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Passcode extends Modal
{
    use AuthorizesRequests;

    public $passcode = "";
    public $itemId;
    public $isCustom;
    public $type;

    protected $listeners = [
        'voidPasscode' => 'void'
    ];

    protected $rules = [
        'isCustom' => 'boolean'
    ];

    public function mount()
    {
        $this->authorize('manage');
    }

    public function void($id, $isCustom, $type)
    {
        $this->toggleModal();
        $this->itemId = $id;
        $this->isCustom = $isCustom;
        $this->type = $type;
    }

    public function enterPasscode()
    {

        $user = User::where('passcode', $this->passcode)->first();

        if ($user && ($user->role->name == "admin" || $user->role->name == "operation")) {
            if($this->type == 'order')
            {
                $this->emit("voidOrder.$this->itemId", $this->itemId, $this->isCustom);
            }

            if($this->type == 'dish')
            {
                $this->emit('voidDish', $this->itemId, $this->isCustom);
            }

            $this->close();
        } else {
            $this->addError('passcode', 'Passcode incorrect');
            $this->reset('passcode');
        }


    }

    public function close()
    {
        $this->reset('passcode');
        $this->toggleModal();
    }

    public function render()
    {
        return view('livewire.auth.passcode');
    }
}
