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

    //با زدن دکمه Enter کیبورد فرم سابمیت نشه
    form.addEventListener('keydown', function (e) {
        if (e.key === 'Enter') {
            e.preventDefault();
        }
    });

    form.addEventListener('submit', function (e) {
        e.preventDefault();

        validateForm(form_id);

        const is_error = isErrorInForm(form_id);

        if (!is_error) {
            document.getElementById('bf-submit-btn').disabled = true;
            document.getElementById('bf-submit-btn').innerText = 'در حال ثبت ...';
        }

        if (typeof onSubmitCallback === 'function') {
            onSubmitCallback({
                is_error
            });
        }
    });
}