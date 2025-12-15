// check if body has valid text

export function isBodyValid(body_id, section) {
    if (isInputEmpty(body_id, section)) {
        return 0;
    }
    return 1;
}

function isInputEmpty(body_id, section) {
    const body = document.getElementById(body_id);
    const text = body.value.trim();
    if (text === "") {
        showError('empty', section, body_id);
        return 1;
    }
    return 0;
}

let comment_error_time;
let reply_error_time;
function showError(type, section, body_id) {
    //set error text by type
    let error_text = '';
    if (type === 'empty') {
        error_text = "لطفاً نظر خود را وارد کنید.";
    }

    //is error for main comment or reply modal
    let error_id = `${body_id}-error`;
    if (section === 'reply') {
        clearInterval(reply_error_time);
    } else if (section == 'comment') {
        clearInterval(comment_error_time);
    }

    const errorBox = document.getElementById(error_id);
    errorBox.textContent = error_text;
    errorBox.classList.remove('hidden');

    // حذف پیام بعد از 3 ثانیه
    if (section === 'reply') {
        reply_error_time = setTimeout(() => {
            errorBox.classList.add('hidden');
        }, 3000);
    } else if (section == 'comment') {
        comment_error_time = setTimeout(() => {
            errorBox.classList.add('hidden');
        }, 3000);
    }

}
