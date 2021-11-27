<div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-5">
    <h1 class="text-2xl mb-3">{{__('รายการซ่อมทั้งหมด')}}</h1>

    @if (blank($claims))
        <p>{{__('ยังไม่มีอุปกรณ์ที่ส่งซ่อมอยู่')}}</p>
    @else
        <div class="overflow-x-auto">
            <table class="table table-compact border w-full table-zebra">
                <thead>
                <tr>
                    <th>
                        <span class="hidden lg:block">{{__('เลขที่การเคลม')}}</span>
                    </th>
                    <th colspan="3">{{__('app.equipment')}}</th>
                    <th>{{__('app.equipments.serial')}}</th>
                    <th>{{__('app.claims.applicant')}}</th>
                    <th>{{__('app.claims.problem')}}</th>
                    <th>{{__('app.status')}}</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($claims as $claim)
                    <tr>
                        <th>{{ $claim->id }}</th>
                        <td>{{ $claim->equipment }}</td>
                        <td>{{ $claim->equipment->brand }}</td>
                        <td>{{ $claim->equipment->category }}</td>
                        <td class="font-mono">
                            {{ $claim->equipment->serial_number ?: '-' }}
                        </td>
                        <td>{{ $claim->user }}</td>
                        <td>{{ $claim->problem }}</td>
                        <td>{{ $claim->status }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-2">
            {{ $claims->links() }}
        </div>
    @endif
</div>
