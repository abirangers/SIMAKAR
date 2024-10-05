import { ref } from "vue";

export default function useFlashMessage() {
    const flashMessage = ref(null);
    let timeoutId = null;

    const setFlashMessage = (type, message, duration = type === "success" ? 5000 : 3000) => {
        flashMessage.value = { type, message };
        if (timeoutId) clearTimeout(timeoutId);
        timeoutId = setTimeout(
            () => {
                flashMessage.value = null;
                timeoutId = null;
            },
            duration
        );
    };

    return {
        flashMessage,
        setFlashMessage,
    };
}