<?php

namespace Tests\Unit;

use App\Models\Repository;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RepositoryTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testCreateRepositoryFail()
    {
        $this->expectException(\Exception::class);

        $data = [
        	'name' => '',
        	'description' => ''
    	];

        Repository::create($data);
    }

    public function testValidateUpdateRepository()
    {
    	$data = [];
    	$validate = Repository::validateUserRepository($data, 'U');
        $this->assertTrue($validate->fails());
    }
}
