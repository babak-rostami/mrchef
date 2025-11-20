export const editors = new Map();

export function registerEditor(id, instance) {
    editors.set(id, instance);
}

export function getEditor(id) {
    return editors.get(id);
}
