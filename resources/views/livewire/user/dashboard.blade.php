<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('หน้าหลัก') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="w-full text-right mb-3">
                <button class="btn btn-info" wire:click="$emit('showTransferReport')">
                    {{ __('แจ้งย้าย') }}
                </button>
                <button class="btn btn-success ml-2" wire:click="$emit('showClaimReport')">
                    {{ __('แจ้งซ่อม') }}
                </button>
            </div>

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-5 mb-3">
                <h1 class="text-2xl mb-3">{{__('รายการซ่อมทั้งหมด')}}</h1>

                @if ($claims->isEmpty())
                    <p>{{__('ยังไม่มีอุปแกรณ์ที่ส่งซ่อมอยู่')}}</p>
                @else
                    <div class="overflow-x-auto">
                        <table class="table border w-full table-zebra">
                            <thead>
                            <tr>
                                <th>
                                    <span class="hidden lg:block">{{__('เลขที่การเคลม')}}</span>
                                </th>
                                <th>{{__('อุปกร์ที่เคลม')}}</th>
                                <th>{{__('เลขครุภัณฑ์')}}</th>
                                <th>{{__('ปัญหาที่พบ')}}</th>
                                <th>{{__('สถานะการเคลม')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($claims as $claim)
                                <tr>
                                    <th>{{ $claim->id }}</th>
                                    <td class="w-full">{{ $claim->equipment->name }}</td>
                                    <td class="font-mono">{{ $claim->equipment->serial_number ?: '-' }}</td>
                                    <td>{{ $claim->problem }}</td>
                                    <td>{{ $claim->status }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-5 mb-3">
                <h1 class="text-2xl mb-3">{{__('รายการซ่อมทั้งหมด')}}</h1>

                @if ($claims->isEmpty())
                    <p>{{__('ยังไม่มีอุปแกรณ์ที่ส่งซ่อมอยู่')}}</p>
                @else
                    <div class="overflow-x-auto">
                        <table class="table border w-full table-zebra">
                            <thead>
                            <tr>
                                <th>
                                    <span class="hidden lg:block">{{__('เลขที่การเคลม')}}</span>
                                </th>
                                <th>{{__('อุปกร์ที่เคลม')}}</th>
                                <th>{{__('เลขครุภัณฑ์')}}</th>
                                <th>{{__('ปัญหาที่พบ')}}</th>
                                <th>{{__('สถานะการเคลม')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($claims as $claim)
                                <tr>
                                    <th>{{ $claim->id }}</th>
                                    <td class="w-full">{{ $claim->equipment->name }}</td>
                                    <td class="font-mono">{{ $claim->equipment->serial_number ?: '-' }}</td>
                                    <td>{{ $claim->problem }}</td>
                                    <td>{{ $claim->status }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-5">
                <h1 class="text-2xl mb-3">{{__('รายการซ่อมทั้งหมด')}}</h1>

                @if ($claims->isEmpty())
                    <p>{{__('ยังไม่มีอุปแกรณ์ที่ส่งซ่อมอยู่')}}</p>
                @else
                    <div class="overflow-x-auto">
                        <table class="table border w-full table-zebra">
                            <thead>
                            <tr>
                                <th>
                                    <span class="hidden lg:block">{{__('เลขที่การเคลม')}}</span>
                                </th>
                                <th>{{__('อุปกร์ที่เคลม')}}</th>
                                <th>{{__('เลขครุภัณฑ์')}}</th>
                                <th>{{__('ปัญหาที่พบ')}}</th>
                                <th>{{__('สถานะการเคลม')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($claims as $claim)
                                <tr>
                                    <th>{{ $claim->id }}</th>
                                    <td class="w-full">{{ $claim->equipment->name }}</td>
                                    <td class="font-mono">{{ $claim->equipment->serial_number ?: '-' }}</td>
                                    <td>{{ $claim->problem }}</td>
                                    <td>{{ $claim->status }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>

    @push('modals')
        <livewire:user.claim-report />
    @endpush

    @push('modals')
        <livewire:user.transfer-report />
    @endpush
</div>
