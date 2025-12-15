@props(['columns', 'row'])

<tr class="btable-row border-b hover:bg-gray-50">
    @foreach ($columns as $col)
        <td class="btable-td px-4 py-2" data-key="{{ $col['key'] }}">
            @if (isset($col['view']))
                @include($col['view'], ['row' => $row])
            @else
                {{ data_get($row, $col['key']) }}
            @endif
        </td>
    @endforeach
</tr>
