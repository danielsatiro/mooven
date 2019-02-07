<?php

namespace Tests\Unit;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testCreateUserFail()
    {
        $this->expectException(\Exception::class);

        $data = [
        	'login' => '',
        	'name' => '',
        	'avatar_url' => ''
    	];

        User::create($data);
    }

    public function testValidateUpdateUser()
    {
    	$data = [];
    	$validate = User::validateUser($data, 'U');
        $this->assertTrue($validate->fails());
    }
}
