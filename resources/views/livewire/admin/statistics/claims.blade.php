<div class="overflow-x-auto border">
    <table class="table table-compact w-full">
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
