<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ErrorModal extends Component
{
    /**
     * @var array<string, string>
     */
    protected $listeners = [
        'show-error-modal' => 'showErrorModal',
    ];

    /**
     * @var bool
     */
    public bool $showingErrorMessage = false;

    /**
     * @var mixed[]
     */
    private array $messages = [];

    /**
     * @param mixed[] $messages
     */
    public function showErrorModal(array $messages): void
    {
        $this->messages = $messages;
        $this->showingErrorMessage = true;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render()
    {
        return \view('livewire.error-modal', [
            'message' => $this->messages,
        ]);
    }
}
