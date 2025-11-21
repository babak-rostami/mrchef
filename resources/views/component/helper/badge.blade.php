@if ($class == 'danger')
    <span class="font-bold text-sm rounded-2xl px-3 py-0.5 text-red-800 bg-red-200">{{ $title }}</span>
@elseif($class == 'warning')
    <span class="font-bold text-sm rounded-2xl px-3 py-0.5 text-orange-800 bg-orange-200">{{ $title }}</span>
@elseif($class == 'success')
    <span class="font-bold text-sm rounded-2xl px-3 py-0.5 text-green-800 bg-green-200">{{ $title }}</span>
@endif
