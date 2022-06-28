/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        "./app/Http/Controllers/**/*.php",
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue"
    ],
    theme: {
        extend: {},
    },
    plugins: []
}
