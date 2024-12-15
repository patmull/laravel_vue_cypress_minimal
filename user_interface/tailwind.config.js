module.exports = {
    purge: ['./index.html', './src/**/*.{vue,js,ts,jsx,tsx}'],
    content: [
        "./index.html",
        "./src/**/*.{html,vue,js,ts,jsx,tsx}",
        "./node_modules/tw-elements/dist/js/**/*.js",
        "*.js"
    ],
    darkMode: "class", // or 'media' or 'class'
    theme: {
        extend: {},
    },
    variants: {
        extend: {},
    },
    plugins: [
        require('@tailwindcss/forms'),
    ],
}
