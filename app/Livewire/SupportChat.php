<?php

namespace App\Livewire;

use Livewire\Attributes\Rule;
use Livewire\Component;

class SupportChat extends Component
{
    #[Rule([
        'required',
        'string',
        'min:3',
        'max:255',
    ])]
    public $message = '';

    public function render()
    {
        return view('livewire.support-chat');
    }

    public function send()
    {
        $this->validate();

        dd($this->message);

        $this->reset('message');
    }
}
