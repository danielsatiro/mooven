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

    public function testCreateUser()
    {
        $data = [
            'login' => $this->faker->unique()->userName,
            'name' => $this->faker->name,
            'avatar_url' => $this->faker->unique()->imageUrl(640, 480, 'people', true, 'avatar')
        ];
        
        $response = $this->postJson('/api/users', $data);
        $response->assertStatus(201)
            ->assertJsonStructure([
                'id',
                'login',
                'name',
                'avatar_url',
                'html_url'
            ]);  
    }

    public function testCreateUserFail()
    {
        $data = [
            'login' => '',
            'name' => '',
            'avatar_url' => ''
        ];
        
        $response = $this->postJson('/api/users', $data);
        $response->assertStatus(412)
            ->assertJsonStructure([
                'messages' => [
                    'login',
                    'name',
                    'avatar_url'
                ]                
            ]);  
    }
}
