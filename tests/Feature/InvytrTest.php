<?php
namespace GlaivePro\Invytr\Tests\Feature;

use GlaivePro\Invytr\Tests\TestCase;
use GlaivePro\Invytr\Tests\Models\User;
use GlaivePro\Invytr\Notifications\SetPassword;
use Illuminate\Support\Facades\Notification;

class InvytrTest extends TestCase
{
    /**
    * Setup the test environment.
    */
    protected function setUp()
    {
        parent::setUp();

        $this->loadLaravelMigrations();
    }

    /**
     * Check that the mail has been sent
     * @return void
     */
    public function testInvite()
    {
        Notification::fake();

        $user = new User;

        $user->email = 'user@example.com';

        \Invytr::invite($user);

        // Assert a notification was sent to the given users...
        Notification::assertSentTo(
            $user, SetPassword::class
        );
    }
}
