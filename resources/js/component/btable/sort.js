import { tableState } from "./tableState";

export default function tableSort(wrapper) {
    /**
     * Get all table header cells
     * Only headers with data-sortable="1"
     * will respond to click events
     */
    const headers = wrapper.querySelectorAll(".btable-th");

    /**
     * Loop through each table header
     */
    headers.forEach((th) => {
        /**
         * Skip columns that are not sortable
         */
        if (th.dataset.sortable !== "1") return;

        /**
         * Column key used to find the correct <td>
         * inside each table row
         *
         * Example:
         * data-key="name" → <td data-key="name">
         */
        const key = th.dataset.key;

        /**
         * Sort icon element (caret up / down)
         * Used to show current sort direction
         */
        const icon = th.querySelector("i");

        /**
         * Handle click on sortable header
         */
        th.addEventListener("click", () => {
            /**
             * Reset sort state of other headers
             *
             * When user clicks one column:
             * - All other columns lose their sort order
             * - Their icons are reset to default (caret-down)
             *
             * This ensures only ONE column
             * is visually sorted at a time
             */
            headers.forEach((h) => {
                if (h !== th) {
                    h.dataset.order = "";
                    const i = h.querySelector("i");
                    i?.classList.remove("fa-caret-up");
                    i?.classList.add("fa-caret-down");
                }
            });

            /**
             * Toggle sort direction for current column
             *
             * Logic:
             * - If current order is NOT "asc" → set ascending
             * - Otherwise → set descending
             */
            const asc = th.dataset.order !== "asc";
            th.dataset.order = asc ? "asc" : "desc";

            /**
             * Update sort icon based on direction
             * - asc  → caret-up
             * - desc → caret-down
             */
            icon.classList.toggle("fa-caret-up", asc);
            icon.classList.toggle("fa-caret-down", !asc);

            /**
             * Sort ALL rows globally
             *
             * Important:
             * - Sorting is applied to tableState.sortedRows
             * - This includes ALL rows (not just current page)
             * - Pagination will later decide which rows
             *   are visible based on current page
             */
            tableState.sortedRows.sort((a, b) => {
                /**
                 * Get cell values for the selected column
                 */
                const aVal = a
                    .querySelector(`td[data-key="${key}"]`)
                    .textContent.trim();
                const bVal = b
                    .querySelector(`td[data-key="${key}"]`)
                    .textContent.trim();

                /**
                 * Numeric comparison
                 * If both values are numbers, compare as numbers
                 */
                if (!isNaN(aVal) && !isNaN(bVal)) {
                    return asc ? aVal - bVal : bVal - aVal;
                }

                /**
                 * Text comparison (Persian locale)
                 * Used when values are strings
                 */
                return asc
                    ? aVal.localeCompare(bVal, "fa")
                    : bVal.localeCompare(aVal, "fa");
            });

            /**
             * Notify other table modules (pagination)
             *
             * This custom event tells pagination:
             * - Data order has changed
             * - Rows must be re-rendered
             * - Page should reset if needed
             */
            wrapper.dispatchEvent(new CustomEvent("btable:update"));
        });
    });
}
