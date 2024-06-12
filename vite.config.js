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
      host: true,
      https: {
        key: readFileSync("docker/vite/key.pem"),
        cert: readFileSync("docker/vite/ssl.pem"),
      },
      hmr: {
        host: "project.domain",
      },
    };
  }

  return config;
});
