<?php
namespace GlaivePro\Invytr\Tests\Unit;

use Illuminate\Foundation\Auth\User;

class TestUser extends User
{
    public function sendPasswordSetNotification() {}
}