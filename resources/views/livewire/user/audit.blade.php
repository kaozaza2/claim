<div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-5">
    <h1 class="text-2xl mb-3">{{__('ประวัติการซ่อม')}}</h1>
    <div class="overflow-x-auto">
        <table class="table table-compact border w-full table-zebra">
            <thead>
                <tr>
                    <th>
                        <span class="hidden lg:block">{{__('app.number')}}</span>
                    </th>
                    <th colspan="3">{{__('app.equipment')}}</th>
                    <th>{{__('app.equipments.serial')}}</th>
                    <th>{{__('app.claims.problem')}}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($claims as $claim)
                    <tr>
                        <th>{{ $claim->id }}</th>
                        <td>
                            <div wire:click="$emit('show-equipment-detail', {{ $claim->equipment->id }})"
                                 class="px-1 my-0 rounded-sm btn btn-sm btn-ghost no-animation">
                                {{ $claim->equipment }}
                            </div>
                        </td>
                        <td>{{ $claim->equipment->brand }}</td>
                        <td>{{ $claim->equipment->category }}</td>
                        <td class="font-mono">
                            {{ $claim->equipment->serial_number ?: '-' }}
                        </td>
                        <td>{{ $claim->problem }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
