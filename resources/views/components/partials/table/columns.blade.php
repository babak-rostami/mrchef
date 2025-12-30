@props(['columns'])

@foreach ($columns as $col)
    <th class="btable-th p-4 bg-gray-50 border-y border-y-gray-100 hover:scale-105 duration-300
                                   {{ $col['sortable'] ?? false ? 'cursor-pointer' : '' }}"
        data-key="{{ $col['key'] }}" data-sortable="{{ $col['sortable'] ?? false }}">
        {{ $col['label'] }}
        @if (isset($col['sortable']))
            <i class="fa fa-caret-down text-gray-400"></i>
        @endif
    </th>
@endforeach
