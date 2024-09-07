@if(session('message'))
<div class="bg-green-500 w-full py-3 px-5 rounded text-white mb-3">
    {{ session('message') }}
</div>
@endif
