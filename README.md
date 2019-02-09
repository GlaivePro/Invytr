# Invytr

[![Build Status](https://travis-ci.org/GlaivePro/Invytr.svg?branch=master)](https://travis-ci.org/GlaivePro/Invytr)

Laravel package for sending invitations allowing new users to set their password.

This package is mainly intended to be used together with Laravel's auth scaffolding. It adds the ability to email new and existing users  a link to a page which will allow user to set up their password.

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

## Warning

Doing `php artisan auth:clear-resets` will also flush your invite tokens if they are expired according to `auth.passwords.users.expire` config value. Your `auth.passwords.users.invites_expire` config value will be ignored.

## Change log

1.0 is the inital version of this package. Laravel 5.7 with PHP7.1 and PHP7.2 supported.

See [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## TODO

Add a trait that sets a random password and sends an invite when creating a new user.

Improve testing,
- Thoroughly cover Invytr, Controller, Middleware with unit tests
- Unit test the URL made in the notification
- Create more feature tests. For the pw setting page.

Improve code quality and consistency:
- fix docblocks
- imports vs fully qualified class names
- sort the imports
- alignment when chaining... maybe use styleCI?
- braces vs no braces for single line control structures
- helpers vs facades vs ...
- example: config() vs $request->session() vs \View::

Maybe expand the scope to also provide something like a MustResetPasswordOnNextVisit trait? Or that's another package?

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
