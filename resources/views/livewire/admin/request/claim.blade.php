<div>
    <div class="overflow-hidden sm:py-6 lg:py-8 px-0">
        <h1 class="text-2xl mb-2">{{ __('app.claim') }}</h1>
        <div class="overflow-x-auto">
            <table class="table table-compact border w-full table-zebra">
                <thead>
                <tr>
                    <th>{{__('app.equipment')}}</th>
                    <th>{{__('app.equipments.brand')}}</th>
                    <th>{{__('app.equipments.type')}}</th>
                    <th>{{__('app.equipments.serial')}}</th>
                    <th>{{__('app.claims.problem')}}</th>
                    <th>{{__('app.claims.issue-date')}}</th>
                    <th>{{__('app.claims.applicant')}}</th>
                    <th scope="col"></th>
                </tr>
                </thead>
                <tbody>
                @foreach ($claims as $key => $claim)
                    <tr>
                        <td class="w-full">
                            <div wire:click="$emit('show-equipment-detail', {{ $claim->equipment->id }})"
                                 class="px-1 my-0 rounded-sm btn btn-sm btn-ghost no-animation">
                                {{ $claim->equipment->name }}
                            </div>
                        </td>
                        <td>{{ $claim->equipment->brand }}</td>
                        <td>{{ $claim->equipment->category }}</td>
                        <td>{{ $claim->equipment->serial_number }}</td>
                        <td>{{ $claim->problem }}</td>
                        <td>{{ $claim->created_at->format('d-m-Y') }}</td>
                        <td>{{ $claim->user }}</td>
                        <td>
                            <button class="btn btn-sm" wire:click="$emitSelf('accept-claim', {{ $key }})">
                                {{ __('app.claims.accept') }}
                            </button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
