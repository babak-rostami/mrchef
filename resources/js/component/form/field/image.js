export function checkImagesIsCorrect(form_id) {
}

const lastFiles = {}; // نگهداری فایل آخر برای هر input

export function initImage(image_id) {
    const realInput = document.getElementById(image_id);
    const picker = document.getElementById(`${image_id}-bf-img-picker`);
    const previewImg = document.getElementById(`${image_id}-bf-img-show`);
    const placeholder = document.getElementById(`${image_id}-bf-img-place`);
    const overlay = document.getElementById(`${image_id}-bf-img-over`);
    const bf_img_error_msg = document.getElementById(`${image_id}-bf-error`);
    const input_msg = document.getElementById(image_id + '-bf-msg');

    if (!lastFiles[image_id]) {
        lastFiles[image_id] = null;
    }

    if (!realInput) return;

    // کلیک روی باکس = باز شدن input
    picker.addEventListener('click', () => realInput.click());

    // انتخاب عکس
    realInput.addEventListener('change', function (e) {
        const file = e.target.files[0];

        // اگر کاربر Cancel زد
        if (!file) {
            if (lastFiles[image_id]) {
                // برگرداندن فایل قبلی
                realInput.files = lastFiles[image_id];
            }
            return;
        }

        // فایل جدید انتخاب شده → ذخیره برای بعد
        lastFiles[image_id] = e.target.files;

        const reader = new FileReader();
        reader.onload = function (event) {
            previewImg.src = event.target.result;
            previewImg.classList.remove('hidden');
            placeholder.classList.add('hidden');
            overlay.classList.remove('hidden');
            input_msg.classList.remove('hidden');
            bf_img_error_msg.classList.add('hidden');
        };

        reader.readAsDataURL(file);
    });
}

export function addImageRequire(image_id) {
    const field = document.getElementById(image_id);
    const field_title_el = document.getElementById(image_id + '-bf-label');
    const field_error = document.getElementById(image_id + '-bf-error');
    const field_msg = document.getElementById(image_id + '-bf-msg');
    const field_title = field_title_el ? field_title_el.innerText : '';

    if (field.value === '') {
        field_error?.classList.remove('hidden');
        field_error?.classList.add('block');
        field_msg?.classList.add('hidden');
        field.classList.add('border-red-400');

        if (field_error) {
            field_error.innerText = `${field_title} را انتخاب کنید`;
        }

    }
}