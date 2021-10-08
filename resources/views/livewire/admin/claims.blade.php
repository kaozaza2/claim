<div>
    <div class="py-12">
        <div class="tabs max-w-7xl mx-auto lg:px-8">
            <a href="{{ route('admin.claims') }}" class="tab tab-lifted tab-active">
                {{ __('รายการเคลมอุปกรณ์') }}
            </a>
            <a href="{{ route('admin.equipments') }}" class="tab tab-lifted">
                {{ __('รายการอุปกรณ์') }}
            </a>
            <a href="{{ route('admin.departments') }}" class="tab tab-lifted">
                {{ __('หน่วยงานและแผนก') }}
            </a>
            @if(auth()->user()->isSuperAdmin())
                <a href="{{ route('admin.departments') }}" class="tab tab-lifted">
                    {{ __('จัดการบัญชีผู้ใช้และแอดมิน') }}
                </a>
            @endif
        </div>

        <div class="max-w-7xl sm:rounded-lg bg-white mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden sm:py-6 lg:py-8 px-0">
                <div class="flex-none lg:flex mb-3">
                    <div class="form-control w-full mr-2">
                        <input type="text" placeholder="ค้นหา" class="input input-bordered">
                    </div>
                    <button class="btn btn-success ml-auto">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="transform rotate-45 inline-block w-6 h-6 mr-2 stroke-current">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        {{ __('เพิ่ม') }}
                    </button>
                </div>
                <div class="overflow-x-auto">
                    <table class="table table-compact border w-full table-zebra">
                        <thead>
                        <tr>
                            <th>
                                <span class="hidden lg:block">{{__('เลขที่การเคลม')}}</span>
                            </th>
                            <th>{{__('อุปกร์ที่เคลม')}}</th>
                            <th>{{__('อาการ')}}</th>
                            <th>{{__('ผู้แจ้งเรื่อง')}}</th>
                            <th>{{__('ผู้รับเรื่อง')}}</th>
                            <th scope="col"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($claims as $claim)
                            <tr>
                                <th>{{ $claim->id }}</th>
                                <td>{{ $claim->equipment->name }}</td>
                                <td class="w-full">{{ $claim->problem }}</td>
                                <td>{{ $claim->user->fullname }}</td>
                                <td>{{ $claim->admin->fullname }}</td>
                                <td>
                                    <button class="btn btn-sm">{{ __('แก้ไข') }}</button>
                                    <button class="btn btn-sm btn-error">{{ __('ลบ') }}</button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>
