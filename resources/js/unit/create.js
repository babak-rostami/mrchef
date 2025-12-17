import '../app';
import { handleForm } from '../component/form/index';

const form_id = 'unit-store-form';

handleForm(form_id, ({ is_error }) => {
    if (!is_error) {
        document.getElementById(form_id).submit();
    }
});
