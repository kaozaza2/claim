<div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-5">
    <h1 class="text-2xl mb-3">{{__('รายการรอย้ายทั้งหมด')}}</h1>

    @if ($transfers->isEmpty())
        <p>{{__('ยังไม่มีรายการที่รอย้าย')}}</p>
    @else
        <div class="overflow-x-auto">
            <table class="table border w-full table-zebra">
                <thead>
                <tr>
                    <th>
                        <span class="hidden lg:block">{{__('No.')}}</span>
                    </th>
                    <th>{{__('อุปกร์ที่เคลม')}}</th>
                    <th>{{__('เลขครุภัณฑ์')}}</th>
                    <th>{{__('ย้ายจากแผนก')}}</th>
                    <th>{{__('ย้ายไปยังแผนก')}}</th>
                    <th>{{__('วันที่ยื่นเรื่อง')}}</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach ($transfers as $transfer)
                    <tr>
                        <th>{{ $loop->index + 1 }}</th>
                        <td class="w-full">{{ $transfer->equipment->name }}</td>
                        <td class="font-mono">{{ $transfer->equipment->serial_number ?: '-' }}</td>
                        <td>{{ $transfer->fromSub->name }}</td>
                        <td>{{ $transfer->toSub->name }}</td>
                        <td>{{ $transfer->created_at->format('Y-m-d') }}</td>
                        <td>
                            <button class="btn btn-sm" wire:click="showCancel('{{ $transfer->id }}')">
                                {{ __('ยกเลิก') }}
                            </button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <x-jet-confirmation-modal wire:model="confirmingCancel">
            <x-slot name="title">
                {{ __('ยกเลิกแจ้งย้าย ?') }}
            </x-slot>

            <x-slot name="content">
                {{ sprintf('ยกเลิกแจ้งย้าย %s ไปยัง %s?', $selected->equipment->name ?? '', $selected->toSub->name ?? '') }}
            </x-slot>

            <x-slot name="footer">
                <button type="button" wire:click="$toggle('confirmingCancel')" class="btn btn-ghost ml-auto">
                    {{ __('ยกเลิก') }}
                </button>
                <button class="btn btn-error ml-2" wire:click="confirmCancel">{{ __('ตกลง') }}</button>
            </x-slot>
        </x-jet-confirmation-modal>
    @endif
</div>
