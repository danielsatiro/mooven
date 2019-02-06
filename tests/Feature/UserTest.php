<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UserTest extends TestCase
{
	use DatabaseMigrations;

    /**
     * Show user by username.
     *
     * @return void
     */
    public function testShowUser()
    {
        $user = factory(\App\Models\User::class)->create();
    	$response = $this->getJson("/api/users/{$user->login}");
        $response->assertStatus(200);
        $response->assertJsonStructure([
	        	'id',
	            'login',
	            'name',
	            'avatar_url',
	            'html_url'
	        ]);    
    }

    public function testShowUserNotFound()
    {
        $username = '123Test';
    	$response = $this->getJson("/api/users/{$username}");
        $response->assertStatus(404);   
    }
}
