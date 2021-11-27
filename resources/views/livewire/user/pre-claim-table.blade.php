<div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-5">
    <h1 class="text-2xl mb-3">{{__('รายการรอซ่อมทั้งหมด')}}</h1>

    @if (blank($pending))
        <p>{{__('ยังไม่มีรายการรายการรอซ่อม')}}</p>
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
                    <th>{{__('app.claims.problem')}}</th>
                    <th>{{__('app.date')}}</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach ($pending as $key => $pre)
                    <tr>
                        <th>{{ $loop->index + 1 }}</th>
                        <td>{{ $pre->equipment }}</td>
                        <td>{{ $pre->equipment->brand }}</td>
                        <td>{{ $pre->equipment->category }}</td>
                        <td class="font-mono">
                            {{ $pre->equipment->serial_number ?: '-' }}
                        </td>
                        <td>{{ $pre->problem }}</td>
                        <td>{{ $pre->created_at->format('Y-m-d') }}</td>
                        <td>
                            <button class="btn btn-sm" wire:click="$emitSelf('user-claim-cancel', {{ $key }})">
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
