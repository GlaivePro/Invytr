<?php
namespace GlaivePro\Invytr\Tests\Unit;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Session\Store;

use GlaivePro\Invytr\Http\Middleware;
use GlaivePro\Invytr\Tests\TestCase;

class MiddlewareTest extends TestCase
{
    public function testHandle()
    {     
        $responseMock = \Mockery::mock(Response::class);
        $responseMock->shouldReceive([
                'status' => 200,
                'works' => 'works'
            ])
            ->once();

        $sessionMock = \Mockery::mock(Store::class);
        $sessionMock->shouldReceive([
                'has' => true,
                'forget' => true
            ])
            ->once();

        $requestMock = \Mockery::mock(Request::class);
        $requestMock->shouldReceive([
                'session' => $sessionMock,
                'status' => 200
            ]);

        $middleware = new Middleware();    

        $result = $middleware->handle($requestMock, function() use ($responseMock) {
            return $responseMock;
        });

        $this->assertEquals('works', $result->works());
    }
}
