/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.jsx",
    ],
    theme: {
        extend: {
            colors: {
                brand: { DEFAULT: '#059669', hover: '#047857', light: '#d1fae5' },
                accent: '#f59e0b',
                dark: '#0f172a',  
            }
        }
    },
    plugins: [
        require('@tailwindcss/typography'),
    ],
}