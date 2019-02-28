<?php
namespace GlaivePro\Invytr\Tests\Unit;

//use MyPackage;
use Password;
use Notification;

use GlaivePro\Invytr\Facades\Invytr;
use GlaivePro\Invytr\Tests\TestCase;
use GlaivePro\Invytr\Notifications\SetPassword;

use Illuminate\Auth\Passwords\PasswordBroker;
use Illuminate\Foundation\Auth\User;

class InvytrTest extends TestCase
{
    protected $broker;
    protected $user;

    public function setUp() : void
    {
        parent::setUp();

        $this->broker = $this->getMockBuilder(PasswordBroker::class)
            ->disableOriginalConstructor()
            ->setMethods(['deleteToken', 'createToken'])
            ->getMock();

        Password::shouldReceive('broker')
            ->withNoArgs()
            ->once()
            ->andReturn($this->broker);

        $this->user = $this->getMockBuilder(User::class)
            ->disableOriginalConstructor()
            ->setMethods(null)
            ->getMock();
    }

    public function tearDown()
    {
        \Mockery::close();

        parent::tearDown();
    }

    /**
     * Check that the revoke intitation method works
     * @return void
     */
    public function testRevokeInvitation()
    {
        $this->broker->expects($this->once())
            ->method('deleteToken')
            ->with($this->equalTo($this->user));

        Invytr::revokeInvitation($this->user);
    }

    public function testInvite()
    {
        $token = '5349y539457937845';

        $this->broker->expects($this->once())
            ->method('createToken')
            ->with($this->equalTo($this->user))
            ->will($this->returnValue($token));

        $setPasswordMock = \Mockery::mock('overload:SetPassword');
        $setPasswordMock->shouldReceive('__construct')
            ->once()
            ->with($token)
            ->andReturn($setPasswordMock);

        Notification::shouldReceive('send')
            ->with(
                $this->user,
                \Mockery::type(SetPassword::class)
            )
            ->once();

        $response = Invytr::invite($this->user);

        $this->assertTrue($response);
    }

    public function testInviteCustomUser()
    {
        $token = '5349y539457937845';

        $user = $this->getMockBuilder(User::class)
            ->disableOriginalConstructor()
            ->setMethods(['sendPasswordSetNotification'])
            ->getMock();

        $this->broker->expects($this->once())
            ->method('createToken')
            ->with($this->equalTo($user))
            ->will($this->returnValue($token));

        $user->expects($this->once())
            ->method('sendPasswordSetNotification')
            ->with($token);

        $response = Invytr::invite($user);

        $this->assertTrue($response);
    }
}
