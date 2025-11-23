// --- for tailwind dark mode ---
const html = document.documentElement;
const toggleBtn = document.getElementById("theme-toggle");

// --- Load Theme From LocalStorage ---
const savedTheme = localStorage.getItem("theme");

if (savedTheme === "dark") {
    html.classList.add("dark");
} else if (savedTheme === "light") {
    html.classList.remove("dark");
} else {
    // Default: follow system
    if (window.matchMedia("(prefers-color-scheme: dark)").matches) {
        html.classList.add("dark");
    }
}

updateButtonText();

// --- Toggle Theme ---
toggleBtn.addEventListener("click", () => {
    const isDark = html.classList.toggle("dark");

    localStorage.setItem("theme", isDark ? "dark" : "light");

    updateButtonText();
});

// --- Update Button Text ---
function updateButtonText() {
    if (html.classList.contains("dark")) {
        toggleBtn.textContent = "🌙 حالت شب";
    } else {
        toggleBtn.textContent = "☀️ حالت روز";
    }
}
