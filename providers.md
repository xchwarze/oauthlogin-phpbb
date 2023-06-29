## OAuth Configuration Guide

Please follow the instructions below to configure OAuth for your application.

## Application settings:

Setup OAuth2 config in `ACP -> Client communication -> Authentication` page.

Remember to replace `http://www.example.com/board` with your Board's URL!


### Github

1. Go to [Developer Settings](https://github.com/settings/developers) and create a "New OAuth App"

2. Setup OAuth2 Redirects:
```
    Homepage URL
    https://www.example.com/board/

    Authorization callback URL
    https://www.example.com/board/ucp.php
```

3. Copy and save the `Client ID` and `Client Secret`


### Discord

1. Go to [Developer Portal](https://discordapp.com/developers/applications) and create a "New application"

2. Setup OAuth2 Redirects:
   If you don't configure the url with all the parameters you will get this error: "Invalid OAuth2 redirect_uri"
```
    https://www.example.com/board/ucp.php?mode=login&login=external&oauth_service=discord
    https://www.example.com/board/ucp.php?i=ucp_auth_link&mode=auth_link&link=1&oauth_service=discord
```

3. Copy and save the `Client ID` and `Client Secret`


### Microsoft

1. Go to the [Azure Portal](https://portal.azure.com/), first click on Azure Active Directory in the left panel and then on [App Registrations](https://portal.azure.com/#blade/Microsoft_AAD_RegisteredApps/ApplicationsListBlade).

   Tick the "Accounts in any organizational directory and personal Microsoft accounts" checkbox.

2. Setup OAuth2 Redirects:
```
    https://www.example.com/board/ucp.php
```

3. First click on the link "Certificates & secrets" on the left and then on the `New client secret` button. 
   Complete the form by choosing the maximum validity period.

   Then you have to copy the **Value**; this will be your **Client Secret**, and the **Client ID** can be read from the general information.


### Reddit

1. Go to the [Reddit apps](https://ssl.reddit.com/prefs/apps) and click on the are you a developer? and press "create an app..."" button.

2. Setup OAuth2 Redirects:
Reddit only support **one** redirect.
```
    https://www.example.com/board/ucp.php?mode=login&login=external&oauth_service=reddit
```

3. Copy and save the `Client ID` (web app) and `Client Secret` (secret)


### Wordpress

1. Go to the [applications manager](https://developer.wordpress.com/apps/) and press "Create New Application" button.

2. Setup OAuth2 Redirects:
```
    https://www.example.com/board/ucp.php
```

3. Copy and save the `Client ID` and `Client Secret`
