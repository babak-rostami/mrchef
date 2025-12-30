@props(['columns' => [], 'rows' => [], 'id'])

<div class="w-full border-2 border-gray-100 rounded-2xl py-4" id="{{ $id }}">

    {{-- Search --}}
    <x-partials.table.search />

    <div class="overflow-x-auto">
        <table class="btable-table w-full border-collapse">
            <thead class="bg-gray-100 text-right">
                <tr>
                    {{-- Table Columns --}}
                    <x-partials.table.columns :columns="$columns" />
                </tr>
            </thead>

            <tbody class="btable-body">
                {{-- Table rows --}}
                <x-partials.table.rows :rows="$rows" :columns="$columns" />
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <x-partials.table.pagination />

</div>
