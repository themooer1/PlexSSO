#!/bin/bash

OIDC_METADATA_URL='henlo'

cat <<EOF 
    # Setup OpenID Connect Authentication
    OIDCProviderMetadataURL ${OIDC_METADATA_URL}
    OIDCClientID ${OIDC_CLIENT_ID}
    OIDCClientSecret ${OIDC_CLIENT_SECRET}
    OIDCRedirectURI ${OIDC_REDIRECT_URI}
    OIDCResponseType code
    # OIDCScope "openid profile email"
    OIDCScope "openid profile email"
    OIDCSSLValidateServer Off
    OIDCCryptoPassphrase ${OIDC_CRYPTO_PASSPHRASE}
    OIDCPassClaimsAs environment
    OIDCClaimPrefix USERINFO_
    OIDCPassIDTokenAs payload
EOF