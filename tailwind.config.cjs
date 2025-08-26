/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {
            colors: {
                primary: '#0A0A4D',
                accent: '#E30613',
                light: '#ffffff',
            },
        },
    },
    plugins: [],
}
