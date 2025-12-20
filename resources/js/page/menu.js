document.addEventListener("DOMContentLoaded", () => {
    const toggleBtn = document.getElementById("profile-toggle");
    const dropdown = document.getElementById("profile-dropdown");
    const loginBtn = document.getElementById("login-btn");
    const searchBtn = document.getElementById("search-btn");

    if (!toggleBtn || !dropdown) return;

    // Toggle dropdown
    toggleBtn.addEventListener("click", (e) => {
        e.stopPropagation();
        dropdown.classList.toggle("hidden");
    });

    // Close on outside click
    document.addEventListener("click", (e) => {
        if (!dropdown.contains(e.target) && !toggleBtn.contains(e.target)) {
            dropdown.classList.add("hidden");
        }
    });

    // Login modal
    if (loginBtn) {
        loginBtn.addEventListener("click", () => {
            dropdown.classList.add("hidden");
            openModal("user-login");
        });
    }

    // Search modal
    if (searchBtn) {
        searchBtn.addEventListener("click", () => {
            openSearchModal();
        });
    }
});
