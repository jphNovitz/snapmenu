/** @type {import('tailwindcss').Config} */

module.exports = {
    content: [
        "./assets/**/*.js",
        "./templates/**/*.html.twig",
    ],
    theme: {
            colors: {
                'clear': {
                    light: '#FFFFFF',
                    DEFAULT: '#F0FFF0',
                    dark: '#d5e9d5',
                },
                'primary': {
                    light: '#646864',
                    // light: '#1b4332',
                    DEFAULT: '#333533',
                    dark: '#050705',
                },
                'secondary': {
                    light: '#5D765D',
                    DEFAULT: '#4A5E4A',
                    dark: '#394A39',
                },
            },
            // colors: {
            //     'clear': {
            //         light: '#F5FFF5',
            //         DEFAULT: '#F0FFF0',
            //         dark: '#E0F2E0',
            //     },
            //     'primary': {
            //         light: '#043404',
            //         DEFAULT: '#021A02',
            //         dark: '#010D01',
            //     },
            //     'secondary': {
            //         light: '#5D765D',
            //         DEFAULT: '#4A5E4A',
            //         dark: '#394A39',
            //     },
            // },
            extend: {
                transitionProperty: {
                    'height': 'height',
                    'spacing': 'margin, padding',
                }
            },
        },
        plugins: [],
}
