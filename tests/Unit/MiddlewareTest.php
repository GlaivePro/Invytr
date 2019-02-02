<?php
namespace GlaivePro\Invytr\Tests\Unit;

use GlaivePro\Invytr\Http\Middleware;
use GlaivePro\Invytr\Tests\TestCase;

class MiddlewareTest extends TestCase
{
    public function testHandle()
    {     
        $request = new \Illuminate\Http\Request();

        $middleware = new Middleware();        

        $result = $middleware->handle($request, function(){ return 'works';});
        $this->assertEquals('works', $result);
    }
}
