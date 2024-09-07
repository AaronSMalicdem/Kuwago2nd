@props(['value', 'textSize' => 'text-sm'])

<label {{ $attributes->merge(['class' => 'block font-medium '.$textSize.' text-gray-700']) }}>
    {{ $value ?? $slot }}
</label>
