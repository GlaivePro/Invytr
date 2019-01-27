# Invytr

Laravel package for sending invitations allowing new users to set their password.

## Usage

Install it:

```bash
$ composer require glaivepro/invytr
```

You can now send invitations to your users. They will receive an email with a link for the password setting.

```php
// $user must extend Illuminate\Foundation\Auth\User
// Laravels \App\User does this by default

\GlaivePro\Invytr\Invytr::invite($user);
```

If you are using the frontend scaffolding by Laravel (created by `php artisan make:auth`), the initial setup is done. The users setting the password will see a page that's almost the same as `/password/reset`.

If you are not using the scaffolding provided by Laravel, you should make a view where the user can reset the password. Quickest way to do that is by asking us to create one like this:
```bash
$ php artisan vendor:publish --provider="GlaivePro\Invytr\Provider" --tag=view 
```

The password resetting functionality should be set up as well (at least backend-wise) as this tool will use many of the features, including the same table in the database.

## Customization

### Configuration

By default these invites will expire in the same time as password resets. The default of 60 minutes is usually not enough for invited users as they might not sign up immediately as their invite is sent.

To increase the expiration time for invites, you should... tbd. 
Publish our config? Or add key to config/auth.php ?

### Email

Similar to Laravel's reset password functionality, you can create a `sendPasswordResetNotification` method on your user model.
```php
public function sendPasswordResetNotification($token)
{
	// By default we send this:
	\Notification::send($this, new \GlaivePro\Invytr\Notifications\SetPassword($token));
}
```

### View

By default this package uses the same `auth.passwords.reset` view as the Laravel's reset functionality. If you don't use that functionality you should publish a template and modify it according to your needs.
```bash
$ php artisan vendor:publish --provider="GlaivePro\Invytr\Provider" --tag=view 
```

You can now modify the view in `auth.passwords.set`.


## Localization

You can localize the strings in your JSON localization files (found in `resources/lang`).

By default this package uses only a handful of string. You should define translations or customize the following strings:

- `Set Password` used as the title in the view and action button (link) in the email
- `Set Password Notification` used as the email subject
- `You are receiving this email because you need to set a password for your account.` - the email text


## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[link-packagist]: https://packagist.org/packages/GlaivePro/Invytr
[link-author]: https://github.com/larzs
[link-contributors]: ../../contributors
