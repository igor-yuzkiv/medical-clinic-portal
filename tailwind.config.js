/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
        'node_modules/flowbite-vue/**/*.{js,jsx,ts,tsx}',
        'node_modules/flowbite/**/*.{js,jsx,ts,tsx}'
    ],
    theme  : {
        colors: {
            'sail': {
                '50' : '#f0f9ff',
                '100': '#e0f3fe',
                '200': '#b3e5fc',
                '300': '#7ed7fb',
                '400': '#3ac1f6',
                '500': '#10aae7',
                '600': '#0488c5',
                '700': '#056d9f',
                '800': '#085c84',
                '900': '#0d4d6d',
                '950': '#093148',
            },
            'indigo': {
                '50': '#f1f6fc',
                '100': '#e6eef9',
                '200': '#d1dff4',
                '300': '#b5caec',
                '400': '#98ace1',
                '500': '#7e91d6',
                '600': '#5f6dc5',
                '700': '#545eae',
                '800': '#46508d',
                '900': '#3e4671',
                '950': '#242842',
            },
            'java': {
                '50': '#edfefd',
                '100': '#d1fcfc',
                '200': '#a9f8f8',
                '300': '#6df1f3',
                '400': '#2be0e5',
                '500': '#0fc5cd',
                '600': '#0f9dab',
                '700': '#147d8a',
                '800': '#196571',
                '900': '#195360',
                '950': '#0b3841',
            },

        },
        extend: {},
    },
    plugins: [
        require('flowbite/plugin')
    ],
}

