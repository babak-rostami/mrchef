@props(['columns' => [], 'rows' => []])

<div class="btable-wrapper w-full">

    {{-- Search --}}
    <div class="mb-4">
        <input type="text" class="btable-search w-64 border rounded-lg px-3 py-2 focus:ring focus:outline-none"
            placeholder="Search...">
    </div>

    <div class="overflow-x-auto">
        <table class="btable-table w-full border-collapse">
            <thead class="bg-gray-100">
                <tr>
                    @foreach ($columns as $col)
                        <th class="btable-th px-4 py-2 text-left select-none
                                   {{ $col['sortable'] ?? false ? 'cursor-pointer' : '' }}"
                            data-key="{{ $col['key'] }}" data-sortable="{{ $col['sortable'] ?? false }}"
                            data-searchable="{{ $col['searchable'] ?? false }}">
                            {{ $col['label'] }}
                        </th>
                    @endforeach
                </tr>
            </thead>

            <tbody class="btable-body">
                @foreach ($rows as $row)
                    <x-partials.table.rows :row="$row" :columns="$columns" />
                @endforeach
            </tbody>
        </table>
    </div>
</div>
