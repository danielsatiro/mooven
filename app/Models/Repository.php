<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Repository extends Model
{
    protected $table = 'repositories';
    protected $primaryKey = 'id';
    protected $fillable = ['users_id','name','description'];
    protected $hidden = ['updated_at', 'created_at', 'login'];
    protected $appends = ['html_url'];

    public function getHtmlUrlAttribute() : string
    {
        return config('app.htmlUrl') . "/{$this->login}/{$this->name}";
    }

    public static function getUserRepositories($username)
    {
    	$repos = self::join('users', 'users_id', '=', 'users.id')
    		->where('users.login', $username)
    		->get(['repositories.id', 'repositories.name','description', 'login']);
    	return $repos;
    }
}
