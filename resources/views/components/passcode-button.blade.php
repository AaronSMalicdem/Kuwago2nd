<button
    {{ $attributes->merge(['type' => 'button','class' =>"justify-items-center bg-green-500 hover:bg-green-900 text-white p-3 rounded-lg" ]) }}>
    {{ $slot }}
</button>
