import '../../library/ckeditor/ckeditor';
import '../../library/ckeditor/ckfinder';
import '../../library/ckeditor/de';

import { CKEDITOR_CONFIG } from "./config";
import { registerEditor } from "./registry";
import { giveUniqueId, waitUntilLoaded } from "./utils";

export function initEditor(editor_id, upload_url) {
    document.addEventListener("DOMContentLoaded", () => {
        document.querySelectorAll(`#${editor_id}`).forEach(el => {
            const id = el.id || giveUniqueId(el);
            initSingleEditor(el, id, upload_url);
        });
    });
}

function initSingleEditor(element, id, upload_url) {
    waitUntilLoaded(() => typeof ClassicEditor !== "undefined")
        .then(() => createEditor(element, id, upload_url))
        .catch(err => console.error("CKEditor load error:", err));
}

function createEditor(element, id, upload_url) {
    ClassicEditor.create(element, {
        language: CKEDITOR_CONFIG.language,
        toolbar: CKEDITOR_CONFIG.toolbarItems,
        removePlugins: CKEDITOR_CONFIG.pluginsToRemove,
        ckfinder: {
            uploadUrl: upload_url
        }
    })
        .then(editor => {
            registerEditor(id, editor);

            editor.model.document.on("change:data", () => {
                const err = document.getElementById(id + CKEDITOR_CONFIG.errorField);
                if (err) {
                    err.innerText = "";
                    err.classList.add("hidden");
                }
            });

            editor.editing.view.change(writer => {
                writer.setStyle(
                    "min-height",
                    CKEDITOR_CONFIG.minHeight,
                    editor.editing.view.document.getRoot()
                );
            });
        })
        .catch(console.error);
}
