@props(['for', 'hint' => null])

@if($hint || $errors->has($for))
    <small {{ $attributes->merge(['class' => 'text-sm text-red-600']) }}>{{ $errors->first($for) ?: $hint }}</small>
@endif
