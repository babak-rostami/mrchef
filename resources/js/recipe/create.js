import {
    handleForm,
    createCkeditors,
    createImages,
    ckeditorUploadUrl,
} from "../component/form/index";

const form_id = "recipes-store-form";

createCkeditors([
    { id: "body", url: ckeditorUploadUrl("recipe", "body", form_id) },
]);
createImages(["image"]);

handleForm(form_id, ({ is_error }) => {
    if (!is_error) {
        document.getElementById(form_id).submit();
    }
});
