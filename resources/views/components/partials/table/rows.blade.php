@props(['columns', 'rows'])

@foreach ($rows as $row)
    <tr class="btable-row border-b-2 border-b-gray-100 hover:bg-gray-50">
        @foreach ($columns as $col)
            <td class="btable-td px-4 py-2" data-key="{{ $col['key'] }}"
                data-searchable="{{ $col['searchable'] ?? false }}">
                @if (isset($col['view']))
                    @include($col['view'], ['row' => $row])
                @else
                    {{ data_get($row, $col['key']) }}
                @endif
            </td>
        @endforeach
    </tr>
@endforeach
