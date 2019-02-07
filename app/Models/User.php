<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $fillable = ['login', 'name','avatar_url'];
    protected $hidden = ['updated_at', 'created_at'];
    protected $appends = ['html_url'];

    public function getHtmlUrlAttribute() : string
    {
        return config('app.htmlUrl') . "/{$this->login}";
    }

    public static function validateUser(array $data, string $type = 'C') : \Illuminate\Validation\Validator
    {
    	$rules = [
		    'login' => 'required|string|unique:users|max:100',
		    'name' => 'required|string|max:100',
		    'avatar_url' => 'string|max:255'
		];

		if ($type == 'U') {
			$rules['id'] = 'required|integer|exists:users,id';
		}

		return \Validator::make($data, $rules);
    }

    public static function create(array $data)
    {
    	$validate = self::validateUser($data);
 
	    if ($validate->fails()){
	    	throw new \Exception($validate->messages()->__toString(), 412);
	    }

    	$user = new self;
    	$user->fill($data);
    	$user->save();

    	return $user;
    }
}
