import { defaultMediaImage } from "@js/config";


/**
 * Credits to Arun Sivan: https://medium.com/@arunsivan18.8/vue-js-fallback-image-directive-4609a09afe4f
 */
export default {
    created(el, binding) {
        try {
            const { value } = binding;
            const fallBackImage = defaultMediaImage;
            const img = new Image();
            let error = fallBackImage;
            let original = el.src;
            if (typeof value === 'string') {
                error = value;
            }
            if (value instanceof Object) {
                error = value.fallBackImage || fallBackImage;
            }
            img.src = original;
            el.src = original;
            img.onload = () => {
                el.src = original;
            };
            img.onerror = () => {
                el.src = error;
            };
        } catch (e) {
            console.log(e)
        }
    }
}
