import axios from "axios";

function reactTobComment(commentId, reaction) {
    const likeBtn = document.getElementById(`bcomment-like-btn-${commentId}`);
    const dislikeBtn = document.getElementById(
        `bcomment-dislike-btn-${commentId}`
    );

    // اگر در حال پردازشه → هیچ کاری نکن
    if (
        likeBtn.dataset.loading === "true" ||
        dislikeBtn.dataset.loading === "true"
    ) {
        return;
    }

    // قفل کردن هر دو دکمه
    likeBtn.dataset.loading = "true";
    dislikeBtn.dataset.loading = "true";

    // انیمیشن کلیک
    animateBcommentReaction(commentId, reaction);

    axios
        .post(`/comments/${commentId}/reaction`, { reaction })
        .then((response) => {
            const {
                like_count,
                dislike_count,
            } = response.data;

            document.getElementById(
                `bcomment-like-count-${commentId}`
            ).textContent = like_count;
            document.getElementById(
                `bcomment-dislike-count-${commentId}`
            ).textContent = dislike_count;
        })
        .catch((err) => {
            console.error("like error");
        })
        .finally(() => {
            setTimeout(() => {
                // آزاد کردن قفل
                likeBtn.dataset.loading = "false";
                dislikeBtn.dataset.loading = "false";
            }, 1000);
        });
}

function animateBcommentReaction(commentId, reaction) {
    const img = document.querySelector(
        `#bcomment-${reaction}-btn-${commentId} img`
    );

    if (!img) return;

    const animationClass =
        reaction === "like"
            ? "bcomment-like-animate"
            : "bcomment-dislike-animate";

    img.classList.remove(animationClass);

    // trick برای restart animation
    void img.offsetWidth;

    img.classList.add(animationClass);
}

window.reactTobComment = reactTobComment;
