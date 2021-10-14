<x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
            <x-jet-authentication-card-logo/>
        </x-slot>

        <x-jet-validation-errors class="mb-4"/>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div>
                <x-jet-label for="name" value="{{ __('ชื่อ') }}"/>
                <div class="flex">
                    <x-jet-input id="title" class="block mt-1 w-1/3" type="text" name="title" placeholder="คำนำหน้า"
                                 :value="old('title')" required autofocus autocomplete="title"/>
                    <x-jet-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')"
                                 required autofocus autocomplete="name"/>
                </div>
            </div>

            <div class="mt-4">
                <x-jet-label for="last_name" value="{{ __('นามสกุล') }}"/>
                <x-jet-input id="last_name" class="block mt-1 w-full" type="text" name="last_name"
                             :value="old('last_name')" required autofocus autocomplete="last_name"/>
            </div>

            <div class="mt-4">
                <x-jet-label for="sex" value="{{ __('เพศ') }}"/>
                <select
                    class="w-full mt-1 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                    id="sex" name="sex" required>
                    <option selected disabled>เลือก</option>
                    <option value="male">ชาย</option>
                    <option value="female">หญิง</option>
                </select>
            </div>

            <div class="mt-4">
                <x-jet-label for="identification" value="{{ __('เลขบัตรประชาชน') }}"/>
                <x-jet-input id="identification" class="block mt-1 w-full" type="text" name="identification"
                             :value="old('identification')" required autofocus/>
            </div>

            <div class="mt-4">
                <x-jet-label for="sub_department_id" value="{{ __('หน่วยงาน/แผนก') }}"/>
                <select class="w-full mt-1 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                    id="sub_department_id" name="sub_department_id" required>
                    @foreach (\App\Models\Department::all() as $dep)
                        @if ($dep->subs->isEmpty())
                            @continue
                        @endif
                        <option disabled>{{ $dep->name }}</option>
                        @foreach ($dep->subs as $sub)
                            <option value="{{ $sub->id }}"> - {{ $sub->name }}</option>
                        @endforeach
                    @endforeach
                </select>
            </div>

            <div class="mt-4">
                <x-jet-label for="username" value="{{ __('ชื่อผู้ใช้') }}"/>
                <x-jet-input id="username" class="block mt-1 w-full" type="text" name="username" :value="old('username')"
                             required/>
            </div>

            <div class="mt-4">
                <x-jet-label for="email" value="{{ __('อีเมล') }}"/>
                <x-jet-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                             required/>
            </div>

            <div class="mt-4">
                <x-jet-label for="password" value="{{ __('รหัสผ่าน') }}"/>
                <x-jet-input id="password" class="block mt-1 w-full" type="password" name="password" required
                             autocomplete="new-password"/>
            </div>

            <div class="mt-4">
                <x-jet-label for="password_confirmation" value="{{ __('ยืนยันรหัสผ่าน') }}"/>
                <x-jet-input id="password_confirmation" class="block mt-1 w-full" type="password"
                             name="password_confirmation" required autocomplete="new-password"/>
            </div>

            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                <div class="mt-4">
                    <x-jet-label for="terms">
                        <div class="flex items-center">
                            <x-jet-checkbox name="terms" id="terms"/>

                            <div class="ml-2">
                                {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                        'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-sm text-gray-600 hover:text-gray-900">'.__('Terms of Service').'</a>',
                                        'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-sm text-gray-600 hover:text-gray-900">'.__('Privacy Policy').'</a>',
                                ]) !!}
                            </div>
                        </div>
                    </x-jet-label>
                </div>
            @endif

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                    {{ __('เคยลงทะเบียนแล้ว?') }}
                </a>

                <x-jet-button class="ml-4">
                    {{ __('ลงทะเบียน') }}
                </x-jet-button>
            </div>
        </form>
    </x-jet-authentication-card>
</x-guest-layout>
