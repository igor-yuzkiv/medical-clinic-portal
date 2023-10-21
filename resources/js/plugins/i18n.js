import {createI18n} from 'vue-i18n'

import ua_UK from "@/lang/ua_UK";

export const fallbackLocale = "ua_UK"

export function getCurrentLocale() {
    let currentLang = localStorage.getItem("locale");
    if (!currentLang) {
        try {
            let browserLang = (navigator.language || navigator.userLanguage).replace("-", "_")
            localStorage.setItem("locale", browserLang)
            currentLang = localStorage.getItem("browserLang") ?? fallbackLocale;
        } catch (e) {
            currentLang = fallbackLocale;
        }
    }
    console.log(currentLang);
    return currentLang;
}


export const i18n = createI18n({
    legacy        : false,
    locale        : getCurrentLocale(),
    fallbackLocale: fallbackLocale,
    messages      : {
        ua_UK
    },
})
