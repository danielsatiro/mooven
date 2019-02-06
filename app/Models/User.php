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
}
