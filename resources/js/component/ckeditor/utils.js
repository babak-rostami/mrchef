export function giveUniqueId(el) {
    const id = "editor-" + Math.random().toString(36).substr(2, 9);
    el.id = id;
    return id;
}

export function waitUntilLoaded(checkFn, timeout = 5000) {
    return new Promise((resolve, reject) => {
        const start = Date.now();

        function check() {
            if (checkFn()) return resolve();
            if (Date.now() - start > timeout) return reject("timeout!");

            requestAnimationFrame(check);
        }

        check();
    });
}
