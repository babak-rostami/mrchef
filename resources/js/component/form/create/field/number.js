//-----------------------------------------------------------------------------------------------//
// input هارو چک میکنه که مقدار معتبر باشه 
//-----------------------------------------------------------------------------------------------//
export function checkNumbersIsCorrect(form_id) {
    const form = document.getElementById(form_id);

    const inputs = form.querySelectorAll('.bf-number-input');
    checkMinNumberError(inputs);
}

//-----------------------------------------------------------------------------------------------//
// وقتی تایپ میکنه فرمت ورودی رو چک میکنه عدد باشه
// و از عدد ماکسیموم بیشتر نشه
//-----------------------------------------------------------------------------------------------//
document.querySelectorAll('.bf-number-input').forEach(s => {
    s.addEventListener('input', function () {
        addMaxNumberLimit(this.id);
        addNumberFormat(this.id);
    });
});

//-----------------------------------------------------------------------------------------------//
// اگه عدد بزرگتر از data-maxnumber شد تبدیلش کن به data-maxnumber
//-----------------------------------------------------------------------------------------------//
function addMaxNumberLimit(id) {
    const field = document.getElementById(id);
    let input_number = Number(field.value);
    const max_number = Number(field.dataset.maxnumber);
    if (input_number > max_number) {
        field.value = max_number;
    }
}

//-----------------------------------------------------------------------------------------------//
// فقط اجازه وارد کردن عدد بده
//اعداد فارسی و عربی هم به انگلیسی تبدیل کن
//-----------------------------------------------------------------------------------------------//
function addNumberFormat(id) {
    const field = document.getElementById(id);
    field.value = field.value
        .replace(/[٠-٩]/g, d => "٠١٢٣٤٥٦٧٨٩".indexOf(d))   // عربی
        .replace(/[۰-۹]/g, d => "۰۱۲۳۴۵۶۷۸۹".indexOf(d))   // فارسی
        .replace(/[^0-9]/g, '');

}
//-----------------------------------------------------------------------------------------------//
// فیلد های ورودی از نوع number رو چک میکنه اگه عدد کمتر از data-minNumber بود خطا میده 
//-----------------------------------------------------------------------------------------------//
function checkMinNumberError(fields) {
    fields.forEach(field => {
        const field_id = field.id;

        const field_title_el = document.getElementById(field_id + '-label');
        const field_error = document.getElementById(field_id + '-error');
        const field_msg = document.getElementById(field_id + '-msg');
        const field_title = field_title_el ? field_title_el.innerText : '';

        const input_min_len = Number(field.dataset.minnumber);
        if (!input_min_len) {
            return;
        }
        const field_value = Number(field.value);

        if (field_value > 0 && field_value < input_min_len) {
            field_error?.classList.remove('hidden');
            field_error?.classList.add('block');
            field_msg?.classList.add('hidden');
            field.classList.add('border-red-400');

            if (field_error) {
                field_error.innerText = `${field_title} باید بزرگتر از عدد ${input_min_len} باشد`;
            }

        }
    });
}