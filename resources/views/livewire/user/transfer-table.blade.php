<div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-5">
    <h1 class="text-2xl mb-3">{{__('รายการรอย้ายทั้งหมด')}}</h1>

    @if (blank($transfers))
        <p>{{__('ยังไม่มีรายการที่รอย้าย')}}</p>
    @else
        <div class="overflow-x-auto">
            <table class="table table-compact border w-full table-zebra">
                <thead>
                <tr>
                    <th>
                        <span class="hidden lg:block">{{__('No.')}}</span>
                    </th>
                    <th colspan="3">{{__('app.equipment')}}</th>
                    <th>{{__('app.equipments.serial')}}</th>
                    <th>{{__('app.transfers.from')}}</th>
                    <th>{{__('app.transfers.to')}}</th>
                    <th>{{__('app.date')}}</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach ($transfers as $key => $transfer)
                    <tr>
                        <th>{{ $loop->index + 1 }}</th>
                        <td>
                            <div wire:click="$emit('show-equipment-detail', {{ $transfer->equipment->id }})"
                                 class="px-1 my-0 rounded-sm btn btn-sm btn-ghost no-animation">
                                {{ $transfer->equipment }}
                            </div>
                        </td>
                        <td>{{ $transfer->equipment->brand }}</td>
                        <td>{{ $transfer->equipment->category }}</td>
                        <td class="font-mono">
                            {{ $transfer->equipment->serial_number ?: '-' }}
                        </td>
                        <td>{{ $transfer->fromSub }}</td>
                        <td>{{ $transfer->toSub }}</td>
                        <td>{{ $transfer->created_at->format('Y-m-d') }}</td>
                        <td>
                            <button class="btn btn-sm" wire:click="$emitSelf('user-transfer-cancel', {{ $key }})">
                                {{ __('app.cancel') }}
                            </button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
