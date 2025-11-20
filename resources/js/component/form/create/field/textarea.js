import { checkInputsMinLength } from '../../action'

//-----------------------------------------------------------------------------------------------//
// textarea هارو چک میکنه که مقدار معتبر باشه 
//-----------------------------------------------------------------------------------------------//
export function checkTextareasIsCorrect(form_id) {

    checkInputsMinLength(form_id);

}