# Node 24 in Docker

Run Node.js and npm commands inside a Docker container instead of on the host machine.

This configuration requires [OrbStack](https://orbstack.dev) for the Vite dev server domain routing.

## Setup

### 1. Add the docker-compose service

Copy the `node` service from `docker-compose.yml` into your project's docker-compose file.

Replace `my-project` with your project name in:

- `container_name`
- `dev.orbstack.domains` label (the `vite.` prefix is intentional)

### 2. Add the npm wrapper script

Copy the `npm` file to your project root and make it executable:

```bash
chmod +x npm
```

Update the container name inside the script to match your project.

### 3. Configure Vite for Docker

Copy `vite.config.js` to your project root (or merge with existing config).

Replace `my-project` with your project name in:

- `origin` - should match the OrbStack vite domain
- `cors.origin` - should match your app's OrbStack domain
- `hmr.host` - should match the OrbStack vite domain

## Usage

```bash
./npm run dev
```
