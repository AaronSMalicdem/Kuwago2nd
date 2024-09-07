<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;

class GeneratePasscode extends Component
{
    public User $user;

    public function mount(User $user)
    {
        $this->user = $user;
    }

    public function generate()
    {
        do {
            $random = mt_rand(100000, 999999);
        } while (User::where('passcode', $random)->exists());
        $this->user->passcode = $random;
        $this->user->save();
    }

    public function render()
    {
        return view('livewire.generate-passcode');
    }
}
