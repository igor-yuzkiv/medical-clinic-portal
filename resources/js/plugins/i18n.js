import {createI18n} from 'vue-i18n'

import ua from "@/lang/ua_UK";

export const i18n = createI18n({
    legacy        : false,
    locale        : "ua",
    fallbackLocale: "ua",
    messages      : {
        ua
    },
})

export default function (app) {
    app.use(i18n);
}
