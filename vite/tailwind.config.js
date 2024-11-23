/** @type {import('tailwindcss').Config} */
module.exports = {
	content: [
		"./src/**/*.{html,js}", // Filer i din Vite-rotmapp
		"../../**/*.php", // PHP-filer i WordPress-temat
	],
	theme: {
		extend: {},
	},
	plugins: [],
};
