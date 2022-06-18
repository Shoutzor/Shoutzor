import { defaultMediaImage } from "@js/config";

export default {
    created(el) {
        try {
            const fallBackImage = defaultMediaImage;
            const img = new Image();
            let original = el.src;
            img.src = original;
            el.src = original;
            img.onload = () => {
                el.src = original;
            };
            img.onerror = (e) => {
                el.src = fallBackImage;
            };
        } catch (e) {
            console.log("fallback image failed", e);
        }
    }
}
