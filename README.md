# Infusionsoft OAuth2 Provider for Laravel Socialite

## Installation & Basic Usage

```bash
composer require codegreencreative/infusionsoft-socialite
```

### Add configuration to `config/services.php`

```php
'infusionsoft' => [
  'client_id' => env('INFUSIONSOFT_CLIENT_ID'),
  'client_secret' => env('INFUSIONSOFT_CLIENT_SECRET'),
  'redirect' => env('INFUSIONSOFT_REDIRECT_URI')
],
```

### Add provider event listener

Configure the package's listener to listen for `SocialiteWasCalled` events.

Add the event to your `listen[]` array in `app/Providers/EventServiceProvider`.

```php
protected $listen = [
    \SocialiteProviders\Manager\SocialiteWasCalled::class => [
        // ... other providers
        \Codegreencreative\InfusionsoftSocialite\InfusionsoftExtendSocialite::class.'@handle',
    ],
];
```

### Usage

You should now be able to use the provider like you would regularly use Socialite (assuming you have the facade installed):

To start the OAuth flow, call the redirect method to request an authorization code.

```php
return Socialite::driver('infusionsoft')->redirect();
```

Retrieve the token using the authorization code to do with what you will.

```php
$token = Socialite::driver('infusionsoft')->getToken();
```

Get account data for the Infusionsoft connection.

```php
$user return Socialite::driver('infusionsoft')->user();
```

### Returned User fields

-   `name`
-   `email`
-   `avatar`
