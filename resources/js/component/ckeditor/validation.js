import { CKEDITOR_CONFIG } from "./config";
import { getEditor } from "./registry";

export function validateEditors(textareas) {
    let hasError = false;

    textareas.forEach(area => {
        const id = area.id;
        const editor = getEditor(id);

        if (!editor) return;

        const html = editor.getData().trim();
        const plain = html.replace(/<[^>]*>/g, '').replace(/&nbsp;/g, '').trim();

        if (plain.length === 0) {
            showError(id);
            hasError = true;
        }
    });

    return hasError;
}

function showError(id) {
    const err = document.getElementById(id + CKEDITOR_CONFIG.errorField);
    const msg = document.getElementById(id + CKEDITOR_CONFIG.msgField);
    const label = document.getElementById(id + CKEDITOR_CONFIG.lblField)?.innerText || "";

    if (err) {
        err.classList.remove("hidden");
        err.innerText = `${label} را تکمیل کنید`;
    }
    if (msg) msg.classList.add("hidden");
}
