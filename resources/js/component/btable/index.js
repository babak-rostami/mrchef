import tableSearch from "./search";
import tableSort from "./sort";
import tablePagination from "./pagination";
import { tableState } from "./tableState";

export default function initialTable(table_id) {
    const wrapper = document.getElementById(table_id);
    const rows = Array.from(wrapper.querySelectorAll(".btable-row"));

    tableState.allRows = rows;
    tableState.filteredRows = [...rows];
    tableState.sortedRows = [...rows];

    // SEARCH
    tableSearch(wrapper);

    // SORT
    tableSort(wrapper);

    // PAGINATION
    tablePagination(wrapper);
}
