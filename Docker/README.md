# Docker

Preferred runtime for Docker is [OrbStack](https://orbstack.dev).

You can check individual folders for portions of a `docker-compose.yml` file - to build your final version for the unique project.

## Storing Containers in a Registry

When possible, we want to store our containers in a registry. This is great for development environment quality - as they're all the same. In addition, this configuration could be expanded for production deploys as well.

### GitLab Docker Container Registry Setup

* Create a [personal access token](https://docs.gitlab.com/ee/user/profile/personal_access_tokens.html#create-a-personal-access-token) in Gitlab.
    * Gitlab defaults to a one-month expiration. You probably want to change to the maximum 1-year expiration, so you don't need to regenerate as frequently.
    * Minimum required scopes: `read_registry`, `write_registry`
* Authenticate locally `docker login registry.gitlab.com`
    * Provide your gitlab username
    * The password is the personal access token you created

## Building Base Images

When possible, use a workflow to build these images. You can see an example of that in the Github folder.

If necessary to build them by hand, follow these steps:

> Any changes to the `docker/app` or `docker/web` folders would require a new base image to be built.

> If you've never built multi-platform images before, you might need to set that up first.
> You'll know if you get an error like `ERROR: Multi-platform build is not supported for the docker driver.`
> * `docker buildx create --name multiplaftorm --use`
> * `docker buildx install`

### Building for GitLab

```bash
# web image
docker build ./docker/web \
  --platform linux/amd64,linux/arm64 \
  --tag registry.gitlab.com/my-project/v3/app/web-image:latest \
  --push

# app image
docker build ./docker/app \
  --target base \
  --platform linux/amd64,linux/arm64 \
  --tag registry.gitlab.com/my-project/v3/app/app-image:latest \
  --push

# app-dev image
docker build ./docker/app \
  --target dev \
  --platform linux/amd64,linux/arm64 \
  --tag registry.gitlab.com/my-project/v3/app/app-image-dev:latest \
  --push
```
