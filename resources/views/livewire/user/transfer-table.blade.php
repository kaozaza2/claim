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
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
