import axios from "axios";

function showReplies(comment_id) {
    const btn = document.getElementById(`show-replies-btn-${comment_id}`);
    const box = document.getElementById(`replies-box-${comment_id}`);

    // اگر در حال لود است، هیچ کاری نکن
    if (btn.dataset.loading === "true") return;

    // -------------------------
    // اگر قبلاً لود شده
    // -------------------------
    if (btn.dataset.loaded === "true") {
        const isOpen = btn.dataset.open === "true";

        if (isOpen) {
            box.classList.add("hidden");
            btn.textContent = "نمایش پاسخ‌ها";
            btn.dataset.open = "false";
        } else {
            box.classList.remove("hidden");
            btn.textContent = "پنهان کردن پاسخ‌ها";
            btn.dataset.open = "true";
        }

        return;
    }

    // -------------------------
    // بار اول → axios
    // -------------------------
    btn.dataset.loading = "true";
    btn.disabled = true;
    btn.classList.add("opacity-60", "cursor-not-allowed");

    axios
        .get(`/show-comment-replies/${comment_id}`)
        .then((response) => {
            const replies = response.data.replies;

            replies.forEach((reply) => {
                const newComment = cloneAndFillComment(comment_id, {
                    id: reply.id,
                    username: reply.user.username,
                    user_name: reply.user.name,
                    user_thumb: reply.user.thumb_url,
                    body: reply.body,
                    time_text: reply.created_at,
                    like_count: reply.like_count,
                    dislike_count: reply.dislike_count,
                });

                if (newComment) box.append(newComment);
            });

            box.classList.remove("hidden");
            btn.dataset.loaded = "true";
            btn.dataset.open = "true";
            btn.textContent = "پنهان کردن پاسخ‌ها";
        })
        .catch(() => {
            // اگر خطا خورد → اجازه تلاش مجدد
            btn.disabled = false;
            btn.classList.remove("opacity-60", "cursor-not-allowed");
        })
        .finally(() => {
            btn.dataset.loading = "false";
            btn.disabled = false;
            btn.classList.remove("opacity-60", "cursor-not-allowed");
        });
}

function cloneAndFillComment(parentId, data) {
    const original = document.getElementById(`comment-box-${parentId}`);
    if (!original) return null;

    const clone = original.cloneNode(true);

    // اول بخش پاسخ‌های خود والد را از کلون حذف کن
    clone.querySelector("button[onclick^='showReplies']")?.remove();
    clone.querySelector(`#replies-box-${parentId}`)?.remove();

    clone.id = `comment-box-${data.id}`;
    clone.classList.add("bg-gray-50");

    // کاربر و زمان
    const avatar = clone.querySelector("img.rounded-full");
    avatar.src = data.user_thumb;
    avatar.alt = `عکس ${data.user_name}`;
    clone.querySelector(".font-black").textContent = data.username;
    clone.querySelector(".text-gray-600").textContent = data.user_name;
    clone.querySelector(".text-gray-500").textContent = data.time_text;

    // متن
    clone.querySelector("p").textContent = data.body;

    // لایک و دیس‌لایک
    ["like", "dislike"].forEach((type) => {
        const btn = clone.querySelector(`#bcomment-${type}-btn-${parentId}`);
        const count = clone.querySelector(
            `#bcomment-${type}-count-${parentId}`,
        );

        btn.id = `bcomment-${type}-btn-${data.id}`;
        btn.dataset.loading = "false";
        btn.setAttribute("onclick", `reactTobComment('${data.id}','${type}')`);

        count.id = `bcomment-${type}-count-${data.id}`;
        count.textContent = data[`${type}_count`];
    });

    // دکمه پاسخ
    clone
        .querySelector("button[onclick^='replyModal']")
        .setAttribute("onclick", `replyModal('${data.id}')`);

    return clone;
}

window.showReplies = showReplies;
