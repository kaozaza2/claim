<?php

namespace App\Http\Livewire\Admin\Statistics;

use App\Exports\ClaimExport;
use App\Models\PreClaim;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Livewire\Component;

class Claims extends Component
{
    public $claims;

    public $state = [];

    public function mount()
    {
        $this->claims = PreClaim::has('archive')
            ->orderByDesc('id')
            ->get();
    }

    public function updated($property)
    {
        $this->claims = PreClaim::has('archive')
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

        return (new ClaimExport($this->parser($this->state['from']), $this->parser($this->state['to'])))
            ->download('pre_claims_' . now()->format('Y-m-d_H:i') . '.xlsx');
    }

    private function parser($date)
    {
        return Carbon::createFromFormat(
            'Y-m-d\TH:i', $date, 'Asia/Bangkok'
        );
    }

    public function render()
    {
        return view('livewire.admin.statistics.claims');
    }
}
