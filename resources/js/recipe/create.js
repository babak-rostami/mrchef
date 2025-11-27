import { handleForm, createCkeditors, createImages } from '../component/form/index';

const form_id = 'recipes-store-form';
const page = 'recipe_create';

let ck_up_url = "/bf-ckeditor-upload/" + page + '?_token=';
ck_up_url += document.getElementById(form_id).querySelector('input[name="_token"]').value;

const ckeditors = [{ id: 'body', url: ck_up_url }];

createCkeditors(ckeditors);
createImages(['image']);

handleForm(form_id, ({ is_error }) => {
    if (!is_error) {
        document.getElementById(form_id).submit();
    }
});
