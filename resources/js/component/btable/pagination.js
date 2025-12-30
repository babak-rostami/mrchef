import { tableState } from "./tableState";

export default function tablePagination(wrapper) {
    /**
     * Main table body element
     * All table rows will be rendered inside this element
     */
    const tbody = wrapper.querySelector(".btable-body");

    /**
     * Select element that controls
     * how many rows should be shown per page
     */
    const perPageSelect = wrapper.querySelector(".btable-per-page");

    /**
     * Container for pagination buttons
     * Example: 1 2 3 ... 10
     */
    const pagesWrapper = wrapper.querySelector(".btable-pages");

    /**
     * Element that shows total number of results
     * Example: "25 results"
     */
    const totalEl = wrapper.querySelector(".btable-total");

    /**
     * Current active page number
     * Starts from page 1
     */
    let currentPage = 1;

    /**
     * Number of rows per page
     * This value comes from the select input
     */
    let perPage = +perPageSelect.value;

    /**
     * Render rows for the current page
     *
     * How this works:
     * 1. Get all rows from tableState.sortedRows
     *    (this already includes search + sort results)
     * 2. Calculate start & end index for current page
     * 3. Clear table body
     * 4. Append only rows that belong to this page
     * 5. Update total results text
     */
    function renderRows() {
        const rows = tableState.sortedRows;
        const total = rows.length;

        const start = (currentPage - 1) * perPage;
        const end = start + perPage;

        tbody.innerHTML = "";
        rows.slice(start, end).forEach((row) => tbody.appendChild(row));

        totalEl.textContent = total;
    }

    /**
     * Render pagination buttons
     * Example output:
     * 1 2 3 ... 10
     *
     * Pagination logic:
     * - Always show first page
     * - Always show last page
     * - Show pages around current page
     * - Use "..." when pages are skipped
     */
    function renderPages() {
        pagesWrapper.innerHTML = "";

        const totalRows = tableState.sortedRows.length;
        const totalPages = Math.ceil(totalRows / perPage);

        /**
         * If there is only one page (or zero),
         * pagination buttons are not needed
         */
        if (totalPages <= 1) return;

        /**
         * Number of pages to show
         * before and after the current page
         */
        const delta = 1;

        /**
         * Pages array will contain:
         * numbers + "..." placeholders
         */
        let pages = [1];

        let start = Math.max(2, currentPage - delta);
        let end = Math.min(totalPages - 1, currentPage + delta);

        /**
         * Add dots if pages are skipped at the beginning
         */
        if (start > 2) pages.push("...");

        /**
         * Add page numbers around current page
         */
        for (let i = start; i <= end; i++) {
            pages.push(i);
        }

        /**
         * Add dots if pages are skipped at the end
         */
        if (end < totalPages - 1) pages.push("...");

        /**
         * Always show last page
         */
        pages.push(totalPages);

        /**
         * Render pagination buttons / dots
         */
        pages.forEach((page) => {
            /**
             * Render dots ("...")
             */
            if (page === "...") {
                const span = document.createElement("span");
                span.textContent = "...";
                span.className = "px-3 py-2 text-gray-400";
                pagesWrapper.appendChild(span);
                return;
            }

            /**
             * Render page button
             */
            const btn = document.createElement("button");
            btn.textContent = page;
            btn.className =
                "px-4 py-2 border border-gray-300 rounded cursor-pointer " +
                (page === currentPage
                    ? "bg-gray-100"
                    : "bg-white hover:bg-gray-100");

            /**
             * When user clicks a page:
             * 1. Update currentPage
             * 2. Re-render rows
             * 3. Re-render pagination buttons
             */
            btn.addEventListener("click", () => {
                currentPage = page;
                renderRows();
                renderPages();
            });

            pagesWrapper.appendChild(btn);
        });
    }

    /**
     * Handle change of "per page" select
     *
     * When user changes rows per page:
     * - Reset to first page
     * - Re-render rows
     * - Re-render pagination buttons
     */
    perPageSelect.addEventListener("change", () => {
        perPage = +perPageSelect.value;
        currentPage = 1;
        renderRows();
        renderPages();
    });

    /**
     * Listen to custom "btable:update" event
     *
     * This event is fired when:
     * - Search changes
     * - Sort changes
     *
     * In both cases:
     * - Data set has changed
     * - Pagination must reset and re-render
     */
    wrapper.addEventListener("btable:update", () => {
        currentPage = 1;
        renderRows();
        renderPages();
    });

    /**
     * Initial render
     * Runs once when table is initialized
     */
    renderRows();
    renderPages();
}
