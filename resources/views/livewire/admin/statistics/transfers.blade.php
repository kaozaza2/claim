<div class="overflow-x-auto border rounded-b p-3">
    @if ($transfers->isNotEmpty())
        <div class="w-full pb-2 flex justify-end space-x-0 gap-3">
            <input wire:model.lazy="state.from" type="datetime-local"
                @class(["input input-sm input-bordered w-full max-w-xs", 'input-error' => $errors->has('state.from')])>
            <label class="my-auto">ถึง</label>
            <input wire:model.lazy="state.to" type="datetime-local"
                @class(["input input-sm input-bordered w-full max-w-xs", 'input-error' => $errors->has('state.to')])>
            <button wire:click="download" class="btn btn-sm btn-success normal-case gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" height="18px" viewBox="0 0 24 24" width="18px"
                     fill="currentColor">
                    <path d="M0 0h24v24H0V0z" fill="none"/>
                    <path
                        d="M19 12v7H5v-7H3v7c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2v-7h-2zm-6 .67l2.59-2.58L17 11.5l-5 5-5-5 1.41-1.41L11 12.67V3h2v9.67z"/>
                </svg>
                Download
            </button>
        </div>
    @endif

    <table class="table border table-compact w-full">
        <thead>
        <tr>
            <th>{{ __('app.number') }}</th>
            <th>{{ __('app.equipment') }}</th>
            <th>{{ __('app.transfers.from') }}</th>
            <th>{{ __('app.transfers.to') }}</th>
            <th>{{ __('app.transfers.applicant') }}</th>
            <th>{{ __('app.transfers.recipient') }}</th>
            <th>{{ __('app.time') }}</th>
            <th>{{ __('app.date') }}</th>
        </tr>
        </thead>
        <tbody>
        @forelse ($transfers as $transfer)
            <tr>
                <th>{{ $loop->iteration }}</th>
                <td>
                    <div wire:click="$emit('show-equipment-detail', {{ $transfer->equipment->id }})"
                         class="px-1 my-0 rounded-sm btn btn-sm btn-ghost no-animation">
                        {{ $transfer->equipment }}
                    </div>
                </td>
                <td>{{ $transfer->from }}</td>
                <td>{{ $transfer->to }}</td>
                <td>{{ $transfer->user }}</td>
                <td>{{ $transfer->archive->archiver }}</td>
                <td>{{ $transfer->archive->created_at->format('H:i') }}</td>
                <td>{{ $transfer->archive->created_at->format('d-m-Y') }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="8">{{ __('app.empty') }}</td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>
