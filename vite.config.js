import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import vue from "@vitejs/plugin-vue";

const path = require("path");
const fs = require("fs");

export default defineConfig(({ mode }) => {
  const config = {
    plugins: [
      laravel({
        input: ["resources/css/app.css", "resources/js/app.js"],
      }),
      vue(),
    ],
    resolve: {
      alias: {
        "~public": path.resolve(__dirname, "public"),
        "@js": path.resolve(__dirname, "resources/js"),
      },
    },
    test: {
      environment: "jsdom",
      coverage: {
        reporter: ["text", "html"],
        reportsDirectory: path.resolve(
          __dirname,
          "resources/js/tests/coverage"
        ),
      },
    },
  };

  if (mode === "development") {
    config.server = {
      port: 30098,
      strictPort: true,
      host: true,
      https: {
        key: fs.readFileSync("docker/nginx/key.pem"),
        cert: fs.readFileSync("docker/nginx/ssl.pem"),
      },
      hmr: {
        host: "project.domain",
      },
    };
  }

  return config;
});
