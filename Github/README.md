# Github

Use `.github/workflows/*` files as a base for your project.

The ci one contains an example of how to run tests and functionality in your project. You may or may not use all of the features.

The new-base-image one is for creating and registering docker containers into the GH registry.

Deploy is an envoyer-based deploy example.

Production merge makes it easy from the GitHub UI to merge `develop` into `main`, which could trigger a production deploy.
- It requires you to generate a personal access token with basic repo read/write permissions
- Then set up `GH_REGISTRY_PAT` as a secret in your repo/org using the newly-generated token 
