import { defineConfig } from 'vite';

export default defineConfig({
    server: {
        host: true,
        port: 5173,
        strictPort: true,
        origin: 'https://vite.my-project.local',
        cors: {
            origin: ['https://my-project.local'],
        },
        hmr: {
            host: 'vite.my-project.local',
            protocol: 'wss',
        },
    },
});
