export async function sleep(ms) {
    return new Promise(resolve => setTimeout(resolve, ms));
}

export function sanitizeString(value) {
    if (!value || typeof value !== 'string') {
        return null;
    }
    return value.trim();
}
