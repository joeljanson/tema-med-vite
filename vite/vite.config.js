import { defineConfig } from "vite";
import liveReload from "vite-plugin-live-reload";

export default defineConfig({
	root: "./src", // Root directory for source files
	build: {
		outDir: "../../assets", // Output directory
		emptyOutDir: false, // Do not empty the output directory on each build
		rollupOptions: {
			// Explicitly define the input file (e.g., main.js or main.css)
			input: {
				main: "./src/main.js", // Replace with your actual entry file
			},
			output: {
				assetFileNames: (assetInfo) => {
					// Organize assets by type
					if (/\.(css)$/.test(assetInfo.name)) {
						return "css/main.css"; // Output CSS as main.css
					}
					if (/\.(woff2?|ttf|otf|eot|svg)$/.test(assetInfo.name)) {
						return "fonts/[name].[ext]";
					}
					return "[name].[ext]";
				},
				entryFileNames: "js/main.js", // Output main JS as main.js
				chunkFileNames: "js/[name].js", // Other JS chunks
			},
		},
	},
	server: {
		proxy: {
			"^/wp-admin": "http://localhost:8000", // WordPress admin
			"^/wp-content": "http://localhost:8000", // WordPress themes/plugins
			"^/wp-includes": "http://localhost:8000", // WordPress core
		},
	},
	plugins: [
		liveReload([
			"../../**/*.php", // Watch all PHP files in the WordPress theme
		]),
	],
});
