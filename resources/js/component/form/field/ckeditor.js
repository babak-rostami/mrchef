import { validateEditors } from '../../ckeditor/index';

export function checkCkeditorIsCorrect(form_id) {
    const form = document.getElementById(form_id);
    const editors = form.querySelectorAll('.bf-ckeditor-required');
    validateEditors(editors);
}