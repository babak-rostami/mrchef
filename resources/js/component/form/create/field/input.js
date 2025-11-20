import { checkInputsMinLength } from '../../action'
import { convertToSlugFormat } from './slug';

export function checkInputsIsCorrect(form_id) {
    checkInputsMinLength(form_id);
}

//-----------------------------------------------------------------------------------------------//
// اگه کلاس اسلاگ داده بود کاربر فقط در فرمت اسلاگ بتونه بنویسه 
//-----------------------------------------------------------------------------------------------//
convertToSlugFormat();