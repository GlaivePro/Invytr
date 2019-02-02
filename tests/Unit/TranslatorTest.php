<?php
namespace GlaivePro\Invytr\Tests\Unit;

use GlaivePro\Invytr\Helpers\Translator;
use GlaivePro\Invytr\Tests\TestCase;

class TranslatorTest extends TestCase
{
    /**
     * Check that the testReplaceFormLines method returns correct lines
     * @return void
     */
    public function testReplaceFormLines()
    {
        Translator::replaceFormLines();

        $this->assertSame(__('Reset Password'), 'Set Password');
    }

    /**
     * Check that the testReplaceResponseLines method returns correct response lines
     * @return void
     */
    public function testReplaceResponseLines()
    {
        Translator::replaceResponseLines();

        $this->assertSame(__('passwords.password'), 'Passwords must be at least six characters and match the confirmation.');
        $this->assertSame(__('passwords.reset'), 'Your password has been set!');
        $this->assertSame(__('passwords.token'), 'This token is invalid.');
        $this->assertSame(__('passwords.user'), 'We can\'t find a user with that e-mail address.');
    }
}
