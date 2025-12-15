document.querySelectorAll(".btable-wrapper").forEach((wrapper) => {
    const searchInput = wrapper.querySelector(".btable-search");
    const rows = Array.from(wrapper.querySelectorAll(".btable-row"));
    const headers = wrapper.querySelectorAll(".btable-th");

    // SEARCH
    searchInput.addEventListener("input", (e) => {
        const value = e.target.value.toLowerCase();

        rows.forEach((row) => {
            const searchableTds = Array.from(row.querySelectorAll("td")).filter(
                (td) => {
                    const key = td.dataset.key;
                    return (
                        wrapper.querySelector(`.btable-th[data-key="${key}"]`)
                            ?.dataset.searchable === "true"
                    );
                }
            );

            const match = searchableTds.some((td) =>
                td.textContent.toLowerCase().includes(value)
            );

            row.classList.toggle("hidden", !match);
        });
    });

    // SORT
    headers.forEach((th) => {
        if (th.dataset.sortable !== "true") return;

        let asc = true;

        th.addEventListener("click", () => {
            const key = th.dataset.key;
            asc = !asc;

            const sorted = rows.sort((a, b) => {
                const aText = a.querySelector(
                    `td[data-key="${key}"]`
                ).textContent;
                const bText = b.querySelector(
                    `td[data-key="${key}"]`
                ).textContent;

                return asc
                    ? aText.localeCompare(bText)
                    : bText.localeCompare(aText);
            });

            const tbody = wrapper.querySelector(".btable-body");
            tbody.innerHTML = "";
            sorted.forEach((r) => tbody.appendChild(r));
        });
    });
});
