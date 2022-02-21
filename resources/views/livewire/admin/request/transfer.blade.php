<div class="overflow-x-auto">
    <table class="table table-compact border w-full table-zebra">
        <thead>
        <tr>
            <th>{{__('app.equipment')}}</th>
            <th>{{__('app.equipments.brand')}}</th>
            <th>{{__('app.equipments.type')}}</th>
            <th>{{__('app.equipments.serial')}}</th>
            <th>{{__('app.transfers.from')}}</th>
            <th>{{__('app.transfers.to')}}</th>
            <th>{{__('app.transfers.issue-date')}}</th>
            <th>{{__('app.transfers.applicant')}}</th>
            <th scope="col"></th>
        </tr>
        </thead>
        <tbody>
        @foreach ($transfers as $key => $transfer)
            <tr>
                <td class="w-full">
                    <div wire:click="$emit('show-equipment-detail', {{ $transfer->equipment->id }})"
                         class="px-1 my-0 rounded-sm btn btn-sm btn-ghost no-animation">
                        {{ $transfer->equipment->name }}
                    </div>
                </td>
                <td>{{ $transfer->equipment->brand }}</td>
                <td>{{ $transfer->equipment->category }}</td>
                <td>{{ $transfer->equipment->serial_number }}</td>
                <td>{{ $transfer->from }}</td>
                <td>{{ $transfer->to }}</td>
                <td>{{ $transfer->created_at->format('d-m-Y') }}</td>
                <td>{{ $transfer->user }}</td>
                <td>
                    <button class="btn btn-sm" wire:click="$emitSelf('accept-transfer', {{ $key }})">
                        {{ __('app.transfers.accept') }}
                    </button>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
