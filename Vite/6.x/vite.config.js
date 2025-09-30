import laravel from 'laravel-vite-plugin'
import { defineConfig } from 'vite'
import fs from 'fs';
import tailwindcss from "@tailwindcss/vite";

export default defineConfig(({ mode }) => {
  const config = {
    plugins: [
      tailwindcss(),
      laravel({
        input: ['resources/css/app.css', 'resources/js/app.js'],
        refresh: true,
      }),
    ],
  };

    if (mode === "development") {
        config.server = {
            host: true,
            https: {
                key: fs.readFileSync("docker/vite/key.pem"),
                cert: fs.readFileSync("docker/vite/cert.pem"),
            },
            hmr: {
                host: "my-project.test"
            }
        };
    }

  return config;
});
