import { checkInputsMinLength } from '../action'

//-----------------------------------------------------------------------------------------------//
// textarea هارو چک میکنه که مقدار معتبر باشه 
//-----------------------------------------------------------------------------------------------//
export function checkTextareasIsCorrect(form_id) {

    checkInputsMinLength(form_id);

}

export function addTextareaRequire(input_id) {
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