# Invytr

Laravel package for sending invitations allowing new users to set their password.

This package is mainly intended to be used together with Laravel's auth scaffolding. This package adds the ability to email new and existing users  a link to a page which will allow user to set up their password.

## Usage

Install it:

```bash
$ composer require glaivepro/invytr
```

You can now send invitations to your users. They will receive an email with a link for the password setting.

```php
// $user must extend Illuminate\Foundation\Auth\User
// Laravel's \App\User does this by default

\Invytr::invite($user);
```

## Customization

### Invite expiration

By default invite tokens will expire in the same time as password resets. The default of 60 minutes is usually not enough for invited users as they might not sign up immediately after their invite is sent.

To increase the expiration time for invites, you should add key `invites_expire` in `passwords.users` within `config/auth.php`. No you don't have to publish anything. Just add the time in minutes like this:

```php
'passwords' => [
	'users' => [
		'provider' => 'users',
		'table' => 'password_resets',
		'expire' => 60,
		'invites_expire' => 4320,  // This let's invites be valid for 3 days
	],
],
```

### Custom texts and localization

You can customize/localize the strings in your JSON localization files (found in `resources/lang`).

The invite email uses the following strings:

- `Account created` as the subject.
- `An account for you has been created! Please set a password for your account!` as the text.
- `Set Password` as the action link.

The password setting page uses only a single string:

- `Set Password` as the title of the panel (instead of `Reset Password`).

Responses to setting attempts uses these strings:

- `Your password has been set!`
- `Passwords must be at least six characters and match the confirmation.`
- `This token is invalid.`
- `We can't find a user with that e-mail address.`

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

By default this package uses the same `auth.passwords.reset` view as the Laravel's reset functionality. If you want more customization, make a `auth.passwords.set` view that includes all the same fields and posts the same request as does `auth.passwords.reset`.

### Password setting and responses

The resets are going through Laravel's `password.update` route and handled by the `reset` method on `App\Http\Controllers\Auth\ResetPasswordController`.

If you want to customize the handling and/or responses, edit that method. You can tell apart setting and resetting requests by checking the session.

```php
// in the ResetPasswordController

public function reset(Request $request)
{
	// something something
	
	if ($request->session()->has('invytr'))
	{
		// this is an invited user setting the password
	}
	
	// something else
}
```

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[link-packagist]: https://packagist.org/packages/GlaivePro/Invytr
[link-author]: https://github.com/larzs
[link-contributors]: ../../contributors
