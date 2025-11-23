export function checkImagesIsCorrect(form_id) {
}

const realInput = document.getElementById('bf-main-image');
const picker = document.getElementById('bf-image-picker');
const previewImg = document.getElementById('bf-main-image-show');
const placeholder = document.getElementById('bf-image-placeholder');
const overlay = document.getElementById('bf-image-overlay');
const bf_img_error_msg = document.getElementById('bf-main-image-error');
let lastFile = null;

if (realInput) {
    // کلیک روی باکس = باز شدن input
    picker.addEventListener('click', () => realInput.click());

    // انتخاب عکس جدید
    realInput.addEventListener('change', function (e) {
        const file = e.target.files[0];

        // اگر هیچ فایلی انتخاب نشد = کاربر Cancel زده
        if (!file) {
            // بازگرداندن value قبلی
            if (lastFile) {
                realInput.files = lastFile;
            }
            return;
        }

        // فایل جدید انتخاب شده: ذخیره فایل فعلی برای دفعات بعد
        lastFile = e.target.files;

        const reader = new FileReader();
        reader.onload = function (event) {
            previewImg.src = event.target.result;

            previewImg.classList.remove('hidden');
            placeholder.classList.add('hidden');
            overlay.classList.remove('hidden');
            bf_img_error_msg.classList.add('hidden');
        };

        reader.readAsDataURL(file);
    });
}