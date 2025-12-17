import "../app";
import { handleForm, createImages } from "../component/form/index";

const form_id = "ingredient-store-form";

createImages(["image"]);

handleForm(form_id, ({ is_error }) => {
    if (!is_error) {
        document.getElementById(form_id).submit();
    }
});
