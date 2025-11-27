import { isSetRequireSelect } from './field/select'
import { checkInputsIsCorrect } from './field/input'
import { checkTextareasIsCorrect } from './field/textarea'
import { checkImagesIsCorrect } from './field/image'
import { checkNumbersIsCorrect } from './field/number'
import { checkCkeditorIsCorrect } from './field/ckeditor'
import { requireValidation, removeErrorSectionOn } from './action'

//-----------------------------------------------------------------------------------------------//
// بعد از سابمیت فرم این متد ها باید چک بشه 
//-----------------------------------------------------------------------------------------------//
export function validateForm(form_id) {

    //check is required field is complte
    requireValidation(form_id);

    //validate for every field
    fieldValidation(form_id);

    removeErrorSectionOn('change');
    removeErrorSectionOn('input');
}

//-----------------------------------------------------------------------------------------------//
// بعد از سابمیت اگه برای فیلد های مختلف جزئیات بیشتری لازم داری در بخش خودشون انجام بشه 
//-----------------------------------------------------------------------------------------------//
function fieldValidation(form_id) {
    //select validate
    isSetRequireSelect(form_id);
    //input validate
    checkInputsIsCorrect(form_id);
    //textarea validate
    checkTextareasIsCorrect(form_id);
    //image validate
    checkImagesIsCorrect(form_id);
    //number validate
    checkNumbersIsCorrect(form_id);
    //ckeditor validate
    checkCkeditorIsCorrect(form_id);
}