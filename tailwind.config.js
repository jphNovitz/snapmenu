/** @type {import('tailwindcss').Config} */

module.exports = {
    content: [
        "./assets/**/*.js",
        "./templates/**/*.html.twig",
    ],
    theme: {
        colors: {
            "transparent": "transparent",
            "light-text-base": "#3B413C",
            "light-text-secondary": "#9DB5B2",
            // "light-text-highlight": "#D64550",
            // "light-text-highlight": "#F9A03F",
            "light-text-highlight": "#5B9279",
            "dark-text-base": "#DAF0EE",
            "dark-text-secondary": "#94D1BE",
            // "dark-text-highlight": "#94D1BE",
            // "dark-text-highlight": "#F4D35E",
            "dark-text-highlight": "#95D7AE",
            "light-primary": "#94D1BE",
            "dark-primary": "#94D1BE",
            "light-neutral": "#DAF0EE",
            "light-neutral-light": "#efefef",
            "dark-neutral": "#3B413C",
            "dark-neutral-light":  "#9DB5B2",
        },
            // colors: {
            //     'clear': {
            //         light: '#fafffa',
            //         DEFAULT: '#F0FFF0',
            //         dark: '#d5e9d5',
            //     },
            //     'primary': {
            //         light: '#646864',
            //         // light: '#1b4332',
            //         DEFAULT: '#333533',
            //         dark: '#050705',
            //     },
            //     'secondary': {
            //         light: '#5D765D',
            //         DEFAULT: '#4A5E4A',
            //         dark: '#394A39',
            //     },
            // },
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
                    'position': 'positions',
                    'height': 'height',
                    'spacing': 'margin, padding',
                }
            },
        },
        plugins: [],
}
