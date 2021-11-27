<?php

namespace App\Http\Livewire;

use Illuminate\View\View;
use Livewire\Component;

class ErrorModal extends Component
{
    protected $listeners = [
        'show-error-modal' => 'showErrorModal',
    ];

    public bool $showingErrorMessage = false;

    private array $messages = [];

    public function showErrorModal(array $messages): void
    {
        $this->messages = $messages;
        $this->showingErrorMessage = true;
    }

    public function render(): View
    {
        return view('livewire.error-modal', [
            'message' => $this->messages,
        ]);
    }
}
