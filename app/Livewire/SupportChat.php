<?php

declare(strict_types=1);

namespace App\Livewire;

use Auth;
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

    public $conversations;

    public function render()
    {
        $this->conversations = Auth::user()->conversations;

        return view('livewire.support-chat');
    }

    public function send()
    {
        $this->validate();

        dd($this->message);

        $this->reset('message');
    }
}
