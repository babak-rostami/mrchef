import { handleForm } from '../component/form/create/index';

const form_id = 'ingredient-update-form';

handleForm(form_id, ({ is_error }) => {
    if (!is_error) {
        document.getElementById(form_id).submit();
    }
});
