<?php

namespace App\Http\Livewire\Admin\Statistics;

use App\Exports\TransferExport;
use App\Models\Transfer;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Livewire\Component;

class Transfers extends Component
{
    public $transfers;

    public $state = [];

    public function mount()
    {
        $this->transfers = Transfer::has('archive')
            ->orderByDesc('id')
            ->get();
    }

    public function updated($property)
    {
        $this->transfers = Transfer::has('archive')
            ->when(Arr::get($this->state, 'from'), function ($query, $from) {
                $query->where('created_at', '>=', $this->parser($from));
            })
            ->when(Arr::get($this->state, 'to'), function ($query, $to) {
                $query->where('created_at', '<=', $this->parser($to));
            })
            ->orderByDesc('id')
            ->get();
    }

    public function download()
    {
        $this->validate([
            'state.from' => 'required',
            'state.to' => 'required',
        ]);

        return (new TransferExport($this->parser($this->state['from']), $this->parser($this->state['to'])))
            ->download('transfers_' . now()->format('Y-m-d_H:i') . '.xlsx');
    }

    private function parser($date)
    {
        return Carbon::createFromFormat(
            'Y-m-d\TH:i', $date, 'Asia/Bangkok'
        );
    }

    public function render()
    {
        return view('livewire.admin.statistics.transfers');
    }
}
