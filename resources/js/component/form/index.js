import { validateForm } from './validation';
import { initEditor } from '../ckeditor/index';
import { initImage } from './field/image';
import { isErrorInForm } from './action';
import '../../utils/button';

export function createCkeditors(ckeditors) {
    ckeditors.forEach(editor => {
        initEditor(editor.id, editor.url);
    });
}

export function createImages(images) {
    images.forEach(image => {
        initImage(image);
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
            const submitBtn = form.querySelector('[type="submit"]');
            submitForm(submitBtn, 'در حال ثبت...')
        }

        if (typeof onSubmitCallback === 'function') {
            onSubmitCallback({
                is_error
            });
        }
    });
}