@props(['padding' => true])

<div {{ $attributes->merge(['class' => 'max-w-7xl shadow sm:rounded-lg bg-white mt-6 mx-auto sm:px-6 lg:px-8']) }}>
    <div @class(['overflow-hidden', 'sm:py-6' => $padding, 'lg:py-8' => $padding, 'px-0' => $padding])>
        {{ $slot }}
    </div>
</div>
