<div class="btable-pagination flex items-center justify-between px-4 mt-4 text-sm w-full">


    {{-- Pages --}}
    <div class="btable-pages flex gap-1"></div>

    <div class="flex items-center gap-4">
        {{-- Per page --}}
        <div class="flex items-center gap-2">
            <select class="btable-per-page border border-gray-300 outline-0 rounded px-2 py-1">
                <option value="5">5</option>
                <option value="10" selected>10</option>
                <option value="25">25</option>
                <option value="50">50</option>
            </select>
        </div>

        {{-- Showing text --}}
        <div class="btable-info text-gray-600">
            <span class="btable-total">0</span>
            نتیجه
        </div>
    </div>
</div>
