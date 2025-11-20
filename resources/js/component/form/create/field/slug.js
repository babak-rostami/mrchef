//-----------------------------------------------------------------------------------------------//
// متدی که چند شرط زیر رو چک میکنه تا مطمئن بشم اسلاگی که کاربر مینویسه فرمت درستی داره
//-----------------------------------------------------------------------------------------------//
export function convertToSlugFormat() {
    document.querySelectorAll('.bf-input-slug').forEach(s => {
        s.addEventListener('input', function () {
            const field = this;
            let val = field.value;
            val = normalizeCase(val);
            val = removeInvalidChars(val);
            val = replaceSpaces(val);
            val = collapseDashes(val);
            val = preventStartWithNumber(val);

            field.value = val;
        });
    });
}
// تبدیل حروف بزرگ → کوچک
function normalizeCase(value) {
    return value.toLowerCase();
}

// حذف کاراکترهای غیرمجاز (فقط a-z و 0-9 و -)
function removeInvalidChars(value) {
    return value.replace(/[^a-z0-9- ]/g, ''); // اجازه اسپیس برای تبدیل در مرحله بعد
}

// تبدیل اسپیس به -
function replaceSpaces(value) {
    return value.replace(/\s+/g, '-');
}

// جلوگیری از ---- در وسط
function collapseDashes(value) {
    return value.replace(/-+/g, '-');
}

// جلوگیری از شروع با عدد یا خط تیره
function preventStartWithNumber(value) {
    return value.replace(/^[0-9-]+/, '');
}