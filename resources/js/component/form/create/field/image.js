export function checkImagesIsCorrect(form_id) {

}

const bf_image = document.getElementById('bf-main-image');
if (bf_image !== null) {
    bf_image.addEventListener('change', function (e) {
        const file = e.target.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = function (event) {
            const img = document.getElementById('bf-main-image-show');
            img.src = event.target.result;
        };
        reader.readAsDataURL(file);
    });
}
