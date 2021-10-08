<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('หน้าหลัก') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-5">
                <h1 class="text-2xl mb-3">{{__('รายการเคลมอุปกรณ์ทั้งหมด')}}</h1>

                @if ($claims->isEmpty())
                    <p>{{__('ยังไม่มีสินค้าที่ส่งเคลมอยู่')}}</p>
                @else
                    <div class="overflow-x-auto">
                        <table class="table border w-full table-zebra">
                            <thead>
                            <tr>
                                <th>
                                    <span class="hidden lg:block">{{__('เลขที่การเคลม')}}</span>
                                </th>
                                <th>{{__('อุปกร์ที่เคลม')}}</th>
                                <th>{{__('ปัญหาที่พบ')}}</th>
                                <th>{{__('สถานะการเคลม')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($claims as $claim)
                                <tr>
                                    <th>{{ $claim->id }}</th>
                                    <td>{{ $claim->equipment->name }}</td>
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
</div>
