import { defaultMediaImage } from "@js/config";

export default {
    created(el, binding, vnode) {
        try {
            const fallBackImage = defaultMediaImage;
            const img = new Image();
            let original = vnode.props.src;
            img.src = original;
            el.src = original;
            img.onload = (e) => {
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
