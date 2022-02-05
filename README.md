# Infusionsoft OAuth2 Provider for Laravel Socialite

## Installation & Basic Usage

```bash
composer require upwebdesign/infusionsoft-socialite
```

### Add configuration to `config/services.php`

```php
'infusionsoft' => [
    'client_id' => env('INFUSIONSOFT_CLIENT_ID'),
    'client_secret' => env('INFUSIONSOFT_CLIENT_SECRET'),
    'redirect' => env('INFUSIONSOFT_REDIRECT_URI', '/auth/infusionsoft/callback'),
    'auth' => env('INFUSIONSOFT_AUTH_URI', '/auth/infusionsoft/redirect'),
],
```

The `redirect` URI is a local URL that will generate the necessary information to send to Infusionsoft to connect via OAuth. The `callback` URI is where the user will be returned after successfully authenticated.

### Update your `.env`

Of course redirect and callback are both optional.

INFUSIONSOFT_CLIENT_ID=
INFUSIONSOFT_CLIENT_SECRET=
INFUSIONSOFT_REDIRECT_URI=
INFUSIONSOFT_CALLBACK_URI=

### Events

After the user has been authenticated, the `InfusionsoftSoclialiteAuthenticated` event will fire. You can listen for this event to create your new user in your account. Be sure to import the `InfusionsoftSoclialiteAuthenticated` class.

```php
protected $listen = [
    Registered::class => [SendEmailVerificationNotification::class],
    InfusionsoftSocialiteAuthenticated::class =>[
      // Place your listener here...
    ]
];
```

This event will return a Socialite User object with the following keys. Id and nickname will always be null because Infusionsoft does not use these fields with OAuth.

```
Laravel\Socialite\Two\User {#319 ▼
  +token: "********"
  +refreshToken: "********"
  +expiresIn: 86399
  +approvedScopes: array:1 [▶]
  +id: null
  +nickname: null
  +name: "Jane Doe"
  +email: "jane@example.com"
  +avatar: "https://cdn.com/avatar.jpg"
  +user: array:14 [▼
    "name" => "Jane Doe"
    "email" => "jane@example.com"
    "website" => "https://google.com/"
    "phone" => null
    "address" => array:9 [▶]
    "phone_ext" => null
    "time_zone" => "America/New_York"
    "logo_url" => "https://cdn.com/avatar.jpg"
    "currency_code" => "USD"
    "language_tag" => "en-US"
    "business_type" => null
    "business_goals" => []
    "business_primary_color" => null
    "business_secondary_color" => null
  ]
}
```

### Alt usage

You may also use the provider like you would regularly use Socialite (assuming you have the facade installed):

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
