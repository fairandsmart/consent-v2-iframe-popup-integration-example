# fair[&]smart - consent v2 iframe popup integration example

Some code to demonstrate how to use Fair and Smart Right Consent platform to collect user consent upon form submission.

## internals
Form submission is intercepted and an intermediate consent collect form is injected.
After consent has been collected, user is redirected to a page presenting its consents in json format.
For the exemple, we uses the email as subject, in violation with the principel of minimization ; don't do this at home.

## in a nutshell
* put your own values (organization ID, model ID etc ...) in config.ini ;
* build the image : `docker build --tag consent-v2-iframe-popup-integration-example .`
* run the container : `docker run consent-v2-iframe-popup-integration-example`

## configuration
Configuration can either be done in config.ini or using environment variables (especially useful when running using
docker).

| parameter                  | environment variable name  | config file key | 
|----------------------------|---|-----------------|
| auth server url            | AUTH_URL | auth_url        |
| auth server realm          | AUTH_REALM | auth_realm      |
| auth server clientid       | AUTH_CLIENT_ID | auth_client_id  |
| auth server username       | AUTH_USERNAME | auth_username   |
| auth server password       | AUTH_PASSWORD | auth_password   |
| consent manager server url | CM_URL | cm_url          |
| consent manager API Key | CM_KEY | cm_key          |

Configuration file is loaded from CONFIG_FILE_PATH (default : "config.ini"). 
 
## run example
Under docker, using a specific config file "my-config.ini" :

`docker run --mount type=bind,source=$PWD/my-config.ini,target=/var/www/html/my-config.ini -e CONFIG_FILE_PATH="my-config.ini" consent-v2-iframe-popup-integration-example`
