export function checkImagesIsCorrect(form_id) {
}

const realInput = document.getElementById('bf-main-image');
const picker = document.getElementById('bf-image-picker');
const previewImg = document.getElementById('bf-main-image-show');
const placeholder = document.getElementById('bf-image-placeholder');
const bf_img_error_msg = document.getElementById('bf-main-image-error');

// وقتی باکس کلیک شد → input باز شود
picker.addEventListener('click', () => {
    realInput.click();
});

// وقتی عکس انتخاب شد → نمایش در باکس
realInput.addEventListener('change', function (e) {
    const file = e.target.files[0];
    if (!file) return;

    const reader = new FileReader();
    reader.onload = function (event) {
        placeholder.classList.add('hidden');
        previewImg.classList.remove('hidden');
        bf_img_error_msg.classList.add('hidden');
        previewImg.src = event.target.result;
    };

    reader.readAsDataURL(file);
});
