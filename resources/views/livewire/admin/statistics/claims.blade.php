<div class="border rounded-b lg:p-3">
    @if ($claims->isNotEmpty())
        <div class="w-full pb-2 flex justify-end px-2 pt-2  lg:px-0 lg:pt-0 space-x-0 gap-3">
            <input wire:model.lazy="state.from" type="datetime-local"
                @class(["input input-sm input-bordered w-full max-w-xs", 'input-error' => $errors->has('state.from')])>
            <label class="my-auto">{{ __('app.to') }}</label>
            <input wire:model.lazy="state.to" type="datetime-local"
                @class(["input input-sm input-bordered w-full max-w-xs", 'input-error' => $errors->has('state.to')])>
            <button wire:click="download" class="btn btn-sm btn-success normal-case gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" height="18px" viewBox="0 0 24 24" width="18px"
                     fill="currentColor">
                    <path d="M0 0h24v24H0V0z" fill="none"/>
                    <path
                        d="M19 12v7H5v-7H3v7c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2v-7h-2zm-6 .67l2.59-2.58L17 11.5l-5 5-5-5 1.41-1.41L11 12.67V3h2v9.67z"/>
                </svg>
                {{ __('app.download') }}
            </button>
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="table border table-compact w-full">
            <thead>
            <tr>
                <th>{{ __('app.number') }}</th>
                <th>{{ __('app.equipment') }}</th>
                <th>{{ __('app.claims.problem') }}</th>
                <th>{{ __('app.transfers.applicant') }}</th>
                <th>{{ __('app.transfers.recipient') }}</th>
                <th>{{ __('app.time') }}</th>
                <th>{{ __('app.date') }}</th>
            </tr>
            </thead>
            <tbody>
            @forelse ($claims as $claim)
                <tr>
                    <th>{{ $loop->iteration }}</th>
                    <td>
                        <div wire:click="$emit('show-equipment-detail', {{ $claim->equipment->id }})"
                             class="px-1 my-0 rounded-sm btn btn-sm btn-ghost no-animation">
                            {{ $claim->equipment }}
                        </div>
                    </td>
                    <td>{{ $claim->problem }}</td>
                    <td>{{ $claim->user }}</td>
                    <td>{{ $claim->archive->archiver }}</td>
                    <td>{{ $claim->archive->created_at->format('H:i') }}</td>
                    <td>{{ $claim->archive->created_at->format('d-m-Y') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8">{{ __('app.empty') }}</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
