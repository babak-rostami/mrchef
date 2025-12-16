import './action/reply';
import './action/reaction';
import './action/show-replies';
import { isBodyValid } from './validation/body'


function sendComment(form_id, body_id, section) {
    if (isBodyValid(body_id, section)) {

        disableSubmitButton(section);

        removeErrors(section);

        document.getElementById(form_id).submit();
    }
}

function removeErrors() {
    document.getElementById('bcom-body-error').classList.add('hidden')
    document.getElementById('bcom-rep-body-error').classList.add('hidden')
}

function disableSubmitButton(section) {
    let submit_btn;
    if (section === 'comment') {
        submit_btn = document.getElementById('bcom-submit');
    } else if (section === 'reply') {
        submit_btn = document.getElementById('bcom-reply-submit');
    }

    submit_btn.disabled = true;
    submit_btn.classList.add('opacity-50', 'cursor-not-allowed');
    submit_btn.innerText = 'منتظر بمانید...';
    submit_btn.classList.remove('cursor-pointer');
}

window.sendComment = sendComment;