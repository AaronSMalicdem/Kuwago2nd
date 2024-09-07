@props(['category' => '', 'img' => ''])

<div {{ $attributes->merge(['class' => 'border-2 rounded-lg p-1 lg:p-2 m-1 cursor-pointer flex flex-col items-center justify-center bg-white']) }}>
    <div>
        <img src="{{ asset($img) }}" class=" h-12 mx-auto">
    </div>
    <div class="mt-3 text-center text-xs" >{{ $category }}</div>
</div>
