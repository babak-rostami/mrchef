import { handleForm, createCkeditors } from "../component/form/index";

const form_id = "comment-update-form";
const page = "comment_edit";

let ck_up_url = "/admin_page/bf-ckeditor-upload/" + page + "?_token=";
ck_up_url += document
    .getElementById(form_id)
    .querySelector('input[name="_token"]').value;

const ckeditors = [{ id: "content", url: ck_up_url }];

createCkeditors(ckeditors);

handleForm(form_id, ({ is_error }) => {
    if (!is_error) {
        document.getElementById(form_id).submit();
    }
});
