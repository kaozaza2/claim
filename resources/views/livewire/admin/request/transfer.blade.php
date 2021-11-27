<div>
    <div class="overflow-hidden sm:py-6 lg:py-8 px-0">
        <h1 class="text-2xl mb-2">{{ __('app.transfer') }}</h1>
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
                        <td>{{ $transfer->fromSub }}</td>
                        <td>{{ $transfer->toSub }}</td>
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
    </div>
</div>
