<div class="overflow-x-auto">
    <table class="table table-compact w-full">
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
        @foreach($transfers as $transfer)
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
                <td>{{ $transfer->archive->created_at->format('Y/m/d') }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
