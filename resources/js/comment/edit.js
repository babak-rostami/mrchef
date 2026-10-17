import {
    handleForm,
    createCkeditors,
    ckeditorUploadUrl,
} from "../component/form/index";

const form_id = "comment-update-form";

// اگه این صفحه برای ویرایش یه پاسخ باشه، اصلاً فیلد #content روی صفحه
// نیست (پاسخ‌ها ادیتور ندارن)؛ createCkeditors در اون حالت فقط هیچ
// کاری نمی‌کنه — نیازی به شرط گذاشتن اینجا نیست.
createCkeditors([
    { id: "content", url: ckeditorUploadUrl("comment", "content", form_id) },
]);

handleForm(form_id, ({ is_error }) => {
    if (!is_error) {
        document.getElementById(form_id).submit();
    }
});
