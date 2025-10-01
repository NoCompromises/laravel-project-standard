# DNS resolution

With OrbStack, you can expect that the `.local` domain is mapped locally.  However, you may want additional things to be mapped locally.

One easy way to do this for the entire `.test` top-level domain, is to run a lightweight tool called `dnsmasq`.

You can install it via Homebrew on a Mac with: `brew install dnsmasq`.

> If you've ever setup Valet, it already installed dnsmasq for you. You can verify if it's already installed by running
> `brew services` and see if `dnsmasq` is listed.

To confirm this is set up for your `.test` domain, check the content of `/opt/homebrew/etc/dnsmasq.d/test.conf` - or create it if necessary.

```
address=/.test/127.0.0.1
```

It may be required to restart dnsmasq for the changes to take effect.

```
brew services restart dnsmasq
```
