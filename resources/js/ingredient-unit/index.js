import "../app.js";
import "../utils/button.js";
import { handleForm } from "../component/form/index";
import initialTable from "../component/btable/index.js";

initialTable("ingredient_units");

const form_id = "ingredient-unit-store-form";

handleForm(form_id, ({ is_error }) => {
    if (!is_error) {
        document.getElementById(form_id).submit();
    }
});

//initial bform for updates
const update_forms = document.querySelectorAll(".ingredient-unit-update-form");
update_forms.forEach((update_form) => {
    handleForm(update_form.id, ({ is_error }) => {
        if (!is_error) {
            document.getElementById(update_form.id).submit();
        }
    });
});
