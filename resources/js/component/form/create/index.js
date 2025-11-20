import { validateForm } from './validation';
import { initEditor } from '../../ckeditor/index';
import { isErrorInForm } from '../action';

export function createCkeditors(ckeditors) {
    ckeditors.forEach(editor => {
        initEditor(editor.id, editor.url);
    });
}

export function handleForm(form_id, onSubmitCallback) {
    const form = document.getElementById(form_id);

    form.addEventListener('submit', function (e) {
        e.preventDefault();

        validateForm(form_id);

        const is_error = isErrorInForm(form_id);

        if (typeof onSubmitCallback === 'function') {
            onSubmitCallback({
                is_error
            });
        }
    });
}
