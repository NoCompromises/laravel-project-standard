# Setting up an SSL certificate locally

Orbstack provides automatic TLS certificates for `.local` domains, but we may also need other certificates locally.  For example, Vite needs one.

To do this, we'll use `mkcert`, a simple tool for making locally-trusted development certificates.

To install on Mac with Homebrew, you can run:

`brew install mkcert nss`

For other platforms or configurations, you can refer to the [mkcert README](https://github.com/FiloSottile/mkcert)

Once `mkcert` is installed, we need to generate our local development root certificate authority:

> If you've used `mkcert` before, you can skip this step
> This command will likely prompt you for administrator access on macOS

`mkcert -install`

Then, generate the certificates for this project and put them into a location you can use. 

For a standard NC Docker project, you might do this:

`mkcert -cert-file docker/vite/ssl.pem -key-file docker/vite/key.pem my-project.test`

In this case, the `my-project.test` is mapped to localhost using a /etc/hosts file or dnsmasq. Check the Vite configuration on how to use this file.
