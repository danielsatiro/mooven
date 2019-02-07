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

    public function users()
    {
        return $this->belongsTo('App\Models\User', 'users_id');
    }

    public function getHtmlUrlAttribute() : string
    {
        if (empty($this->login)) {
            $this->login = (clone $this)->users->login;
        }

        return config('app.htmlUrl') . "/{$this->login}/{$this->name}";
    }

    public static function getUserRepositories($username)
    {
    	$repos = self::join('users', 'users_id', '=', 'users.id')
    		->where('users.login', $username)
    		->get(['repositories.id', 'repositories.name','description', 'login']);
    	return $repos;
    }

    public static function validateUserRepository(array $data, string $type = 'C') : \Illuminate\Validation\Validator
    {
        $rules = [
            'users_id' => 'required|integer|exists:users,id',
            'name' => ['required','string','max:100',
                        \Illuminate\Validation\Rule::unique('repositories')->where(function ($query) use ($data) {
                            return $query->where('users_id', $data['users_id'])
                                    ->where('name', $data['name']);
                        })],
            'description' => 'max:255'
        ];
        if ($type == 'U') {
            $rules['id'] = 'required|integer|exists:repositories,id';
        }
        return \Validator::make($data, $rules);
    }

    public static function create(array $data)
    {
        $validate = self::validateUserRepository($data);
 
        if ($validate->fails()){
            throw new \Exception($validate->messages()->__toString(), 412);
        }

        $repos = new self;
        $repos->fill($data);
        $repos->save();

        return $repos;
    }
}
