function openModal(id) {
    const overlay = document.getElementById(id + '-overlay');
    const modal = document.getElementById(id);

    // ریست انیمیشن
    modal.classList.remove('opacity-100', 'translate-y-0', 'scale-100');
    modal.classList.add('opacity-0', '-translate-y-6', 'scale-95');

    // نمایش بک‌دراپ
    overlay.classList.remove('hidden');
    overlay.classList.add('opacity-100');

    // انیمیشن ورود - با تاخیر کوچک تا CSS اعمال شود
    setTimeout(() => {
        modal.classList.remove('opacity-0', '-translate-y-6', 'scale-95');
        modal.classList.add('opacity-100', 'translate-y-0', 'scale-100');
    }, 10);

    document.body.classList.add('overflow-hidden');
}

function closeModal(id) {
    const overlay = document.getElementById(id + '-overlay');
    const modal = document.getElementById(id);

    // انیمیشن خروج
    modal.classList.remove('opacity-100', 'translate-y-0', 'scale-100');
    modal.classList.add('opacity-0', '-translate-y-6', 'scale-95');

    overlay.classList.remove('opacity-100');

    // بعد از تمام شدن انیمیشن پنهان کن
    setTimeout(() => {
        overlay.classList.add('hidden');
    }, 250);

    document.body.classList.remove('overflow-hidden');
}

// بستن با کلیک روی بک‌دراپ
document.addEventListener('click', function (e) {
    if (e.target.id.endsWith('-overlay')) {
        closeModal(e.target.id.replace('-overlay', ''));
    }
});

// بستن با ESC
document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') {
        document.querySelectorAll('[id$="-overlay"]').forEach(overlay => overlay.classList.add('hidden'));
        document.body.classList.remove('overflow-hidden');
    }
});


window.openModal = openModal;
window.closeModal = closeModal;