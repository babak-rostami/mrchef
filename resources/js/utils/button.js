// دکمه رو disable میکنه که کاربر چند بار کلیک کزد فرم اشتباهی چند بار سابمیت نشه
window.submitForm = function (btn, wait_text) {
    setTimeout(() => {
        btn.disabled = true;
    }, 10);
    btn.classList.add('opacity-50', 'cursor-not-allowed');
    btn.innerText = wait_text;
    btn.classList.remove('cursor-pointer');
}