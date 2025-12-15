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
                    reply_count: 0,
                });

                box.append(newComment);
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

window.showReplies = showReplies;

function cloneAndFillComment(existingId, newData) {
    const original = document.getElementById(`comment-box-${existingId}`);
    if (!original) {
        return;
    }

    // clone the element
    const clone = original.cloneNode(true);

    // update outer id
    clone.id = `comment-box-${newData.id}`;

    clone.classList.add("bg-gray-50");

    // update profile image
    clone.querySelector("img.rounded-full").src = newData.user_thumb;
    clone.querySelector("img.rounded-full").alt = `عکس ${newData.user_name}`;

    // username
    clone.querySelector(".font-black").textContent = newData.username;

    // full name
    clone.querySelector(".text-gray-600").textContent = newData.user_name;

    // time
    clone.querySelector(".text-gray-500").textContent = newData.time_text;

    // comment body
    const p = clone.querySelector("p");
    p.textContent = newData.body;

    // like count + ids
    clone.querySelector(
        `#category-comment-like-count-${existingId}`
    ).id = `category-comment-like-count-${newData.id}`;
    clone.querySelector(
        `#like-com-image-${existingId}`
    ).id = `like-com-image-${newData.id}`;
    clone
        .querySelector(".like-icon")
        .setAttribute("onclick", `likeCategoryComment('${newData.id}')`);

    // dislike
    clone.querySelector(
        `#category-comment-unlike-count-${existingId}`
    ).id = `category-comment-unlike-count-${newData.id}`;
    clone.querySelector(
        `#unlike-com-image-${existingId}`
    ).id = `unlike-com-image-${newData.id}`;
    clone
        .querySelector(".dislike-icon")
        .setAttribute("onclick", `unlikeCategoryComment('${newData.id}')`);

    // reply button
    clone
        .querySelector("button[onclick^='replyModal']")
        .setAttribute("onclick", `replyModal('${newData.id}')`);

    // -------------------------------
    //  NEW: remove or update reply section
    // -------------------------------
    const replyBtn = clone.querySelector("button[onclick^='showReplies']");
    const repliesBox = clone.querySelector(`#replies-box-${existingId}`);
    if (replyBtn) replyBtn.remove();
    if (repliesBox) repliesBox.remove();

    return clone;
}

window.showReplies = showReplies;
