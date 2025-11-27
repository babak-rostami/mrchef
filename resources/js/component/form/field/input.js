import { checkInputsMinLength } from '../action'
import { convertToSlugFormat } from './slug';

export function checkInputsIsCorrect(form_id) {
    checkInputsMinLength(form_id);
}

//-----------------------------------------------------------------------------------------------//
// اگه کلاس اسلاگ داده بود کاربر فقط در فرمت اسلاگ بتونه بنویسه 
//-----------------------------------------------------------------------------------------------//
convertToSlugFormat();

export function addInputRequire(input_id) {
    const field = document.getElementById(input_id);
    const field_title_el = document.getElementById(field.id + '-bf-label');
    const field_error = document.getElementById(field.id + '-bf-error');
    const field_msg = document.getElementById(field.id + '-bf-msg');
    const field_title = field_title_el ? field_title_el.innerText : '';

    if (field.value === '') {
        field_error?.classList.remove('hidden');
        field_error?.classList.add('block');
        field_msg?.classList.add('hidden');
        field.classList.add('border-red-400');

        if (field_error) {
            field_error.innerText = `${field_title} را تکمیل کنید`;
        }
    }
}