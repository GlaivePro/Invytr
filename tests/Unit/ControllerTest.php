<?php
namespace GlaivePro\Invytr\Tests\Unit;

use GlaivePro\Invytr\Http\Controller;
use GlaivePro\Invytr\Tests\TestCase;

class ControllerTest extends TestCase
{
    /**
     * Check that the controller sets session variable
     * @return void
     */
    public function testSessionVariable()
    {
        \View::addLocation(getcwd().'/tests/views');
        \Auth::routes();

        $response = $this->get('/password/set/453453445345?email=email@example.com');

        $response->assertSessionHas('invytr', true);
    }

    /**
     * Check that the controller creates view with token and email
     * @return void
     */
    public function testShowSetForm()
    {
        \View::addLocation(getcwd().'/tests/views');
        \Auth::routes();

        $response = $this->get('/password/set/453453445345?email=email@example.com');

        $response->assertViewIs('auth.passwords.reset');
        $response->assertViewHas('token', '453453445345');
        $response->assertViewHas('email', 'email@example.com');
    }
}
