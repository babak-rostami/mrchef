import { tableState } from "./tableState";

export default function tableSearch(wrapper) {
    /**
     * Search input element inside table wrapper
     *
     * This input is responsible for filtering table rows
     * based on user typed text.
     */
    const searchInput = wrapper.querySelector(".btable-search");

    /**
     * Create "no results found" message element
     *
     * This element is:
     * - Created once
     * - Appended to the table wrapper
     * - Shown only when search returns ZERO results
     *
     * It improves UX by clearly telling the user
     * that no rows matched the search query.
     */
    const emptyMessage = document.createElement("div");
    emptyMessage.className =
        "btable-empty hidden text-center text-gray-500 py-10";
    emptyMessage.innerHTML = `
        <div class="text-2xl text-gray-800 font-medium mb-1">
            نتیجه‌ای پیدا نشد
        </div>
        <div class="text-sm text-gray-400">
            عبارت جستجو را تغییر دهید
        </div>
    `;

    /**
     * Append empty message to table wrapper
     *
     * This ensures:
     * - The message is inside the same table component
     * - It appears in correct visual position
     * - We do NOT recreate it on every search
     */
    wrapper.appendChild(emptyMessage);

    /**
     * Listen to user typing inside search input
     *
     * The "input" event fires on:
     * - typing
     * - deleting
     * - pasting text
     *
     * This makes the search fully reactive.
     */
    searchInput.addEventListener("input", (e) => {
        /**
         * Normalize search value
         *
         * - Convert to lowercase
         * - Makes search case-insensitive
         */
        const value = e.target.value.toLowerCase();

        /**
         * Filter ALL table rows (source of truth)
         *
         * tableState.allRows:
         * - Contains every row in the table
         * - Is NEVER modified
         *
         * The result of this filter is stored in:
         * tableState.filteredRows
         */
        tableState.filteredRows = tableState.allRows.filter((row) => {
            /**
             * Get only searchable table cells
             *
             * Cells must have:
             * data-searchable="1"
             *
             * This prevents searching inside:
             * - action buttons
             * - icons
             * - non-text columns
             */
            const searchableTds = Array.from(
                row.querySelectorAll("td[data-searchable='1']")
            );

            /**
             * Check if at least one searchable cell
             * contains the search value
             */
            return searchableTds.some((td) =>
                td.textContent.toLowerCase().includes(value)
            );
        });

        /**
         * Keep current sort order after search
         *
         * Important:
         * - Search should NOT break sorting
         * - filteredRows becomes the new data set
         * - sortedRows is updated from filteredRows
         *
         * Sorting module will re-order this array later if needed
         */
        tableState.sortedRows = [...tableState.filteredRows];

        /**
         * Toggle empty state message visibility
         *
         * If search has results:
         * - Hide empty message
         *
         * If search has NO results:
         * - Show empty message
         */
        const hasResult = tableState.filteredRows.length > 0;
        emptyMessage.classList.toggle("hidden", hasResult);

        /**
         * Notify other table modules (pagination)
         *
         * This custom event tells pagination:
         * - Data set has changed
         * - Page count must be recalculated
         * - Current page should reset if needed
         */
        wrapper.dispatchEvent(new CustomEvent("btable:update"));
    });
}
