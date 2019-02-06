<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class RepositoryTest extends TestCase
{
	use DatabaseMigrations;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testListUserRepositories()
    {
        $user = factory(\App\Models\User::class)->create();
        factory(\App\Models\Repository::class)->create(['users_id' => $user->id]);
        factory(\App\Models\Repository::class)->create(['users_id' => $user->id]);

    	$response = $this->getJson("/api/users/{$user->login}/repos");
        $response->assertStatus(200);
        $response->assertJsonStructure([[
        	        	'id',
        	            'name',
        	            'description',
        	            'html_url'
        	        ]]);    
    }

    public function testListUserRepositoriesNotFound()
    {
        $user = factory(\App\Models\User::class)->create();
        
    	$response = $this->getJson("/api/users/{$user->login}/repos");
        $response->assertStatus(404);   
    }
}
