import { addImageRequire } from "./field/image";
import { addInputRequire } from "./field/input";
import { addNumberRequire } from "./field/number";
import { addSelectRequire } from "./field/select";
import { addTextareaRequire } from "./field/textarea";
// feild منظورم input, select, ... اجزای یک فرم هستش

//-----------------------------------------------------------------------------------------------//
//به فیلد هایی که ضروری هستن متد پاک کردن خطا رو اضافه میکنم
// اینطوری اگه اون بخش رو تکمیل کنن خطا پاک میشه
// action is = input, change
//-----------------------------------------------------------------------------------------------//
export function removeErrorSectionOn(action) {
    document.querySelectorAll('.bf-input').forEach(s => {
        s.addEventListener(action, function () {
            removeErrorSection(this.id);
        });
    });
}
function removeErrorSection(id) {
    const field_error = document.getElementById(id + '-bf-error');
    if (field_error) {
        field_error.innerText = '';
        field_error.classList.add('hidden');
    }

    const field = document.getElementById(id);
    field.classList.remove('border-red-400');
}

//-----------------------------------------------------------------------------------------------//
//فیلدهایی که کلاس bf-is-required دارن میگیره
// بعد با متد addRequireErrorSection چک میشن اگه پر نشدن خطا بده 
//-----------------------------------------------------------------------------------------------//
export function requireValidation(form_id) {
    const form = document.getElementById(form_id);
    const inputs = form.querySelectorAll('.bf-is-required');
    addRequireErrorSection(inputs);
}
//-----------------------------------------------------------------------------------------------//
//فیلدهای ورودی رو چک میکنه اگه تکمیل نشده باشن خطا میده که این فیلد ضروری هستش 
//-----------------------------------------------------------------------------------------------//
function addRequireErrorSection(fields) {
    fields.forEach(field => {
        if (field.type == 'file') {
            addImageRequire(field.id);
        } else if (field.classList.contains('bf-input-text')) {
            addInputRequire(field.id);
        } else if (field.classList.contains('bf-textarea')) {
            addTextareaRequire(field.id);
        } else if (field.classList.contains('bf-select')) {
            addSelectRequire(field.id);
        } else if (field.classList.contains('bf-number-input')) {
            addNumberRequire(field.id);
        }
    });
}

//-----------------------------------------------------------------------------------------------//
//فیلدهایی که کلاس bf-min-length دارن میگیره
// بعد با متد addLengthErrorSection چک میشن اگه تعداد کاراکتر کم هستش خطا بده 
//-----------------------------------------------------------------------------------------------//
export function checkInputsMinLength(form_id) {
    const form = document.getElementById(form_id);
    const fields = form.querySelectorAll('.bf-min-length');
    addLengthErrorSection(fields);
}
//-----------------------------------------------------------------------------------------------//
// فیلد های ورودی رو چک میکنه اگه طول متن اون فیلد کمتر از data-minlength بود خطا میده 
//-----------------------------------------------------------------------------------------------//
function addLengthErrorSection(fields) {
    fields.forEach(field => {
        const field_id = field.id;

        const field_title_el = document.getElementById(field_id + '-bf-label');
        const field_error = document.getElementById(field_id + '-bf-error');
        const field_msg = document.getElementById(field_id + '-bf-msg');
        const field_title = field_title_el ? field_title_el.innerText : '';

        const input_min_len = Number(field.dataset.minlength);
        const input_length = field.value.length;

        if (input_length < input_min_len) {
            field_error?.classList.remove('hidden');
            field_error?.classList.add('block');
            field_msg?.classList.add('hidden');
            field.classList.add('border-red-400');

            if (field_error) {
                field_error.innerText = `${field_title} باید حداقل ${input_min_len} کاراکتر باشد`;
            }

        }
    });
}

//-----------------------------------------------------------------------------------------------//
// اگه خطایی داشتیم به اولین خطا اسکرول کنه 
//-----------------------------------------------------------------------------------------------//
export function isErrorInForm(form_id) {
    const form = document.getElementById(form_id);
    // همه پیام‌های خطا
    const allErrors = form.querySelectorAll('.bf-error-msg');
    // پیدا کردن اولین خطایی که hidden نیست
    const firstVisibleError = Array.from(allErrors).find(err => !err.classList.contains('hidden'));

    if (firstVisibleError) {
        // گرفتن نام فیلد
        let fieldName = firstVisibleError.id.replace('-bf-error', '');

        // اسکرول به لیبل فیلد
        document.getElementById(fieldName + "-bf-label").scrollIntoView({
            behavior: "smooth"
        });
        return 1;
    } else {
        return 0;
    }
}