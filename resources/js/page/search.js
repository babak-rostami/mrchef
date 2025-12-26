const searchInput = document.getElementById("main-search-input");
const resultsDiv = document.getElementById("search-results");
const notFoundDiv = document.getElementById("search-404-div");
const defaultDiv = document.getElementById("search-default-div");
let searchTimeout;

searchInput.addEventListener("input", function () {
    if (searchTimeout) {
        clearTimeout(searchTimeout);
    }

    searchTimeout = setTimeout(() => {
        const query = searchInput.value.trim();

        if (query.length >= 2) {
            axios
                .post("/search", { query: query })
                .then((response) => {
                    resultsDiv.innerHTML = showSearchResults(
                        response.data.recipes
                    );
                })
                .catch((error) => {
                    showDefault();
                });
        } else {
            showDefault();
        }
    }, 2000);
});
function showSearchResults(recipes) {
    if (recipes.length === 0) {
        showNotFound();
    } else {
        showResluts();
        // میخوام اگه نتایج زیاد بود اسکرول بشه عمودی ولی افقی اسکرول میاد
        let html = "<ul class='mt-4 max-h-96 overflow-y-auto'>";
        recipes.forEach((recipe) => {
            html += `<li class="hover:scale-y-110 shadow duration-300 mb-2 rounded-lg">
                        <a href="/recipe/${recipe.slug}" class="flex items-center px-4 py-2 hover:bg-gray-100">
                            <img src="${recipe.image_url}" alt="${recipe.title}" class="w-16 h-16 object-contain rounded-lg ml-2">
                            <span class="text-2xl">${recipe.title}</span>
                        </a>
                    </li>`;
        });
        html += "</ul>";
        return html;
    }
}

function showResluts() {
    defaultDiv.classList.add("hidden");
    resultsDiv.classList.remove("hidden");
    notFoundDiv.classList.add("hidden");
}

function showNotFound() {
    defaultDiv.classList.add("hidden");
    notFoundDiv.classList.remove("hidden");
    resultsDiv.classList.add("hidden");
}

function showDefault() {
    defaultDiv.classList.remove("hidden");
    resultsDiv.classList.add("hidden");
    notFoundDiv.classList.add("hidden");
}
