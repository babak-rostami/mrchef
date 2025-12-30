import "../app.js";
import "../utils/button.js";
import { handleForm } from "../component/form/index";
import initialTable from "../component/btable/index.js";

initialTable("r_ingredients");

const form_id = "recipe-ingredient-store-form";

handleForm(form_id, ({ is_error }) => {
    if (!is_error) {
        document.getElementById(form_id).submit();
    }
});

document.addEventListener("DOMContentLoaded", function () {
    const ingredientSelect = document.getElementById("ingredient_id");
    const unitSelect = document.getElementById("unit_id");

    // ابتدا غیرفعال باشد
    unitSelect.disabled = true;

    ingredientSelect.addEventListener("change", function () {
        const ingredientId = this.value;

        // اگر چیزی انتخاب نشده بود
        if (!ingredientId) {
            unitSelect.innerHTML =
                '<option value="">یک واحد اندازه گیری انتخاب کنید...</option>';
            unitSelect.disabled = true;
            return;
        }

        // لودینگ موقت
        unitSelect.innerHTML = '<option value="">در حال بارگذاری...</option>';
        unitSelect.disabled = true;

        fetch(`/admin/select/ingredient/${ingredientId}/units`)
            .then((response) => response.json())
            .then((data) => {
                unitSelect.innerHTML =
                    '<option value="">یک واحد اندازه گیری انتخاب کنید...</option>';

                if (data.length == 0) {
                    unitSelect.innerHTML =
                        '<option value="">واحد اندازه گیری ندارد</option>';
                } else {
                    data.forEach((unit) => {
                        unitSelect.innerHTML += `<option value="${unit.id}">${unit.name}</option>`;
                    });
                    unitSelect.disabled = false;
                }
            })
            .catch(() => {
                unitSelect.innerHTML =
                    '<option value="">خطا در دریافت واحدها</option>';
            });
    });
});

// initial bform for updates
const update_forms = document.querySelectorAll(
    ".recipe-ingredient-update-form"
);
update_forms.forEach((update_form) => {
    handleForm(update_form.id, ({ is_error }) => {
        if (!is_error) {
            document.getElementById(update_form.id).submit();
        }
    });
});
