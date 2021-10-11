<x-jet-form-section submit="updateProfileInformation">
    <x-slot name="title">
        {{ __('ข้อมูลโปรไฟล์') }}
    </x-slot>

    <x-slot name="description">
        {{ __('ปรับเปลี่ยนข้อมูลโปรไฟล์ของคุณ') }}
    </x-slot>

    <x-slot name="form">
        <!-- Profile Photo -->
        @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
            <div x-data="{photoName: null, photoPreview: null}" class="col-span-6 sm:col-span-4">
                <!-- Profile Photo File Input -->
                <input type="file" class="hidden"
                            wire:model="photo"
                            x-ref="photo"
                            x-on:change="
                                    photoName = $refs.photo.files[0].name;
                                    const reader = new FileReader();
                                    reader.onload = (e) => {
                                        photoPreview = e.target.result;
                                    };
                                    reader.readAsDataURL($refs.photo.files[0]);
                            " />

                <x-jet-label for="photo" value="{{ __('Photo') }}" />

                <!-- Current Profile Photo -->
                <div class="mt-2" x-show="! photoPreview">
                    <img src="{{ $this->user->profile_photo_url }}" alt="{{ $this->user->name }}" class="rounded-full h-20 w-20 object-cover">
                </div>

                <!-- New Profile Photo Preview -->
                <div class="mt-2" x-show="photoPreview">
                    <span class="block rounded-full w-20 h-20 bg-cover bg-no-repeat bg-center"
                          x-bind:style="'background-image: url(\'' + photoPreview + '\');'">
                    </span>
                </div>

                <x-jet-secondary-button class="mt-2 mr-2" type="button" x-on:click.prevent="$refs.photo.click()">
                    {{ __('Select A New Photo') }}
                </x-jet-secondary-button>

                @if ($this->user->profile_photo_path)
                    <x-jet-secondary-button type="button" class="mt-2" wire:click="deleteProfilePhoto">
                        {{ __('Remove Photo') }}
                    </x-jet-secondary-button>
                @endif

                <input-error for="photo" class="mt-2" />
            </div>
        @endif

        <!-- Title -->
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="title" value="{{ __('คำนำหน้า') }}" />
            <input id="title" type="text" class="input input-bordered mt-1 block w-full" wire:model.defer="state.title" autocomplete="title" />
            <input-error for="title" class="mt-2" />
        </div>

        <!-- Name -->
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="name" value="{{ __('ชื่อ') }}" />
            <input id="name" type="text" class="input input-bordered mt-1 block w-full" wire:model.defer="state.name" autocomplete="name" />
            <input-error for="name" class="mt-2" />
        </div>

        <!-- Last Name -->
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="last_name" value="{{ __('นามสกุล') }}" />
            <input id="last_name" type="text" class="input input-bordered mt-1 block w-full"
                         wire:model.defer="state.last_name" autocomplete="last_name" />
            <input-error for="last_name" class="mt-2" />
        </div>

        <!-- Identification -->
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="identification" value="{{ __('เลขบัตรประจำตัวประชาชน') }}" />
            <input id="identification" type="text" class="input input-bordered mt-1 block text-gray-500 w-full"
                         wire:model.defer="state.identification" readonly />
        </div>

        <!-- Department -->
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="department" value="{{ __('หน่วยงาน') }}" />
            <input id="department" type="text" class="input input-bordered mt-1 block text-gray-500 w-full"
                         value="{{ $this->user->subDepartment->department->name }}" readonly />
        </div>

        <!-- Sub Department -->
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="sub_department" value="{{ __('แผนก') }}" />
            <input id="sub_department" type="text" class="input input-bordered mt-1 block text-gray-500 w-full"
                         value="{{ $this->user->subDepartment->name }}" readonly />
        </div>

        <!-- Email -->
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="email" value="{{ __('อีเมล') }}" />
            <input id="email" type="email" class="input input-bordered mt-1 block w-full" wire:model.defer="state.email">
            <input-error for="email" class="mt-2" />
        </div>
    </x-slot>

    <x-slot name="actions">
        <x-jet-action-message class="mr-3" on="saved">
            {{ __('สำเร็จ.') }}
        </x-jet-action-message>

        <button class="btn" wire:loading.attr="disabled" wire:target="photo">
            {{ __('บันทึก') }}
        </button>
    </x-slot>
</x-jet-form-section>
