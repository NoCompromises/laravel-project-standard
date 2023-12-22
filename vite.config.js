import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import vue from "@vitejs/plugin-vue";
import { readFileSync } from "fs";

export default defineConfig(({ mode }) => {
  const config = {
    plugins: [
      laravel({
        refresh: true,
        input: ["resources/css/app.css", "resources/js/app.js"],
      }),
      vue(),
    ],

    test: {
      globals: true,
      environment: "jsdom",
      coverage: {
        reporter: ["text", "html"],
        reportsDirectory: "resources/js/test-coverage",
        include: ["resources/js"],
      },
    },
  };

  if (mode === "development") {
    config.server = {
      port: 30098,
      strictPort: true,
      host: true,
      https: {
        key: readFileSync("docker/nginx/key.pem"),
        cert: readFileSync("docker/nginx/ssl.pem"),
      },
      hmr: {
        host: "project.domain",
      },
    };
  }

  return config;
});
