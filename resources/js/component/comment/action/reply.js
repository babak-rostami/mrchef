import './modal';

function replyModal(comment_id) {
    openBComReplyModal();

    const comment_input = document.getElementById('bcom-rep-comment-id');
    const reply_body = document.getElementById('bcom-rep-body');
    const reply_body_error = document.getElementById('bcom-rep-body-error');

    // clear last modal body and errors and set comment_id
    reply_body.value = '';
    // clear last modal errors and set comment_id
    reply_body_error.classList.add('hidden');
    // set comment_id
    comment_input.value = comment_id;

}

window.replyModal = replyModal;