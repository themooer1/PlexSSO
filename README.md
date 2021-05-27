# PlexSSO
PlexSSO enables multiple users to sign into a guest Plex account using OpenID Connect.

## Where Can I Get It?
https://hub.docker.com/r/themooer1/plex-sso

## How Does It Work?

Here is a flow diagram:

![PlexSSOFlow](https://github.com/themooer1/PlexSSO/raw/master/PlexSSOFlow.png)

Which boils down to these steps:

1. Client asks for `index.html` which gets redirected to PlexSSO
2. PlexSSO return `index.html`, but injects `auth.js` which checks for the `myPlexAccessToken`.  If it's not found, `auth.js` redirects the client to `/sso/token.php`
3. `/sso/token.php` uses the username and password of a guest Plex account to generate a token and return it to the client, *BUT FIRST* it forces the client to authenticate with an OpenID Connect Identity Provider.

## How Can I Use It?

PlexSSO usually lives behind a proxy, which redirects `/` and `/sso/*` to PlexSSO and everything else to a Plex instance.  It is stateless and can be configured with the following environment variables:

Variable Name | Explanation | Default | Recommended
--------------|-------------|---------|------------
OIDC_METADATA_URL | Equivalent of Apache's OIDCProviderMetadataURL.  Provided by your IdP.  More info: https://developer.mobileconnect.io/provider-metadata ||
OIDC_CLIENT_ID | OpenID Connect client ID.  Provided by your IdP ||
OIDC_CLIENT_SECRET | OpenID Connect client secret.  Provided by your IdP ||
OIDC_REDIRECT_URL | URL where the IdP sends the client after login.  Can be anything in `/sso/`.  This is *NOT* the same as `PLEX_REDIRECT_URL`. || `https://<yourplexdomain>/sso/callback` (the container can't reliably determine your external domain name, so you must supply this)
OIDC_CRYPTO_PASSPHRASE | Used by Apache to sign a login state cookie.  Should be the same on all servers in an HA deployment. | `<RANDOMLY GENERATED>` | 
PLEX_GUEST_USER | Username of the shared Plex guest account (Share some libraries with this user) ||
PLEX_GUEST_PASSWORD | Password of the shared Plex guest account ||
PLEX_REDIRECT_URL | URL where PlexSSO will send the client after setting `myPlexAccessToken`.  Can be `https://<yourplexdomain>/web/index.html` or `https://app.plex.tv/` | `/web/index.html` | 
PLEX_BACKEND_BASE_URL | URL of Plex instance where PlexSSO will get the original version of pages like `/web/index.html` before it modifies them.  This will probably be an internal URL.  It cannot be the URL of PlexSSO because PlexSSO will infinitely try fetching `/web/index.html` from itself.  `https://app.plex.tv` used to work, but its `index.html` doesn't use the same names for resources as a self-hosted plex instance, so if your redirect url isn't `https://app.plex.tv/`, those pages will fail to load from your plex instance. |`https://app.plex.tv`|`http://internal-plex:32400`|
