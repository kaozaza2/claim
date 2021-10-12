<div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-5">
    <h1 class="text-2xl mb-3">{{__('รายการรอซ่อมทั้งหมด')}}</h1>

    @if ($preClaims->isEmpty())
        <p>{{__('ยังไม่มีรายการรายการรอซ่อม')}}</p>
    @else
        <div class="overflow-x-auto">
            <table class="table border w-full table-zebra">
                <thead>
                <tr>
                    <th>
                        <span class="hidden lg:block">{{__('No.')}}</span>
                    </th>
                    <th>{{__('อุปกร์ที่ส่งซ่อม')}}</th>
                    <th>{{__('เลขครุภัณฑ์')}}</th>
                    <th>{{__('ปัญหาที่พบ')}}</th>
                    <th>{{__('วันที่ยื่นเรื่อง')}}</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($preClaims as $pre)
                    <tr>
                        <th>{{ $loop->index + 1 }}</th>
                        <td class="w-full">{{ $pre->equipment->name }}</td>
                        <td class="font-mono">{{ $pre->equipment->serial_number ?: '-' }}</td>
                        <td>{{ $pre->problem }}</td>
                        <td>{{ $pre->created_at->format('Y-m-d') }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
