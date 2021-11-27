<?php

namespace App\Http\Livewire;

use Illuminate\View\View;
use Livewire\Component;

class ConfirmDialog extends Component
{
    protected $listeners = [
        'show-confirm-dialog' => 'dialog',
        'confirmed' => 'confirmationSubmitted',
    ];

    public bool $showingConfirmationDialog = false;

    public array $state = []; 

    public function dialog(string $title, string $message, $emitter = null): void
    {
        $this->state = ['title' => $title, 'message' => $message];
        if (is_array($emitter)) {
            $this->state = array_merge($this->state, $emitter);
        }
        $this->showingConfirmationDialog = true;
    }

    public function confirmationSubmitted(): void
    {
        if (array_key_exists('emitter', $this->state)) {
            $params = array_key_exists('params', $this->state)
                ? $this->state['params'] : [];
            $this->emit($this->state['emitter'], ...$params);
        }
        $this->showingConfirmationDialog = false;
    }

    public function render(): View
    {
        return view('livewire.confirm-dialog');
    }
}
