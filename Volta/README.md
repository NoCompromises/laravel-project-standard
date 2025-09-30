# Node environment with Volta

The best option to ensure you're using the correct versions of Node and npm with this project is to install [Volta](https://volta.sh). This allows us to run the exact version of node and npm on the local host machine which allows quicker responsiveness than in a Docker container.

Volta will read the pinned versions of Node and npm from the `package.json` so you can be sure you're using the correct versions.

To install Volta, follow the instructions on the [Volta website](https://volta.sh).

To pin the versions of Node and npm, run:

```
volta pin node && volta pin npm
```

To install specific versions of Node and npm, run:

```
volta install node@22
```










### Node/npm

If you want to change the version of `node`, run `volta pin node@XYZ` where `XYZ` is the desired version. The same works for `npm` with `volta pin npm@XYZ`

This will update the corresponding sections of the `volta` object in `package.json`.

To verify the correct version is now running, you can run `node -v` or `npm -v`.
