<div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-5">
    <h1 class="text-2xl mb-3">{{__('รายการซ่อมทั้งหมด')}}</h1>

    @if ($claims->isEmpty())
        <p>{{__('ยังไม่มีอุปกรณ์ที่ส่งซ่อมอยู่')}}</p>
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
