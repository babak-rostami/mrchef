import { createImages, handleForm } from '../component/form/index';

const form_id = 'ingredient-update-form';

createImages(['image'])

handleForm(form_id, ({ is_error }) => {
    if (!is_error) {
        document.getElementById(form_id).submit();
    }
});
