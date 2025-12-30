import "../../js/app.js";
import initialTable from "../component/btable/index.js";

initialTable("categories");

// for delete btn
window.submitForm = function (btn, wait_text) {
    // جلوگیری از کلیک مجدد
    setTimeout(() => {
        btn.disabled = true;
    }, 10);
    btn.classList.add("opacity-50", "cursor-not-allowed");
    btn.innerText = wait_text;
};
